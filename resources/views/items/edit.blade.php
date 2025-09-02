<h1>Edit Item</h1>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('items.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Item Code:</label><br>
    <input type="text" name="item_code" value="{{ old('item_code', $item->item_code) }}" required><br><br>

    <label>Item Name:</label><br>
    <input type="text" name="item_name" value="{{ old('item_name', $item->item_name) }}" required><br><br>

    <label>Category:</label><br>
    <select name="category_id" required>
    @foreach($categories as $category)
        <option value="{{ $category->id }}"
            {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->category_name }} 
        </option>
    @endforeach
    </select><br><br>

    <label>Condition:</label><br>
    <select name="condition_id" required>
        @foreach($conditions as $condition)
            <option value="{{ $condition->id }}" {{ old('condition_id', $item->condition_id) == $condition->id ? 'selected' : '' }}>
                {{ $condition->condition_name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" required><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" value="{{ old('location', $item->location) }}" required><br><br>

    <button type="submit">Update</button>
</form>
<a href="{{ route('items.index') }}">Kembali</a>
