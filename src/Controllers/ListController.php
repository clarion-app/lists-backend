<?php

namespace ClarionApp\ListsBackend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ClarionApp\ListsBackend\Models\ItemList;
use ClarionApp\ListsBackend\Models\Item;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    /**
     * Display a listing of the lists.
     * @response array<ItemList>
     */
    public function index()
    {
        return response()->json(ItemList::with('items')->get());
    }

    /**
     * Store a newly created list in storage.
     * @bodyParam name string required The name of the list.
     * @bodyParam items array An array of items. Example: [{"name": "Item 1"}, {"name": "Item 2"}]
     * @response ItemList
     */
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

        return $list->load('items');
    }

    /**
     * Display the specified list.
     * @urlParam id required The ID of the list.
     * @response ItemList
     */
    public function show($id)
    {
        $list = ItemList::with('items')->findOrFail($id);
        return response()->json($list);
    }

    /**
     * Update the specified list in storage.
     * @urlParam id required The ID of the list.
     * @bodyParam name string The name of the list.
     * @bodyParam items array An array of items. Example: [{"name": "Item 1"}, {"name": "Item 2"}]
     * @response ItemList
     */
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

    /**
     * Remove the specified list from storage.
     * @urlParam id required The ID of the list.
     * @response null
     */
    public function destroy($id)
    {
        $list = ItemList::findOrFail($id);
        $list->items()->delete();
        $list->delete();

        return response()->json(null, 204);
    }

    /**
     * Remove the specified item from the list.
     * @urlParam list_id required The ID of the list.
     * @urlParam item_id required The ID of the item.
     * @response null
     */
    public function destroyItem($list_id, $item_id)
    {
        $list = ItemList::findOrFail($list_id);
        $item = $list->items()->findOrFail($item_id);
        $item->delete();

        return response()->json(null, 204);
    }

    /**
     * Clone the specified list.
     * @urlParam id required The ID of the list.
     * @response ItemList
     */
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
