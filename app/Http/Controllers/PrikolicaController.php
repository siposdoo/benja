<?php

namespace App\Http\Controllers;

use App\Prikolica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class PrikolicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        $results = Prikolica::select("*", DB::raw("CONCAT(prikolicas.tablica,' ','(',prikolicas.name,')') as namep"))->get();

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
            'name' => 'required|min:3',
            'tablica' => 'required|min:5'
            
            
        ]);

        if ($v->fails())
        {
            return response()->json([
                'error' => 'vozac_add_validation_error',
                'errors' => $v->errors()
            ], 422);
        }
        
if($request->id){
    $vozac =  Prikolica::findOrFail($request->id);
    $vozac->name = $request->name;
 
    $vozac->tablica = $request->tablica;
    $vozac->dodatno = $request->dodatno;
    

    $vozac->save();
    return response()->json(['status' => 'success'], 200);

}else{
    $vozac = new Prikolica;
    $vozac->name = $request->name;
 
    $vozac->tablica = $request->tablica;
    $vozac->dodatno = $request->dodatno;
    
    
    $vozac->save();
    return response()->json(['status' => 'success'], 200);

}
       
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prikolica  $prikolica
     * @return \Illuminate\Http\Response
     */
    public function show(Prikolica $prikolica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prikolica  $prikolica
     * @return \Illuminate\Http\Response
     */
    public function edit(Prikolica $prikolica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prikolica  $prikolica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prikolica $prikolica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prikolica  $prikolica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prikolica $prikolica)
    {
        //
    }
}
