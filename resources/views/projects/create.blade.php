@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h4 class="font-weight-bold">Create Project</h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {!! Form::open(['route' => 'projects.store', 'method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
                {!! Form::text('title', '', ['class' => 'form-control','placeholder'=>'Title']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                {!! Form::textarea('description', '', ['class' => 'form-control','placeholder'=>'Description']) !!}
            </div>
            <div class="text-center">
                {{ Form::button('<i class="fa fa-save mr-2"></i>Submit', ['type' => 'submit', 'class' => 'btn btn-success'] )  }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
