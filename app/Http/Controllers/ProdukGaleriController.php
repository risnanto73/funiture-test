<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukGaleriRequest;
use App\Models\Produk;
use App\Models\ProdukGaleri;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProdukGaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Produk $produk)
    {
        if (request()->ajax()) {

            $query = ProdukGaleri::where('produks_id', $produk->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <form class="inline-block" action="' . route('dashboard.galeri.destroy', $item->id) . '" 
                        method="POST">
                        <button class="bg-red-500 text-white rounded px-2 py-1 m-2">
                        Delete
                        </button>
                        ' . method_field('delete') . csrf_field() . '
                    </form>
                    ';
                })
                ->editColumn('url', function ($item) {
                    return '<img src="' . Storage::url($item->url) . '" style="max-width:150pxW"/>';
                })
                ->editColumn('is_featured', function ($item) {
                    return $item->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['action','url'])
                ->make();
        }
        return view('pages.dashboard.galeri.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Produk $produk)
    {
        return view('pages.dashboard.galeri.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdukGaleriRequest $request, Produk $produk)
    {
        $files = $request->file('files');

        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $path = $file->store('public/galeri');

                ProdukGaleri::create([
                    'produks_id' => $produk->id,
                    'url'        => $path
                ]);
            }
        }

        return redirect()->route('dashboard.produk.galeri.index',$produk->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukGaleri $galeri)
    {
        $galeri->delete();

        return redirect()->route('dashboard.produk.galeri.index', $galeri->produks_id);
    }
}
