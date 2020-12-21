<?php

namespace App\Http\Controllers;

use App\Vozac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class VozacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Vozac::All();
        
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
            'address' => 'required|min:3',
            'kontakt'  => 'required|min:5',
            
        ]);

        if ($v->fails())
        {
            return response()->json([
                'error' => 'vozac_add_validation_error',
                'errors' => $v->errors()
            ], 422);
        }
        
if($request->id){
    $vozac =  Vozac::findOrFail($request->id);
    $vozac->name = $request->name;
 
    $vozac->address = $request->address;
    $vozac->kontakt = $request->kontakt;
    

    $vozac->save();
    return response()->json(['status' => 'success'], 200);

}else{
    $vozac = new Vozac;
    $vozac->name = $request->name;
 
    $vozac->address = $request->address;
    $vozac->kontakt = $request->kontakt;
    
    $vozac->save();
    return response()->json(['status' => 'success'], 200);

}
       
         

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Vozac  $vozac
     * @return \Illuminate\Http\Response
     */
    public function show(Vozac $vozac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vozac  $vozac
     * @return \Illuminate\Http\Response
     */
    public function edit(Vozac $vozac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vozac  $vozac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vozac $vozac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vozac  $vozac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vozac $vozac)
    {
        //
    }
}
