<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Lga;
use App\Models\State;
use App\Models\Unit;
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

    }

    public function showNewResultForm(Request $request)
    {

    }
}