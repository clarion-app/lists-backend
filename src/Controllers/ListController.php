<?php

namespace ClarionApp\ListsBackend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ClarionApp\ListsBackend\Models\ItemList;
use ClarionApp\ListsBackend\Models\Item;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function index()
    {
        return response()->json(ItemList::with('items')->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'items' => 'sometimes|array',
            'items.*.name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $list = ItemList::create(['name' => $request->name]);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $list->items()->create($item);
            }
        }

        return response()->json($list->load('items'), 201);
    }

    public function show($id)
    {
        $list = ItemList::with('items')->findOrFail($id);
        return response()->json($list);
    }

    public function update(Request $request, $id)
    {
        $list = ItemList::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'items' => 'sometimes|array',
            'items.*.name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $list->update($request->only('name'));

        if ($request->has('items')) {
            $list->items()->delete();
            foreach ($request->items as $item) {
                $list->items()->create($item);
            }
        }

        return response()->json($list->load('items'));
    }

    public function destroy($id)
    {
        $list = ItemList::findOrFail($id);
        $list->items()->delete();
        $list->delete();

        return response()->json(null, 204);
    }

    public function clone($id)
    {
        $originalList = ItemList::with('items')->findOrFail($id);
        $clonedList = $originalList->replicate();
        $clonedList->save();

        foreach ($originalList->items as $item) {
            $clonedItem = $item->replicate();
            $clonedItem->item_list_id = $clonedList->id;
            $clonedItem->save();
        }

        return response()->json($clonedList->load('items'), 201);
    }
}
