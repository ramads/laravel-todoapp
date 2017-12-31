<div class="modal fade" id="task-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Manage Tasks</h4>
        <p>of <strong id="modal-todolist-title"></strong></p>
      </div>
      <div class="modal-body">
        <div class="panel panel-default">
            <table class="table">
                <thread>
                    <td width="50" style="vertical-align: middle;">
                        <input type="checkbox" name="check_all" id="check-all">
                    </td>
                    <td>
                        <form id="task-form">
                            {{ csrf_field() }}
                            <input type="hidden" id="selected-todolist" value="">
                            <input id="task-title" type="text" name="title" placeholder="Enter New Task" class="task-input">
                        </form>
                    </td>
                </thread>
                <tbody id="task-modal-body">
                    
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer clearfix">
        <div class="pull-left">
            <a id='all-tasks' class="btn btn-xs btn-default filter-btn active">All</a>
            <a id='active-tasks' class="btn btn-xs btn-default filter-btn">Active</a>
            <a id='completed-tasks' class="btn btn-xs btn-default filter-btn">Completed</a>
        </div>
        <div class="pull-right">
            <small id="info-tasks-left"></small>
        </div>
      </div>
    </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
