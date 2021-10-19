@extends('layout')

@section('content')
    <div class="page-header">
        <h2>Showing Results for {{$lga->lga_name}} LGA in {{$lga->state->state_name}}</h2>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading"><h5>LGA Info</h5></div>
        <div class="panel-body">
            <table class="table table-condensed table-striped">
                <tbody>
                <tr>
                    <td class="label">Description:</td>
                    <td class="value">{{$lga->description}}</td>
                </tr>
                <tr>
                    <td class="label">No. of Wards:</td>
                    <td class="value">{{$lga->wards()->count()}}</td>
                </tr>
                <tr>
                    <td class="label">No. of Polling Units:</td>
                    <td class="value">{{$lga->units()->count()}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <td rowspan="2">Polling Unit Number</td>
                <td rowspan="2">Name</td>
                <td colspan="{{$parties->count()}}">Party Scores</td>
            </tr>
            <tr>
                @php
                    $party_totals = []
                @endphp
                @foreach($parties as $party)
                    @php $party_totals[$party->partyid] = 0 @endphp
                    <td>{{$party->partyid}}</td>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($lga->units as $unit)
                <tr>
                    <td><strong>{{$unit->polling_unit_number}}</strong></td>
                    <td><strong>{{$unit->polling_unit_name}}</strong></td>
                    @php $party_scores = $unit->getPartyScores() @endphp
                    @foreach($parties as $party)
                        <td>{{$party_score = (array_key_exists($party->partyid, $party_scores) ? $party_scores[$party->partyid] : 0)}}</td>
                        @php $party_totals[$party->partyid] += $party_score @endphp
                    @endforeach
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2">Net Totals</td>
                @foreach($parties as $party)
                    <td><strong>{{$party_totals[$party->partyid]}}</strong></td>
                @endforeach
            </tr>
            </tfoot>
        </table>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <form method="get" class="form-horizontal">
                <div class="col-md-4">
                    <label for="states" class="control-label">State:</label>
                    <select name="state_id" id="states" class="form-control" required>
                        <option></option>
                        @foreach($states as $state)
                            @if($state->lgas()->count())
                                <option value="{{$state->state_id}}" @if($state->state_id == $search['state_id']) selected @endif>
                                    {{$state->state_name}}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="lgas" class="control-label">LGA:</label>
                    <select name="lga_id" id="lgas" class="form-control" required>
                        <option></option>
                        @foreach($states as $state)
                            @if($state->lgas()->count())
                                <optgroup label="{{$state->state_name}}">
                                    @foreach($state->lgas as $_lga)
                                        <option value="{{$_lga->lga_id}}" @if($_lga->is($lga)) selected @endif>
                                            {{$_lga->lga_name}}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <br/>
                    <button type="submit" class="form-control btn btn-primary">View Result</button>
                </div>
            </form>
        </div>
    </div>
    <p class="text-center">
        <a href="{{route('index',['lga_id'=>$lga->lga_id,'state_id'=>$lga->state->state_id])}}" class="btn form-control btn-default">
            Back to Dashboard
        </a>
    </p>
@endsection
