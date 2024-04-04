<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftRequest;
use App\Models\Shift;

class ShiftController extends Controller
{
    public function index()
    {
        return Shift::all();
    }

    public function store(ShiftRequest $request)
    {
        return Shift::create($request->validated());
    }

    public function show(Shift $shift)
    {
        return $shift;
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $shift->update($request->validated());

        return $shift;
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        return response()->json();
    }
}
