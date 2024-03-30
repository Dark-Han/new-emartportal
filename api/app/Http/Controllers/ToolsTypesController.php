<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolsTypesRequest;
use App\Models\ToolsTypes;
use Illuminate\Http\Request;

class ToolsTypesController extends Controller
{
    public function index(Request $request)
    {
        $toolTypesQuery = ToolsTypes::orderBy('id', 'desc');
        if ($request->itemsPerPage == -1) {
            return ['data' => $toolTypesQuery->get()];
        }
        return $toolTypesQuery->paginate($request->itemsPerPage);
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
