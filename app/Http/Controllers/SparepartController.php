<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(10);
        return view('spareparts.index', compact('spareparts'));
    }

    public function create()
    {
        return view('spareparts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sparepart' => 'required|unique:spareparts',
            'nama_sparepart' => 'required',
            'stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required',
        ]);

        Sparepart::create($request->all());

        return redirect()->route('spareparts.index')
            ->with('success', 'Data sparepart berhasil ditambahkan!');
    }

    public function show(Sparepart $sparepart)
    {
        return view('spareparts.show', compact('sparepart'));
    }

    public function edit(Sparepart $sparepart)
    {
        return view('spareparts.edit', compact('sparepart'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'kode_sparepart' => 'required|unique:spareparts,kode_sparepart,' . $sparepart->id,
            'nama_sparepart' => 'required',
            'stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required',
        ]);

        $sparepart->update($request->all());

        return redirect()->route('spareparts.index')
            ->with('success', 'Data sparepart berhasil diupdate!');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();

        return redirect()->route('spareparts.index')
            ->with('success', 'Data sparepart berhasil dihapus!');
    }
}