<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolsTypesRequest;
use App\Models\ToolsTypes;

class ToolsTypesController extends Controller
{
    public function index()
    {
        return ToolsTypes::all();
    }

    public function store(ToolsTypesRequest $request)
    {
        return ToolsTypes::create($request->validated());
    }
    
    public function update(ToolsTypesRequest $request, ToolsTypes $toolsTypes)
    {
        $toolsTypes->update($request->validated());

        return $toolsTypes;
    }

    public function destroy(ToolsTypes $toolsTypes)
    {
        $toolsTypes->delete();

        return response()->json();
    }
}
