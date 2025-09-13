<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
            'description' => 'nullable',
        ]);

        Categories::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category berhasil ditambahkan');
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
    public function edit(Categories $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $category->id,
            'description' => 'nullable',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category berhasil diupdate');
    }

    public function destroy(Categories $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category berhasil dihapus');
    }

}
