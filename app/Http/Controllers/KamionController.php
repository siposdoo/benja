<?php

namespace App\Http\Controllers;

use App\Kamion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KamionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Kamion::All();
        
        return response()->json([
           
            'results' => $results
            
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
            'proizvodjac' => 'required|min:3',
            'tablica' => 'required|min:5',
            'model' => 'required|min:3'
            
            
        ]);

        if ($v->fails())
        {
            return response()->json([
                'error' => 'vozac_add_validation_error',
                'errors' => $v->errors()
            ], 422);
        }
        
if($request->id){
    $kamion =  Kamion::findOrFail($request->id);
    $kamion->proizvodjac = $request->proizvodjac;
 
    $kamion->tablica = $request->tablica;
    $kamion->model = $request->model;
    

    $kamion->save();
    return response()->json(['status' => 'success'], 200);

}else{
    $kamion = new Kamion;
    $kamion->proizvodjac = $request->proizvodjac;
 
    $kamion->tablica = $request->tablica;
    $kamion->model = $request->model;
    
    
    $kamion->save();
    return response()->json(['status' => 'success'], 200);

}
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kamion  $kamion
     * @return \Illuminate\Http\Response
     */
    public function show(Kamion $kamion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kamion  $kamion
     * @return \Illuminate\Http\Response
     */
    public function edit(Kamion $kamion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kamion  $kamion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kamion $kamion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kamion  $kamion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kamion $kamion)
    {
        //
    }
}
