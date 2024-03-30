<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolsRequest;
use App\Http\Resources\ToolsResource;
use App\Models\Tools;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index(Request $request)
    {
        $toolTypesQuery = Tools::with(['toolType'])->orderBy('id', 'desc');
        if ($request->itemsPerPage == -1) {
            return ['data' => $toolTypesQuery->get()];
        }
        return $toolTypesQuery->paginate($request->itemsPerPage);
    }

    public function store(ToolsRequest $request)
    {
        return Tools::create($request->validated())->load('toolType');
    }

    public function show(Tools $tools)
    {
        return new ToolsResource($tools);
    }

    public function update(ToolsRequest $request, Tools $tools)
    {
        $tools->update($request->validated());

        return new ToolsResource($tools);
    }

    public function destroy(Tools $tools)
    {
        $tools->delete();

        return response()->json();
    }
}
