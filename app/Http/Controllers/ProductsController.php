<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->user_id = Auth()->user()->id;
        $product->pd_name = $request->input('pd_name');
        $product->pd_harga = $request->input('pd_harga');
        $product->pd_berat = $request->input('pd_berat');
        $product->pd_expired = $request->input('pd_expired');
        $product->pd_jenis = $request->input('pd_jenis');
        $product->pd_desc = $request->input('pd_desc');
        $product->pd_status = $request->input('pd_status');

        // INI UNTUK UPLOAD FILE (BELUM BISA)
        // if (
        //     $request->hasFile('file') and $request->file('file')
        //     ->isValid()
        // ) {
        //     $product->pd_img = $request->file('file')->store('products');
        // }
        $product->save();
        return response($product, 201);
        // return response()->json(["token" => "sukses"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $product = $request->id;
        if (product::where('id', $product)->exists()) {
            $data = product::find($product);
            return response($data, 201);
        } else {
            return response(404);
        }
    }
    public function showstoreproduct(Request $request)
    {
        $product = $request->user_id;
        if (product::where('user_id', $product)->exists()) {
            $data = product::where('user_id', $product)->get();
            return response($data, 201);
        } else {
            return response(404);
        }
    }
    public function showall()
    {
        if (product::all()->exists()) {
            $data = product::all();
            return response($data, 201);
        } else {
            return response(404);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit(Request $request)
    // {
    //     $product = product::findorfail($request->id);
    //     return response()->json($product->makeHidden('token'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product_id = $request->id;
        product::where('id', $product_id)->update([
            "pd_name" => $request->input('pd_name'),
            "pd_harga" => $request->input('pd_harga'),
            "pd_berat" => $request->input('pd_berat'),
            "pd_expired" => $request->input('pd_expired'),
            "pd_jenis" => $request->input('pd_jenis'),
            "pd_desc" => $request->input('pd_desc'),
            "pd_status" => $request->input('pd_status'),
        ]);
        return response(200);
    }
    public function delete(Request $request)
    {
        $product = product::find($request->id);
        $product->forceDelete();
        return response('Product Deleted', 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //  //
    // }
}
