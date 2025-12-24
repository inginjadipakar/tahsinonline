<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahsinClass;
use Illuminate\Http\Request;

class TahsinClassController extends Controller
{
    public function index()
    {
        $classes = TahsinClass::withCount(['lessons', 'subscriptions'])->orderBy('order')->paginate(10);
        return view('admin.tahsin-classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.tahsin-classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        TahsinClass::create($validated);

        return redirect()->route('admin.tahsin-classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(TahsinClass $tahsinClass)
    {
        return view('admin.tahsin-classes.edit', compact('tahsinClass'));
    }

    public function update(Request $request, TahsinClass $tahsinClass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $tahsinClass->update($validated);

        return redirect()->route('admin.tahsin-classes.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(TahsinClass $tahsinClass)
    {
        $tahsinClass->delete();
        return redirect()->route('admin.tahsin-classes.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function show(TahsinClass $tahsinClass)
    {
        $tahsinClass->load('lessons');
        return view('admin.tahsin-classes.show', compact('tahsinClass'));
    }
}
