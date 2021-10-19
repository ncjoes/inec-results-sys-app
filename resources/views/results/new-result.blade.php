@extends('layout')

@section('content')
    <div class="page-header">
        <h4>Add Polling Unit Result</h4>
    </div>

    <div class="panel panel-info">
        <div class="panel-body">
            <form id="addResultForm" method="post" enctype="multipart/form-data" class="ajax-form" action="{{route('new-result')}}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label for="unit" class="control-label">Polling Unit:</label>
                            <select id="unit" name="polling_unit_uniqueid" class="form-control" required>
                                <option></option>
                                @foreach($states as $state)
                                    @foreach($state->lgas as $lga)
                                        @foreach($lga->units as $unit)
                                            <option value="{{$unit->uniqueid}}">{{$unit->polling_unit_number}} - {{$unit->polling_unit_name}}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="party" class="control-label">Political Party:</label>
                            <select id="party" name="party_abbreviation" class="form-control" required>
                                <option></option>
                                @foreach($parties as $party)
                                    <option value="{{$party->partyid}}">{{$party->partyname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="party_score" class="control-label">Party Score</label>
                            <input type="number" id="party_score" name="party_score" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="entered_by_user" class="control-label">Agent's Name(s)</label>
                            <input type="text" id="entered_by_user" name="entered_by_user" class="form-control" required>
                        </div>

                        <br/>
                        <p>
                            <button id="addTaskButton" type="submit" class="btn btn-primary form-control">Submit Result</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('js/jquery.chained.selects.js')}}" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
    <script type="text/javascript">
        $(function () {
            $('#unit').chosen()
        });
    </script>
@endsection