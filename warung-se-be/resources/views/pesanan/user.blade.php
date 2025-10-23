@extends('layout')
@section('title', 'Pesanan User')
@section('content')

<h3>Buat Pesanan</h3>
<form action="{{ route('pesanan.store') }}" method="POST">
  @csrf
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Pilih</th>
        <th>Menu</th>
        <th>Harga</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      @foreach($menu as $m)
      <tr>
        <td><input type="checkbox" name="id_menu[]" value="{{ $m->id_menu }}"></td>
        <td>{{ $m->menu }}</td>
        <td>Rp {{ number_format($m->harga) }}</td>
        <td><input type="number" name="jumlah[]" class="form-control" value="1"></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mb-3">
    <label>Metode Bayar</label>
    <input type="text" name="metode_bayar" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Alamat</label>
    <textarea name="alamat" class="form-control" required></textarea>
  </div>
  <div class="mb-3">
    <label>Catatan</label>
    <textarea name="catatan" class="form-control"></textarea>
  </div>
  <button class="btn btn-success">Kirim Pesanan</button>
</form>
@endsection
