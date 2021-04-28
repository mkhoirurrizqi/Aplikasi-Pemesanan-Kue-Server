<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
        $req = $request->all();
        if (
            $request->hasFile('file') and $request->file('file')
            ->isValid()
        ) {
            $path = $request->file('file')->store('image');
            $req['file'] = $path;
        }
        product::create($req);
        return response()->json(["token" => "sukses"]);
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
            return response()->json($data->makeHidden('token'));
        } else {
            return response()->json([], 404);
        }
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
    public function destroy($id)
    {
        //
    }
}
