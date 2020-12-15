<?php

namespace App\Http\Controllers;

use App\Kompanija;
use Illuminate\Http\Request;

class KompanijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kompanija = Kompanija::All();
        
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
        //
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
