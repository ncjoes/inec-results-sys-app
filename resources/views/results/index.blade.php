@extends('layout')

@section('content')
    <div class="page-header">
        <h2>Search Results <small>(by State and LGA)</small></h2>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr class="">
                <td colspan="5">
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
                                            @foreach($state->lgas as $lga)
                                                <option value="{{$lga->lga_id}}" @if($lga->lga_id == $search['lga_id']) selected @endif>
                                                    {{$lga->lga_name}}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <br/>
                            <button type="submit" class="form-control btn btn-primary">Search</button>
                        </div>
                    </form>
                </td>
            </tr>

            @if(is_object($requested_lga))
                <tr>
                    <td>Polling Unit ID</td>
                    <td>Unit Name</td>
                    <td>Description</td>
                    <td>Location</td>
                    <td width="15%">...</td>
                </tr>
            @endif
            </thead>
            @if(is_object($requested_lga))
                <tbody>
                @foreach($requested_lga->units as $unit)
                    <tr>
                        <td>{{$unit->polling_unit_number}}</td>
                        <td>{{$unit->polling_unit_name}}</td>
                        <td>{{$unit->polling_unit_description}}</td>
                        <td>Lat.-{{$unit->lat}}, Long.-{{$unit->long}}</td>
                        <td><a href="{{route('unit-result',['unit'=>$unit->uniqueid])}}">View Unit Result</a></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <p class="text-center">
                            <a href="{{route('lga-result', ['lga'=>$requested_lga->uniqueid])}}" class="btn form-control btn-lg btn-default">
                                View Net Results for all Polling Units in {{$requested_lga->lga_name}} LGA
                            </a>
                        </p>
                    </td>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
@endsection
