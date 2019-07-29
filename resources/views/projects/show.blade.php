@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">My Projects</a></li>
                    <li class="breadcrumb-item active"
                        aria-current="page">{{$project->title}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <h3 class="font-weight-bold">Tasks</h3>
            @forelse($project->tasks as $task)
                <div type="button"
                     class="card rounded shadow mb-3 border-0 border-left border-primary {{$task->completed ? 'bg-success text-white' : ''}}"
                     data-toggle="modal"
                     data-target=".edit-task-modal"
                     data-body="{{$task->body}}"
                     data-status="{{$task->completed}}"
                     data-action="{{$task->path()}}">
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
                    <p class="card-text">
                        {{$project->notes}}
                    </p>
                </div>
            </div>
            {!! Form::open(['route' => ['projects.update',$project->id],'id'=>'project_note_form']) !!}
            @method('PATCH')
            {!! Form::textarea('notes', '', ['class' => 'form-control','rows'=>5]) !!}
            {!! Form::close() !!}
            <div class="mt-3 text-center">
                <button type="submit"
                        form="project_note_form"
                        class="btn btn-sm btn-success">
                    <i class="fa fa-pen mr-2"></i>Add Note
                </button>
            </div>
        </div>
        <div class="col-4">
            <div class="card rounded shadow mb-3">
                <div class="card-header py-0 border-left border-primary border-bottom-0"
                     style="border-left-width: .3rem !important;">
                    <h5 class="font-weight-bold py-0 mb-0">{{$project->title}}</a>
                </div>
                <div class="card-body">
                    <p class="card-text">{{str_limit($project->description,100)}}</p>
                    @forelse($project->members as $member)
                        <img class="rounded-circle mx-1"
                             data-toggle="tooltip"
                             data-placement="bottom"
                             width="15%"
                             title="{{$member->name}}"
                             src="https://www.gravatar.com/avatar/{{md5($member->email)}}"
                             alt="{{$member->name}}">
                    @empty
                        <p>No members yet</p>
                    @endforelse
                </div>
            </div>
            <div class="card rounded shadow mb-3">
                <div class="row">
                    <div class="col-6">
                        <button type="button"
                                class="btn btn-sm btn-success m-1 form-control"
                                data-toggle="modal"
                                data-target=".create-task-modal">
                            <i class="fa fa-plus-circle mr-2"></i>Create Task
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button"
                                class="btn btn-sm btn-dark m-1 form-control"
                                data-toggle="modal"
                                data-target=".add-member-modal">
                            <i class="fa fa-user mr-2"></i>Add Member
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="{{route('projects.edit',$project->id)}}"
                           class="btn btn-sm btn-primary m-1 form-control">
                            <i class="fa fa-edit mr-2"></i>Edit Project
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit"
                                class="btn btn-sm btn-danger m-1 form-control"
                                form="delete_project_form">
                            <i class="fa fa-eraser mr-2"></i>Delete Project
                        </button>
                    </div>
                </div>
            </div>
            <div class="card rounded shadow">
                <div class="card-header py-0 border-left border-primary border-bottom-0"
                     style="border-left-width: .3rem !important;">
                    <h5 class="font-weight-bold py-0 mb-0">Activity Log</a>
                </div>
                <div class="card-body">
                    @foreach($project->activity as $activity)
                        @include("projects.activity.{$activity->log}")
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade create-task-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">Create new task</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
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
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit"
                            form="create_task_form"
                            class="btn btn-success">Create
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade edit-task-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">Edit Task</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
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
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit"
                            form="edit_task_form"
                            class="btn btn-success">Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade add-member-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">Project Member</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route'=>['project.add.member', $project->id],'id'=>'add_member_form']) !!}
                    @method('POST')
                    <div class="form-group">
                        {!! Form::label('users', 'Users', ['class' => 'control-label']) !!}
                        {!! Form::select('member', $users , null , ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                    <button type="submit"
                            form="add_member_form"
                            class="btn btn-success">Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => ['projects.destroy',$project->id],'id'=>'delete_project_form']) !!}
    @method('DELETE')
    {!! Form::close() !!}
    <script>
        $('[data-toggle="tooltip"]').tooltip()
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
