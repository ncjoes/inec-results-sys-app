@extends('layout')

@section('content')
    <div class="page-header">
        <h2>Showing Results for PU. Number-{{$unit->polling_unit_number}}</h2>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading"><h5>Polling Unit Details</h5></div>
        <div class="panel-body">
            <table class="table table-condensed table-striped">
                <tbody>
                <tr>
                    <td class="label">Name:</td>
                    <td class="value">{{$unit->polling_unit_name}}</td>
                </tr>
                <tr>
                    <td class="label">Description:</td>
                    <td class="value">{{$unit->polling_unit_description}}</td>
                </tr>
                <tr>
                    <td class="label">LGA:</td>
                    <td class="value">{{$unit->lga->lga_name}}</td>
                </tr>
                <tr>
                    <td class="label">Location:</td>
                    <td class="value">Lat-{{$unit->lat}}, Long-{{$unit->long}}</td>
                </tr>
                <tr>
                    <td class="label">Date-Entered:</td>
                    <td class="value">{{$unit->date_entered}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <td>Party</td>
                <td>Score</td>
                <td>Submitted By</td>
                <td width="15%">Date-Submitted</td>
            </tr>
            </thead>
            <tbody>
            @foreach($unit->results as $result)
                <tr>
                    <td><strong>{{$result->party_abbreviation}}</strong></td>
                    <td><strong>{{$result->party_score}}</strong></td>
                    <td>{{$result->entered_by_user}}</td>
                    <td>{{$result->date_entered}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">
                    <p class="text-center">
                        <a href="{{route('index',['lga_id'=>$unit->lga->lga_id,'state_id'=>$unit->lga->state->state_id])}}" class="btn form-control btn-default">
                            Back to Dashboard
                        </a>
                    </p>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
