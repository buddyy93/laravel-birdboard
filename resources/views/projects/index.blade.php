@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h4 class="font-weight-bold">My Projects</h4>
        </div>
        <div class="col text-right">
            <a class="btn btn-sm btn-success" href="{{route('projects.create')}}"><i
                    class="fa fa-plus-circle mr-2"></i>New
                Project</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row">
                @forelse($projects as $project)
                    <div class="col-sm-12 col-lg-4 mb-3">
                        <div class="card rounded shadow h-100">
                            <div class="card-header py-0 border-left border-primary border-bottom-0"
                                 style="border-left-width: .3rem !important;">
                                <a href="{{route('projects.show', $project->id)}}"
                                   class="font-weight-bold py-0 mb-0">{{$project->title}}</a>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{str_limit($project->description,100)}}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">
                                    <small class="text-muted">{{$project->created_at->diffForHumans()}}
                                        by {{$project->owner->name}} / Last updated
                                        at {{$project->updated_at->diffForHumans()}}</small>
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <h4 class="text-center">No projects yet.</h4>
                @endforelse
            </div>
        </div>
    </div>
@endsection
