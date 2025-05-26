<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')->where('isdelete', 0)->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        DB::table('categories')->insert([
            'nama_category' => $request->nama_category,
            'isdelete' => 0,
            'created_at' => now(),
        ]);
        return redirect()->route('category.index')->with('success', 'Data Berhasil Ditambahkan');
    }

     public function edit(Request $request)
    {
        $id = $request->id;
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            return response()->json(['error' => 'Data category tidak ditemukan'], 404);
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_category' => 'required',
        ]);
        $data = [
            'nama_category' => $request->nama_category,
            'updated_at' => now(),
        ];
        DB::table('categories')->where('id', $id)->update($data);
        return redirect()->route('category.index')->with('success', 'Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->update(['isdelete' => 1]);
        return redirect()->route('category.index')->with('success', 'Data Berhasil Dihapus');
    }
}
