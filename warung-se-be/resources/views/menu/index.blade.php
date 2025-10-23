@extends('layout')
@section('title', 'Data Menu')
@section('content')

<h3>Data Menu</h3>
<a href="{{ route('menu.create') }}" class="btn btn-primary mb-3">+ Tambah Menu</a>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Nama Menu</th>
      <th>Harga</th>
      <th>Kategori</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($menu as $m)
    <tr>
      <td>{{ $m->id_menu }}</td>
      <td>{{ $m->menu }}</td>
      <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
      <td>{{ $m->kategori }}</td>
      <td>
        <a href="{{ route('menu.edit', $m->id_menu) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('menu.destroy', $m->id_menu) }}" method="POST" style="display:inline;">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
