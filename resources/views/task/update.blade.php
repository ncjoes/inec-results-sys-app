@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Update Task</h4></div>
                <div class="panel-body">
                    <form action="{{route('update-task',['task'=>$task->id])}}" method="post" class="ajax-form">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="name">Task name</label>
                            <input class="form-control" id="name" name="name" value="{{$task->name}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="project">Project</label>
                            <select class="form-control" id="project" name="project_id">
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}" @if($project->is($task->$project)) selected @endif>
                                        {{$project->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary form-control">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
            <br/>
            <p class="text-center">
                <a href="{{route('index')}}" class="btn btn-link">Back to Dashboard</a>
            </p>
        </div>
    </div>
@endsection