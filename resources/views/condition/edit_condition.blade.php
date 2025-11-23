@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center p-8">
    <div class="w-full max-w-lg">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Edit Condition</h1>

            <form action="{{ route('condition.update', $condition->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="condition_name" class="block text-sm font-semibold text-gray-700 mb-1">Condition Name</label>
                    <input type="text" 
                           name="condition_name" 
                           id="condition_name" 
                           value="{{ $condition->condition_name }}" 
                           class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                           required>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('condition.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 transition shadow-md">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
