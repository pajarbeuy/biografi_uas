<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Pekerjaan::all();
        return view('pekerjaan.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pekerjaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => 'required',
            'deskripsi_pekerjaan' => 'required',
            'nama_perusahaan' => 'required',
        ]);

        Pekerjaan::create($validated);
        return redirect()->route('pekerjaan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Pekerjaan::findOrFail($id);
        return view('pekerjaan.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Pekerjaan::findOrFail($id);
        return view('pekerjaan.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => 'required',
            'deskripsi_pekerjaan' => 'required',
            'nama_perusahaan' => 'required',
        ]);

        $item = Pekerjaan::findOrFail($id);
        $item->update($validated);
        return redirect()->route('pekerjaan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Pekerjaan::findOrFail($id);
        $item->delete();
        return redirect()->route('pekerjaan.index');
    }
}
