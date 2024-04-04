<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationsController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::orderBy('id', 'desc')
            ->paginate($request->itemsPerPage);
        return $registrations;
    }

    public function getRegistrationActions(Request $request)
    {
        $actions = Action::where('registration_id', $request->id)->get();
        return $actions;
    }
}
