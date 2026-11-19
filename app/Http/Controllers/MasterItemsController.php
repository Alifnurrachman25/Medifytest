<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\MasterItem;
use App\Exports\MasterItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        // $hargamin = $request->hargamin;
        // $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        if ($request->filled('hargamin')) $data_search->where('harga_beli', '>=', $request->hargamin);
        if ($request->filled('hargamax')) $data_search->where('harga_beli', '<=', $request->hargamax);
        // if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin)->where('harga_beli', '<=', $hargamax);

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        $item = $method == 'new' ? new MasterItem : MasterItem::with('kategoris')->findOrFail($id);
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategoris'] = Kategori::orderBy('nama')->get();
        return view('master_items.form.index', $data);
    }
    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|integer|min:0',
            'laba' => 'required|integer|min:0',
            'supplier' => 'required',
            'jenis' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategoris' => 'nullable|array',
            'kategoris.*' => 'exists:kategoris,id',
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = str_pad(MasterItem::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        if ($request->hasFile('foto')) {
            if ($data_item->foto) {
                Storage::disk('public')->delete($data_item->foto);
            }
            $data_item->foto = $request->file('foto')->store('master-items', 'public');
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->save();

        $data_item->kategoris()->sync($request->input('kategori_ids', []));

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }

    public function export()
    {
        return Excel::download(new MasterItemsExport, 'master-items-' . now()->format('Ymd_His') . '.xlsx');
    }
}
