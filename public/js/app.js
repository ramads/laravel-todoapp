// todolist
$('body').on('click', '.show-todolist-modal', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');

    $('#todolist-title').text(title);
    $('#todolist-save-btn').text(me.hasClass('edit') ? 'Update' : 'Save Change');

    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            $('#todolist-form').html(response);
        }
    });

    $('#todolist-modal').modal('show');
});



// close alert
$('body').on('click', '.alert-close', function() {
    $(this).parent().hide();
});

function showModalMessage(message) {
    $('#add-new-alert .text-message').text(message).parent().show();
}

function showRecordMessage(message) {
    $('#record-alert .message-body').text(message).parent().show();
}

function toggleAlertRecord(total) {
    if (total === 0) {
        $('#no-record-alert').removeClass('hidden');
        $('#todolist-record').addClass('hidden');
    } else if (total == 1) {
        $('#no-record-alert').addClass('hidden');
        $('#todolist-record').removeClass('hidden');
    }
}

// mendapatkan jumlah record data todolist
function getTotalRecord() {
    return $('.list-group-item').length;
}

function updateTodolistCounter() {
    var total = getTotalRecord();
    $('#todolist-counter').text(total).next().text(total > 1 ? 'items':'item');
    toggleAlertRecord(total);
}

// prevent keypress enter
$('#todolist-modal').on('keypress', ':input:not(textarea)', function(event){
    return event.keyCode != 13;
});

// insert data todolist - save data todolist
$('#todolist-save-btn').click(function(event){
    event.preventDefault();

    var form = $('#todolist-form form'),
        url = form.attr('action'),
        method = $('#todolist-form form input[name=_method]').val() === undefined ? 'POST' : 'PUT';
        // alert(method+" | "+$('#todolist-form form input[name=_method]').val());

    // reset errors messages
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url: url,
        method: method,
        data: form.serialize(),
        success: function(response){
            if (method === 'POST') {
                $('#todo-lists').prepend(response);

                showModalMessage('Todo list has been created.');

                form.trigger('reset');
                $('#title').focus();

                updateTodolistCounter();
            } else {
                var id = $('input[name=id]').val();
                if (id) {
                    $('#todolist-'+id).replaceWith(response);
                    $('#todolist-modal').modal('hide');
                    showRecordMessage('Record Updated!');
                }
            }
        },
        error: function(xhr){
            var errors = xhr.responseJSON;
            if ($.isEmptyObject(errors) === false) {
                $.each(errors, function(key, value){
                    $('#'+key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block">'+value+'</span>');
                });
            }
        }
    });
});


// Taks modal

$('body').on('click', '.show-task-modal', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.data('title'),
        action = me.data('action'),
        parent = me.closest('.list-group-item');

    $('#modal-todolist-title').text(title);
    $('#task-form').attr('action', action);
    $('#selected-todolist').val(parent.attr('id'));

    $.ajax({
        url:url,
        dataType: 'html',
        success: function(response) {
            $('#task-modal-body').html(response);
            initIcheck();
            countActiveTasks();
        }
    });

    $('#all-tasks').addClass('active').parent().children().not('#all-tasks').removeClass('active');

    $('#task-modal').modal('show');
});

function countActiveTasks(){
    var itemsLeft = $('tr.task-item:not(:has(td.done))').length;
    var showItemsLeft = (itemsLeft > 0) ? (itemsLeft+ " " + ((itemsLeft > 1) ? "items" : "item") + " left") : 'All done';
    $('#info-tasks-left').text(showItemsLeft);
}

function initIcheck() {
    $('input[type=checkbox]').iCheck({
        checkboxClass: 'icheckbox_square-green',
        increaseArea: '20%'
    });

    $('#check-all').on('ifChecked', function(e) {
        $('.check-item').iCheck('check');
    });

    $('#check-all').on('ifUnchecked', function(e) {
        $('.check-item').iCheck('uncheck');
    });

    $('.check-item').
        on('ifChecked', function(e){
            var checkbox = $(this);
            markTheTask(checkbox);
        })
        .on('ifUnchecked', function(e) {
            var checkbox = $(this);
            markTheTask(checkbox);
        });
}

function markTheTask(checkbox) {
    var url = checkbox.data('url'),
    completed = checkbox.is(":checked");
    console.log(completed);

    $.ajax({
        url: url,
        type: "PUT",
        data: {
            completed: completed,
            _token: $('input[name=_token]').val()
        },
        success: function(response) {
            if (response) {
                var nextTd = checkbox.closest('td').next();
                if (completed) {
                    nextTd.addClass('done');
                } else {
                    nextTd.removeClass('done');
                }
                countActiveTasks();
            }
        }
    });
}

$('.filter-btn').click(function(e) {
    e.preventDefault();

    $(this).addClass('active').parent().children().not(e.target).removeClass('active');

    var id = $(this).attr('id');
    if (id == 'all-tasks') {
        $('.task-item').show();
    } else if (id == 'active-tasks') {
        $('tr.task-item:has(td.done)').hide();
        $('tr.task-item:not(:has(td.done))').show();
    }else if (id == 'completed-tasks') {
        $('tr.task-item:has(td.done)').show();
        $('tr.task-item:not(:has(td.done))').hide();
    }
});

$('#task-form').submit(function(e){
    e.preventDefault();
    var form = $(this),
        url = form.attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            $('#task-modal-body').prepend(response);
            form.trigger('reset');
            initIcheck();
            countActiveTasks();
            countAllTasksSelectedList();

        }
    });
});

function countAllTasksSelectedList() {
    var total = $('#task-modal-body tr').length,
        selectedTodolistId = $('#selected-todolist').val();
        console.log(total);

    $('#' + selectedTodolistId).find('span.badge').text(total + " " + (total > 1 ? "tasks" : "task"));
}

$('#task-modal-body').on('click', '#delete-task', function(e){
    e.preventDefault();

    var anchor = $(this),
        url = anchor.attr('href');
        $.ajax({
            url:url,
            type: 'DELETE',
            data: {
                _token: $('input[name=_token]').val()
            },
            success: function(response) {
                $('#task-' + response.id).fadeOut(function(){
                    $(this).remove();
                    countActiveTasks();
                    countAllTasksSelectedList();
                });
            }
        });
});
