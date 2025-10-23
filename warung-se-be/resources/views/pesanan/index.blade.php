@extends('layout')

@section('content')
<div class="container mt-4">
    <h2>Daftar Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Metode Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan as $p)
                <tr>
                    <td>{{ $p->id_pesanan }}</td>
                    <td>{{ $p->tanggal_pesanan }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badgeClass = match($p->status) {
                                'proses' => 'warning',
                                'diantar' => 'info',
                                'selesai' => 'success',
                                'batal' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($p->status) }}</span>
                    </td>
                    <td>{{ $p->metode_bayar }}</td>
                    <td>
                        <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $p->id_pesanan }}">
                            Detail
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Detail Pesanan -->
    @foreach ($pesanan as $p)
        <div class="modal fade" id="detailModal{{ $p->id_pesanan }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pesanan #{{ $p->id_pesanan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($p->detail as $d)
                                    <tr>
                                        <td>{{ $d->menu->menu ?? 'Menu dihapus' }}</td>
                                        <td>{{ $d->jumlah }}</td>
                                        <td>Rp {{ number_format($d->subtotal) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <p><strong>Metode Bayar:</strong> {{ $p->metode_bayar }}</p>
                        <p><strong>Alamat:</strong> {{ $p->alamat }}</p>
                        <p><strong>Catatan:</strong> {{ $p->catatan }}</p>

                        <hr>
                        <h5>Ubah Status Pesanan</h5>
                        <form action="{{ route('pesanan.updateStatus', $p->id_pesanan) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <select name="status" class="form-select" required>
                                    <option value="proses" {{ $p->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="diantar" {{ $p->status == 'diantar' ? 'selected' : '' }}>Diantar</option>
                                    <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ $p->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
