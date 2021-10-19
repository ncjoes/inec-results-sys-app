<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Lga;
use App\Models\Party;
use App\Models\Result;
use App\Models\State;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $search        = array_merge(['state_id' => null, 'lga_id' => null,], $request->only(['state_id', 'lga_id']));
        $states        = State::orderBy('state_name')->get();
        $requested_lga = Lga::where(['lga_id' => $search['lga_id']])->first();

        return view('results.index', [
            'states'        => $states,
            'search'        => $search,
            'requested_lga' => $requested_lga,
        ]);
    }

    public function showUnitResult(Request $request, Unit $unit)
    {
        return view('results.polling-unit-result', [
            'unit' => $unit,
        ]);

    }

    public function showLgaResult(Request $request, Lga $lga)
    {
        $parties       = Party::all();
        $states        = State::orderBy('state_name')->get();
        $search        = array_merge(['state_id' => $lga->state_id, 'lga_id' => $lga->id,], $request->only(['state_id', 'lga_id']));
        $requested_lga = Lga::where(['lga_id' => $search['lga_id']])->first();
        if (!is_null($search['lga_id']) && !$lga->is($requested_lga)) {
            return redirect()->route('lga-result', ['lga' => $requested_lga]);
        }

        return view('results.lga-result', [
            'lga'     => $lga,
            'parties' => $parties,
            'states'  => $states,
            'search'  => $search,
        ]);
    }

    public function showNewResultForm(Request $request)
    {
        $parties = Party::all();
        $states  = State::orderBy('state_name')->get();

        return view('results.new-result', [
            'states'  => $states,
            'parties' => $parties,
        ]);
    }

    public function createResult(Request $request): array
    {
        $data                    = $request->validate([
            'polling_unit_uniqueid' => 'required|exists:polling_unit,uniqueid',
            'party_abbreviation'    => 'required|exists:party,partyid',
            'party_score'           => 'required|numeric',
            'entered_by_user'       => 'required|string',
        ]);
        $data['date_entered']    = Carbon::now();
        $data['user_ip_address'] = $request->ip();

        Result::create($data);

        return ['status' => true, 'message' => 'Result Submitted!', 'redirect' => back()->getTargetUrl()];
    }
}