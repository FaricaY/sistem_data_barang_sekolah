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
        $conditions = Condition::all();
        return view('condition.index', compact('conditions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('condition.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'condition_name' => 'required|string|max:255',
        ]);

        Condition::create($request->all());

        return redirect()->route('condition.index')->with('success', 'Condition berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condition $condition)
    {
        return view('condition.edit', compact('condition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Condition $condition)
    {
        $request->validate([
            'condition_name' => 'required|string|max:255',
        ]);

        $condition->update($request->all());

        return redirect()->route('condition.index')->with('success', 'Condition berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Condition $condition)
    {
        $condition->delete();
        return redirect()->route('condition.index')->with('success', 'Condition berhasil dihapus');
    }
}
