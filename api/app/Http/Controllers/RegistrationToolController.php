<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationToolRequest;
use App\Models\RegistrationTool;

class RegistrationToolController extends Controller
{
    public function index()
    {
        return RegistrationTool::all();
    }

    public function store(RegistrationToolRequest $request)
    {
        return RegistrationTool::create($request->validated());
    }

    public function show(RegistrationTool $registrationTool)
    {
        return $registrationTool;
    }

    public function update(RegistrationToolRequest $request, RegistrationTool $registrationTool)
    {
        $registrationTool->update($request->validated());

        return $registrationTool;
    }

    public function destroy(RegistrationTool $registrationTool)
    {
        $registrationTool->delete();

        return response()->json();
    }
}
