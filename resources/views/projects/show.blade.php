@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">My Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$project->title}}</li>
                </ol>
            </nav>
        </div>
        <div class="col text-right">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".create-task-modal">
                <i class="fa fa-plus-circle mr-2"></i>Create Task
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <h3 class="font-weight-bold">Tasks</h3>
            @forelse($project->tasks as $task)
                <div type="button"
                     class="card rounded shadow mb-3 border-0 border-left border-primary {{$task->completed ? 'bg-success text-white' : ''}}"
                     data-toggle="modal" data-target=".edit-task-modal"
                     data-body="{{$task->body}}" data-status="{{$task->completed}}" data-action="{{$task->path()}}">
                    <div class="card-body py-2">
                        <div class="card-text">{{$task->body}}</div>
                    </div>
                </div>
            @empty
                <p>No tasks yet</p>
            @endforelse

            <h3 class="font-weight-bold">General Notes</h3>
            <div class="card rounded shadow">
                <div class="card-body">
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti dolore
                        facilis, hic incidunt
                        mollitia
                        nesciunt nisi obcaecati quasi quisquam sint tenetur, vero! Dignissimos dolore magnam, natus
                        officiis
                        optio quasi sunt?</p>
                </div>
            </div>
            <textarea class="form-control" name="notes" rows="8"></textarea>
        </div>
        <div class="col-4">
            <div class="card rounded shadow">
                <div class="card-body">
                    <h5 class="card-text h4 font-weight-bold">{{$project->title}}</h5>
                    <p class="card-text">{{str_limit($project->description,100)}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade create-task-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['project.add.task', $project->id], 'method' => 'post','id'=>'create_task_form']) !!}
                    <div class="form-group">
                        {!! Form::label('task', 'Title', ['class' => 'control-label']) !!}
                        {!! Form::text('body', null, ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="create_task_form" class="btn btn-success">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade edit-task-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'edit_task_form']) !!}
                    @method('patch')
                    <div class="form-group">
                        {!! Form::label('task', 'Title', ['class' => 'control-label']) !!}
                        {!! Form::text('body', null, ['class' => 'form-control', 'id'=>'taskbody']) !!}
                    </div>
                    <div class="form-check form-check-inline">
                        <label>
                            {!! Form::radio('completed', '0', null,  ['id' => 'task_not_completed']) !!}
                            Not yet
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label>
                            {!! Form::radio('completed', '1', null,  ['id' => 'task_completed']) !!}
                            Done
                        </label>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="edit_task_form" class="btn btn-success">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.edit-task-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            $('#edit_task_form').attr('action', '/' + button.data('action'));
            modal.find('#taskbody').val(button.data('body'))
            if (button.data('status'))
                $("#task_completed").prop("checked", true);
            else
                $("#task_not_completed").prop("checked", true);
        })
    </script>
@endsection
