@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Update Project</h4></div>
                <div class="panel-body">
                    <form action="{{route('update-project', ['project' => $project->id])}}" method="post" class="ajax-form">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="name">Project name</label>
                            <input class="form-control" id="name" name="name" value="{{$project->name}}">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary form-control">Update Project</button>
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