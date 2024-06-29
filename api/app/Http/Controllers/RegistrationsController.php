<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRegistrationRequest;
use App\Models\Action;
use App\Models\Registration;
use App\Service\RegistrationService;
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

    public function create(CreateRegistrationRequest $request, RegistrationService $registrationService)
    {
        $registration = $registrationService->create($request->validated());
        return response()->json(['registration' => $registration], 201);
    }
}
