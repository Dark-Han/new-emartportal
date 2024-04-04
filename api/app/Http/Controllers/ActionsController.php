<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    public function getRegistrationActions(Request $request)
    {
        $actions = Action::where('registration_id', $request->registrationId)->get();
        return $actions;
    }
}
