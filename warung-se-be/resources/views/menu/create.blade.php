@extends('layout')
@section('title', 'Tambah Menu')
@section('content')
<h3>Tambah Menu</h3>
<form action="{{ route('menu.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label>Nama Menu</label>
    <input type="text" name="menu" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Harga</label>
    <input type="number" name="harga" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Kategori</label>
    <select name="kategori" class="form-control">
      <option value="makanan">Makanan</option>
      <option value="minuman">Minuman</option>
      <option value="paket">Paket</option>
    </select>
  </div>
  <button class="btn btn-primary">Simpan</button>
</form>
@endsection
