@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <a href="{{ route('kategori.create') }}" class="btn btn-secondary mb-2">+ Kategori Baru</a>
            <div class="card">
                <div class="card-header">Daftar Kategori</div>
                <div class="card-body">
                    <form method="GET" class="row g-2 mb-3">
                        <div class="col"><input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ request('nama') }}"></div>
                        <div class="col"><input type="text" name="kode" class="form-control" placeholder="Kode" value="{{ request('kode') }}"></div>
                        <div class="col-auto">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead><tr><th>Kode</th><th>Nama</th><th>Jumlah Item</th><th></th></tr></thead>
                        <tbody>
                        @forelse($kategoris as $k)
                            <tr>
                                <td>{{ $k->kode }}</td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->items_count }}</td>
                                <td class="text-end">
                                    <a href="{{ route('kategori.show', $k) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('kategori.edit', $k) }}" class="btn btn-info btn-sm">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $kategoris->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
