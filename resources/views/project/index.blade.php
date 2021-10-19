@extends('layout')

@section('content')
    @if($projects->count())
        <div class="page-header">
            <h2>Projects</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Name</td>
                    <td width="25%">Tasks</td>
                    <td width="20%">Date/Time</td>
                    <td width="15%">...</td>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr id="{{$project->id}}">
                        <td><b>{{$project->name}}</b></td>
                        <td>
                            <a href="{{route('index',['project'=>$project->id])}}">
                                View {{$task_count = $project->tasks()->count()}} {{\Illuminate\Support\Str::plural('Task', $task_count)}}
                            </a>
                        </td>
                        <td>{{$project->created_at}}</td>
                        <td>
                            <a href="{{route('update-project', ['project'=>$project->id])}}" class="btn btn-default">edit</a>
                            <button class="btn btn-danger project-delete-btn" data-id="{{$project->id}}">delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="panel panel-info">
        <div class="panel-heading"><h4>Create Project</h4></div>
        <div class="panel-body">
            <form method="post" enctype="multipart/form-data" action="{{route('create-project')}}" class="ajax-form">
                @csrf
                <div class="form-group row">
                    <div class="col-md-9">
                        <label for="task-name" class="control-label">Project Name</label>
                        <input id="task-name" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <br/>
                        <button type="submit" class="btn btn-primary form-control">Create Project</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br/>
    <p class="text-center">
        <a href="{{route('index')}}" class="btn btn-link">Back to Dashboard</a>
    </p>
@endsection
