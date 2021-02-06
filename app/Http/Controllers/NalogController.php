<?php

namespace App\Http\Controllers;

use App\Nalog;
use App\Kompanija;
use App\UtovarIstovar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Nalog::with('kompanija')->with('utovaristovar')->get();
        
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
    public function getNalog(Request $request)
    {

        if($request['hsh']){
            $nalog =  Nalog::with('kompanija')->with('utovaristovar')->where('hash',$request['hsh'])->get();
              
        return response()->json([
           
            'results' => $nalog
            
            ]);
        }else{
       
         
        return response()->json([
            'error' => 'nalog_pdf_validation_error',
            
        ], 422);
    }
    }
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'data.naziv' => 'required|min:3'
            
            
            
        ]);

        if ($v->fails())
        {
            return response()->json([
                'error' => 'nalog_add_validation_error',
                'errors' => $v->errors()
            ], 422);
        }
        if($request->id){
            $nalog =  Nalog::findOrFail($request->id);
            $data = $request['data'];
            if($data['placena']==""){
                $data['placena']=0;
            } if($data['proizvodjac']==""){
                $data['proizvodjac']="nije uneseno";
            }

            $data['kompanija']=$data['komitent']['id'];
 
 $nalog->fill($data)->save();
 UtovarIstovar::where('nalog_id', $nalog->id)->delete();
$i=0;
$u=0;
 foreach($data['kompod'] as $kompod){
    $utois = new UtovarIstovar();

    $utois->nalog_id=$nalog->id;
    $utois->tip=0;
    $utois->napomena=$kompod['napomena'];
    $utois->drzava=$kompod['drzava']['value'];
    $utois->grad=$kompod['grad'];
    $utois->adresa=$kompod['adresa'];
    $utois->vozila=$kompod['vozila'];
  
    try{
        $saved =$utois->save();
       
      
    }
    catch(\Exception $e){
        $u++;
        
       
            UtovarIstovar::where('nalog_id', $nalog->id)->delete();
    }

}
foreach($data['kompdo'] as $kompdo){
    $utois = new UtovarIstovar();

    $utois->nalog_id=$nalog->id;
    $utois->tip=1;
    $utois->napomena=$kompdo['napomena'];
    $utois->drzava=$kompdo['drzava']['value'];
    $utois->grad=$kompdo['grad'];
    $utois->adresa=$kompdo['adresa'];
    $utois->vozila=$kompdo['vozila'];
    try{
    $saved =$utois->save();
    
}
catch(\Exception $e){
    $i++;
    
    
        UtovarIstovar::where('nalog_id', $nalog->id)->delete();
}
    

}
    if($u==0 && $i==0){
        return response()->json(['status' => 'success'], 200);
    }    
        
        }else{
            $i=0;
$u=0;
            $nalog = new Nalog;
            
            $data = $request['data'];
            if($data['placena']==""){
                $data['placena']=0;
            } if($data['proizvodjac']==""){
                $data['proizvodjac']="nije uneseno";
            }

            $data['kompanija']=$data['komitent']['id'];
  
 $data['hash']=hash('md5', time().$data['naziv']);

 
 $nalog->fill($data)->save();
 foreach($data['kompod'] as $kompdo){
    $utois = new UtovarIstovar();

    $utois->nalog_id=$nalog->id;
    $utois->tip=0;
    $utois->napomena=$kompdo['napomena'];
    $utois->drzava=$kompdo['drzava']['value'];
    $utois->grad=$kompdo['grad'];
    $utois->adresa=$kompdo['adresa'];
    $utois->vozila=$kompdo['vozila'];
  
    try{
        $saved =$utois->save();
       
      
    }
    catch(\Exception $e){
       $u++;
        Nalog::destroy($nalog->id);
            UtovarIstovar::where('nalog_id', $nalog->id)->delete();
    }

}
foreach($data['kompdo'] as $kompdo){
    $utois = new UtovarIstovar();

    $utois->nalog_id=$nalog->id;
    $utois->tip=1;
    $utois->napomena=$kompdo['napomena'];
    $utois->drzava=$kompdo['drzava']['value'];
    $utois->grad=$kompdo['grad'];
    $utois->adresa=$kompdo['adresa'];
    $utois->vozila=$kompdo['vozila'];
    try{
    $saved =$utois->save();
    
}
catch(\Exception $e){
    $i++;
    
    Nalog::destroy($nalog->id);
        UtovarIstovar::where('nalog_id', $nalog->id)->delete();
}
    

}
         
if($u==0 && $i==0){
    return response()->json(['status' => 'success'], 200);
}        
        
        }
           
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nalog  $nalog
     * @return \Illuminate\Http\Response
     */
    public function show(Nalog $nalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nalog  $nalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Nalog $nalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nalog  $nalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nalog $nalog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nalog  $nalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nalog $nalog)
    {
        //
    }
}
