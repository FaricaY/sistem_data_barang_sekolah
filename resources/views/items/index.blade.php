<h1>Items</h1>
<a href="{{ route('items.create') }}">Tambah Item</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Name</th>
        <th>Category</th>
        <th>Condition</th>
        <th>Quantity</th>
        <th>Location</th>
        <th>Action</th>
    </tr>
    @foreach($items as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->item_code }}</td>
        <td>{{ $item->item_name }}</td>
        <td>{{ $item->category->category_name }}</td>
        <td>{{ $item->condition->condition_name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ $item->location }}</td>
        <td>
            <a href="{{ route('items.edit', $item->id) }}">Edit</a>
            <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
