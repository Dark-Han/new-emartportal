<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolTypesRequest;
use App\Models\ToolTypes;
use Illuminate\Http\Request;

class ToolTypesController extends Controller
{
    public function index(Request $request)
    {
        $toolTypesQuery = ToolTypes::orderBy('id', 'desc');
        if (!$request->exists('itemsPerPage') || $request->itemsPerPage == -1) {
            return ['data' => $toolTypesQuery->get()];
        }
        return $toolTypesQuery->paginate($request->itemsPerPage);
    }

    public function store(ToolTypesRequest $request)
    {
        return ToolTypes::create($request->validated());
    }

    public function update(ToolTypesRequest $request, ToolTypes $toolsTypes)
    {
        $toolsTypes->update($request->validated());

        return $toolsTypes;
    }

    public function destroy(ToolTypes $toolsTypes)
    {
        $toolsTypes->delete();

        return response()->json();
    }
}
