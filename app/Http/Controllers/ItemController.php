<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Categories; // FIX: Use the plural "Categories" model to match your setup
use App\Models\Condition;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        // Fetch paginated items to display on the main inventory page
        $items = Item::with(['category', 'condition'])->paginate(7); // Show 7 items per page
        return view('items.index', compact('items'));
    }

    public function create()
    {
        // Fetch all categories and conditions to populate the dropdowns in the form
        $categories = Categories::all(); // FIX: Use the plural "Categories" model
        $conditions = Condition::all();
        
        // Return the custom view name you created
        return view('items.create_items', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data from the "Add New Item" form
        $request->validate([
            'code' => 'required|unique:items|max:255',
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'quantity' => 'required|integer|min:0',
            'location' => 'required|max:255',
        ]);

        // Create and save the new item
        Item::create($request->all());

        // Redirect back to the main inventory list with a success message
        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    public function edit(Item $item)
    {
        // Fetch categories and conditions for the dropdowns
        $categories = Categories::all(); // FIX: Use the plural "Categories" model
        $conditions = Condition::all();
        
        // Return the custom view name, passing the item and dropdown data
        return view('items.edit_items', compact('item', 'categories', 'conditions'));
    }

    public function update(Request $request, Item $item)
    {
        // Validate the incoming data from the "Edit Item" form
        $request->validate([
            'code' => 'required|max:255|unique:items,code,' . $item->id,
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'quantity' => 'required|integer|min:0',
            'location' => 'required|max:255',
        ]);

        // Update the item's details
        $item->update($request->all());

        // Redirect back to the main inventory list with a success message
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        // Delete the item
        $item->delete();

        // Redirect back to the main inventory list with a success message
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}

