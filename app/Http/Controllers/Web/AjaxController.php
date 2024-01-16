<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\Country;

class AjaxController extends Controller
{
    public function getStates(Country $country)
    {
        return response()->json([
            'states' => $country->states->pluck('name', 'id')->toArray(),
        ]);
    }
}
