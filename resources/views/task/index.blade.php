@extends('layout')

@section('content')

    @if($projects->count())
        <div class="page-header">
            <h2>Dashboard</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="text-center">
                    <td colspan="4">
                        <form method="get" class="form-horizontal">
                            <label for="project-filter" class="control-label col-md-3">Filter by project:</label>
                            <div class="col-md-6">
                                <select name="project" id="project-filter" class="form-control">
                                    <option></option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}" @if($selected_project_id == $project->id) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="form-control btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td width="25%">Project</td>
                    <td width="20%">Date/Time</td>
                    <td width="15%">...</td>
                </tr>
                </thead>
                <tbody id="sortableTodo" class="sortable">
                @foreach($tasks as $task)
                    <tr data-role='list-divider' id="{{$task->id}}" class="{{'project-'.$task->project_id}}">
                        <td><b>{{$task->name}}</b></td>
                        <td>{{$task->project->name}}</td>
                        <td>{{$task->created_at->format('M d, Y H:i')}}</td>
                        <td>
                            <a href="{{route('update-task',['task'=>$task->id])}}" class="btn btn-default">edit</a>
                            <button class="btn btn-danger task-delete-btn" data-id="{{$task->id}}">delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><h4>Create Task</h4></div>
            <div class="panel-body">
                <form id="addTaskForm" method="post" enctype="multipart/form-data" action="{{route('add-task')}}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-7">
                            <label for="task-name" class="control-label">Task Name</label>
                            <input id="task-name" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="project" class="control-label">Project</label>
                            <select id="project" name="project_id" class="form-control">
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}" @if($selected_project_id == $project->id) selected @endif>{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <br/>
                            <button id="addTaskButton" type="submit" class="btn btn-primary form-control">Add Task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="text-center well">
            <p class="lead">Create Your First Project</p>
            <p class="text-center">
                <a href="{{route('projects')}}" class="btn btn-lg btn-success">Get Started</a>
            </p>
        </div>
    @endif
@endsection
