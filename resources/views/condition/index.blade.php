<h1>Conditions</h1>
<a href="{{ route('conditions.create') }}">Tambah Condition</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>ID</th>
        <th>Condition</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    @foreach($conditions as $condition)
    <tr>
        <td>{{ $condition->id }}</td>
        <td>{{ $condition->condition_name }}</td>
        <td>{{ $condition->description }}</td>
        <td>
            <a href="{{ route('conditions.edit', $condition->id) }}">Edit</a>
            <form action="{{ route('conditions.destroy', $condition->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
