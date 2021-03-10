<?php

namespace App\Http\Controllers;

use App\Kompanija;
use App\Nalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KompanijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kompanija = Kompanija::with('nalog')->with('nalog.utovaristovar')->get();
        
        return response()->json([
           
            'results' => $kompanija
            
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
        $v = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'address' => 'required|min:3',
            'city'  => 'required|min:3',
            'kontakt'  => 'required|min:3',
            
            'state'  => 'required|min:2',
            'lat'  => 'required',
            'lng'  => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json([
                'error' => 'companie_add_validation_error',
                'errors' => $v->errors()
            ], 422);
        }
        
if($request->id){
    $companie =  Kompanija::findOrFail($request->id);
    $companie->name = $request->name;
    $companie->kontakt = $request->kontakt;
    $companie->city = $request->city;
    $companie->state = $request->state;
    $companie->address = $request->address;
    $companie->lat = $request->lat;
    $companie->lng = $request->lng;

    $companie->save();
    return response()->json(['status' => 'success'], 200);

}else{
    $companie = new Kompanija;
    $companie->name = $request->name;
    $companie->city = $request->city;
    $companie->kontakt = $request->kontakt;

    $companie->state = $request->state;
    $companie->address = $request->address;
    $companie->lat = $request->lat;
    $companie->lng = $request->lng;
    $companie->save();
    return response()->json(['status' => 'success'], 200);

}
       
         

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kompanija  $kompanija
     * @return \Illuminate\Http\Response
     */
    public function show(Kompanija $kompanija)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kompanija  $kompanija
     * @return \Illuminate\Http\Response
     */
    public function edit(Kompanija $kompanija)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kompanija  $kompanija
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kompanija $kompanija)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kompanija  $kompanija
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kompanija $kompanija)
    {
        //
    }
}
