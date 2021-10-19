@extends('layout')

@section('content')
    <div class="page-header">
        <h2>Search Results <small>(by State and LGA)</small></h2>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr class="">
                <td colspan="4">
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
                    <td>Ward ID</td>
                    <td>Ward Name</td>
                    <td>Ward Description</td>
                    <td width="15%">...</td>
                </tr>
            @endif
            </thead>
            @if(is_object($requested_lga))
                <tbody>
                @foreach($requested_lga->wards as $ward)
                    <tr>
                        <td>{{$ward->ward_id}}</td>
                        <td>{{$ward->ward_name}}</td>
                        <td>{{$ward->ward_description}}</td>
                        <td><a href="{{route('ward-result',['ward'=>$ward->uniqueid])}}">View Ward Result</a></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">
                        <p class="text-center">
                            <a href="{{route('lga-result',['lga'=>$requested_lga->uniqueid])}}" class="btn form-control btn-lg btn-default">
                                View Net Results for {{$requested_lga->lga_name}}
                            </a>
                        </p>
                    </td>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
@endsection
