@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center p-8">
    <div class="w-full max-w-2xl">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Add New Item</h1>

            <form action="{{ route('items.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Item Code -->
                    <div>
                        <label for="item_code" class="block text-sm font-semibold text-gray-700 mb-1">Item Code</label>
                        <input type="text" name="code" id="item_code" placeholder="Enter Item Code"
                               class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                    </div>

                    <!-- Item Name -->
                    <div>
                        <label for="item_name" class="block text-sm font-semibold text-gray-700 mb-1">Item Name</label>
                        <input type="text" name="name" id="item_name" placeholder="Enter Item Name"
                               class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Condition -->
                    <div>
                        <label for="condition" class="block text-sm font-semibold text-gray-700 mb-1">Condition</label>
                        <select name="condition_id" id="condition" class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                            <option value="" disabled selected>Select Condition</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->condition_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity" placeholder="Enter Quantity"
                               class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" id="location" placeholder="Enter Location"
                               class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('items.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 transition shadow-md">
                        Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
