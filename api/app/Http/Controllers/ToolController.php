<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolRequest;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $toolTypesQuery = Tool::with(['toolType'])->orderBy('id', 'desc');
        if ($request->has('itemsPerPage') && $request->itemsPerPage != -1) {
            return $toolTypesQuery->paginate($request->itemsPerPage);
        }
        return ['data' => $toolTypesQuery->get()];
    }

    public function store(ToolRequest $request)
    {
        return Tool::create($request->validated())->load('toolType');
    }

    public function show(Tool $tools)
    {
        return new ToolResource($tools);
    }

    public function update(ToolRequest $request, Tool $tools)
    {
        $tools->update($request->validated());

        return new ToolResource($tools);
    }

    public function destroy(Tool $tools)
    {
        $tools->delete();

        return response()->json();
    }
}
