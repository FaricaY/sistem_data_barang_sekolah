<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condition;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conditions = Condition::paginate(7);
        return view('condition.index', compact('conditions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // FIX: Point to your custom view name 'create_condition.blade.php'
        return view('condition.create_condition');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'condition_name' => 'required|string|max:255|unique:conditions,condition_name',
        ]);

        Condition::create($request->all());

        return redirect()->route('condition.index')->with('success', 'Condition created successfully.');
    }

    public function edit(Condition $condition)
    {
        return view('condition.edit_condition', compact('condition'));
    }

    public function update(Request $request, Condition $condition)
    {
        $request->validate([
            'condition_name' => 'required|string|max:255|unique:conditions,condition_name,' . $condition->id,
        ]);

        $condition->update($request->all());

        return redirect()->route('condition.index')->with('success', 'Condition updated successfully.');
    }

    public function destroy(Condition $condition)
    {
        $condition->delete();
        
        return redirect()->route('condition.index')->with('success', 'Condition deleted successfully.');
    }
}

