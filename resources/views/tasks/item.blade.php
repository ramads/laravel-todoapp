<tr class="task-item" id="task-{{ $task->id }}">
    <td>
        <input type="checkbox" data-url="{{ route('app.task.update', [$task->todoList->id, $task->id]) }}" {{ $task->completed ?: 'checked=true' }} class="check-item">
    </td>
    <td  class="task-item-title {{ $task->completed ?: 'done' }}">
        {{ $task->title }}
        <div class="row-buttons">
            <a id="delete-task" href="{{ route('app.task.destroy', [$task->todoList->id, $task->id]) }}" class="btn btn-xs btn-danger">
                <i class="glyphicon glyphicon-remove"></i>
            </a>
        </div>
    </td>
</tr>
