<?php

namespace App\Http\Controllers;

use App\Product;
use App\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('pictures')->get();
        $result=$products;
        return response()->json([
           
            'products' => $result
            
            ]);
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
        $user = Auth::user();

        $product = new Product();

 $data = $request->only($product->getFillable());
$data['kategorija']=1;
$data['us_id']=$user->id;
$data['subkategorija']=1;
$data['proizvodjac']=1;
if(!$data['sifradobavljaca']){
    $data['sifradobavljaca']='nema unosa';
}
if(!$data['opis']){
    $data['opis']='nema unosa';
}
if(!$data['tehnckekar']){
    $data['tehnckekar']='nema unosa';
}
if(!$data['videoproizvoda']){
    $data['videoproizvoda']='nema unosa';
}
if(!$data['predlozenimreze']){
    $data['predlozenimreze']='nema unosa';
}
if(!$data['linkproizvodjaca']){
    $data['linkproizvodjaca']='nema unosa';
}


$product->fill($data)->save();

foreach($request['images'] as $img){
    $image = new Picture();

    $image->product_id=$product->id;
    $image->type=$img['type'];
    $image->urlImage=$img['path'];
    $image->save();

}


 //var_dump($request['product']);
      //  $data = $request['product'] ;

         return response()->json(['success'=>'1','product' => $request['product']]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
