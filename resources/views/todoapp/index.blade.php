@extends('layouts.main')

@section('title', '| Homepage')

@section('content')
    <!-- Header -->
    @include('partials.header')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (session('message'))
            		<div class="alert alert-success">
            			<em>{{ session('message') }}</em>
            			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
      					<span aria-hidden="true">&times</span>
      				</button>
            		</div>
            	@endif

                @php
                    $count = count($todoLists);
                @endphp

                <div id="no-record-alert" class="alert alert-warning {{ $count > 0 ? 'hidden' : '' }}">
                       No Record found
                </div>

          		<div id="record-alert" class="alert alert-success" style="display:none">
          			<em class="message-body"></em>
          			<button type="button" class="close alert-close">
    					<span aria-hidden="true">&times</span>
    				</button>
          		</div>

                <div id='todolist-record' class="panel panel-default {{ ! $count > 0 ? 'hidden' : '' }}">
                    <ul class="list-group" id="todo-lists">
                        @foreach ($todoLists as $tl)

                            @include('todoapp.item', compact('tl'))

                        @endforeach
                    </ul>

                    <div class="panel-footer">
                        <small><span id="todolist-counter">{{ $count }}</span> list <span> {{ $count > 1 ? 'items' : 'item' }}</span></small>
                    </div>
                </div>
              </div>

              @include('todoapp.todolist-modal')

              @include('todoapp.task-modal')

        </div>
    </div>
@endsection
