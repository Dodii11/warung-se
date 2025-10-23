@extends('layout')
@section('title', 'Edit Menu')
@section('content')
<h3>Edit Menu</h3>
<form action="{{ route('menu.update', $menu->id_menu) }}" method="POST">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Nama Menu</label>
    <input type="text" name="menu" class="form-control" value="{{ $menu->menu }}" required>
  </div>
  <div class="mb-3">
    <label>Harga</label>
    <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}" required>
  </div>
  <div class="mb-3">
    <label>Kategori</label>
    <select name="kategori" class="form-control">
      <option value="makanan" {{ $menu->kategori == 'makanan' ? 'selected':'' }}>Makanan</option>
      <option value="minuman" {{ $menu->kategori == 'minuman' ? 'selected':'' }}>Minum</option>
      <option value="paket" {{ $menu->kategori == 'paket' ? 'selected':'' }}>Paket</option>
    </select>
  </div>
  <button class="btn btn-success">Update</button>
</form>
@endsection
