@php
    $task_count = $tl->tasks->count();
@endphp
<li id="todolist-{{ $tl->id }}" class="list-group-item">
    <h4 class="list-group-item-heading">{{ $tl->title }} <span class="badge">{{ $task_count }} {{ $task_count > 1 ? 'tasks' : 'task' }}</span></h4>
    <p class="list-group-item-text">{{ $tl->description }}</p>
    <div class="buttons">
        <a href="{{ route('app.show', $tl->id) }}" data-action="{{ route('app.task.store', $tl->id) }}" class="btn btn-info show-task-modal btn-xs" data-title="{{ $tl->title }}" title="Manage Tasks">
            <i class="glyphicon glyphicon-ok"></i>
        </a>
        <a href="{{ route('app.edit', $tl->id) }}" class="btn btn-default show-todolist-modal btn-xs edit" title="Edit todolist">
            <i class="glyphicon glyphicon-edit"></i>
        </a>
        {!! Form::open(['method' => 'DELETE', 'route' => ['app.destroy', $tl->id]]) !!}
            <button class="btn btn-danger btn-xs" title="Delete" data-toggle="confirmation" data-singleton="true">
                <i class="glyphicon glyphicon-remove"></i>
            </button>
        {!! Form::close() !!}
    </div>
</li>
