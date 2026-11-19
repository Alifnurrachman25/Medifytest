<form method="POST" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required  value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required  value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <optio @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <optio @if($selected == 'Umum') selected @endif>Umum</option>
            <optio @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    @php $selectedKategori = old('kategori_ids', $item->exists ? $item->kategoris->pluck('id')->all() : []); @endphp
<div class="form-group">
    <label>Kategori</label>
    @forelse($kategoris as $k)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="kategori_ids[]" value="{{ $k->id }}" id="kat-{{ $k->id }}" @checked(in_array($k->id, $selectedKategori))>
            <label class="form-check-label" for="kat-{{ $k->id }}">{{ $k->nama }} ({{ $k->kode }})</label>
        </div>
    @empty
        <div class="text-muted">Belum ada kategori. <a href="{{ route('kategori.create') }}">Buat kategori</a></div>
    @endforelse
</div>

    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
        @if (!empty($item->foto))
            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="img-thumbnail mt-2" style="max-height: 120px;">
        @endif
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
