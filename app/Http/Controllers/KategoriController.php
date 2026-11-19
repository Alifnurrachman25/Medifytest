<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategoris = Kategori::withCount('items')
            ->when($request->nama, fn($q, $v) => $q->where('nama', 'like', "%$v%"))
            ->when($request->kode, fn($q, $v) => $q->where('kode', 'like', "%$v%"))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.form', ['kategori' => new Kategori]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kategori::create($this->validated($request));
        return redirect('kategori')->with('status', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        $kategori->load('items');
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.form', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update($this->validated($request, $kategori));
        return redirect('kategori')->with('status', 'Kategori berhasil diperbarui');
    }

    private function validated(Request $request, ?Kategori $kategori = null): array
    {
        return $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => ['required', 'string', 'max:50', Rule::unique('kategoris', 'kode')->ignore($kategori?->id)],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect('kategori')->with('status', 'Kategori berhasil dihapus');
    }

    public function pdf(Kategori $kategori)
    {
        $kategori->load('items');
        $pdf = Pdf::loadView('kategori.pdf', [
            'kategori' => $kategori,
            'dicetak' => now()->timezone('Asia/Makassar'),
        ])->setPaper('a4');
        return $pdf->download('kategori-' . $kategori->kode . '.pdf');
    }
}
