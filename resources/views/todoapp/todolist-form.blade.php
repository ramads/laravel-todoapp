<div class="alert alert-success" id="add-new-alert" style="display:none;">
    <em class="text-message"></em>
    <button type="button" class="close alert-close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

{!! Form::model($todolist, [
        'route' => $todolist->exists ? ['app.update', $todolist->id] : 'app.store',
        'method' => $todolist->exists ? 'PUT' : 'POST'
    ]) !!}

    <div class="form-group">
        <label for="" class="control-label">List Name</label>
        {!! Form::text('title', null, ['class' => 'form-control input-lg', 'id' => 'title']) !!}
        {!! Form::hidden('id') !!}
    </div>
    <div class="form-group">
        <label for="" class="control-label">Description</label>
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description', 'rows' => '2']) !!}
    </div>

{!! Form::close() !!}
