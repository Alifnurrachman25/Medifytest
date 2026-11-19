@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary mb-2">Kembali ke Daftar Kategori</a>
                <div class="card">
                    <div class="card-header">Detail Kategori</div>
                    <div class="card-body">
                        <table class="mb-3">
                            <tr>
                                <th>Nama</th>
                                <td class="px-2">:</td>
                                <td>{{ $kategori->nama }}</td>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <td class="px-2">:</td>
                                <td>{{ $kategori->kode }}</td>
                            </tr>
                        </table>

                        <h6>Item dalam kategori ini</h6>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Supplier</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategori->items as $item)
                                    <tr>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis }}</td>
                                        <td>{{ $item->supplier }}</td>
                                        <td><a href="{{ url('master-items/view/' . $item->kode) }}"
                                                class="btn btn-primary btn-sm">View</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada item</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <a href="{{ route('kategori.pdf', $kategori) }}" class="btn btn-success">Download PDF</a>
                        <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-info">Edit</a>
                        <form method="POST" action="{{ route('kategori.destroy', $kategori) }}" class="d-inline"
                            onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
