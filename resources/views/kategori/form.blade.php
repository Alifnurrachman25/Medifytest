@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary mb-2">Kembali ke Daftar Kategori</a>
            <div class="card">
                <div class="card-header">{{ $kategori->exists ? 'Edit' : 'Buat' }} Kategori</div>
                <div class="card-body">
                    <form method="POST" action="{{ $kategori->exists ? route('kategori.update', $kategori) : route('kategori.store') }}">
                        @csrf
                        @if($kategori->exists) @method('PUT') @endif

                        <div class="form-group mb-2">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kategori->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label>Kode</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $kategori->kode) }}" required>
                            @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button class="btn btn-primary mt-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
