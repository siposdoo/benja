<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App;

class ImageController extends Controller
{
    
    private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
    private $audio_ext = ['mp3', 'ogg', 'mpga'];
    private $video_ext = ['mp4', 'mpeg'];
    private $document_ext = ['doc', 'docx', 'pdf', 'odt'];

   

     
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
    public function savePhoto(Request $request)
    {
        // Validate (size is in KB)
        $request->validate([
            'photos' => 'required|file|image|size:1024|dimensions:max_width=500,max_height=500',
        ]);
    
        // Read file contents...
        $contents = file_get_contents($request->photo->path());
        return response()->json([
        
            'photoData' => $contents,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function getUserDir()
    {
        $user = Auth::user();
       // echo var_dump($user);
         return 'test' . '_' .'1';
    }
      /**
     * Get all extensions
     * @return array Extensions of all file types
     */
    private function allExtensions()
    {
        return array_merge($this->image_ext, $this->audio_ext, $this->video_ext, $this->document_ext);
    }

    private function getType($ext)
    {
        if (in_array($ext, $this->image_ext)) {
            return 'image';
        }

        if (in_array($ext, $this->audio_ext)) {
            return 'audio';
        }

        if (in_array($ext, $this->video_ext)) {
            return 'video';
        }

        if (in_array($ext, $this->document_ext)) {
            return 'document';
        }
    }
   public function deleteImage(Request $request){
    $user = Auth::user();

        
   unlink(public_path('images/'.md5($user->id).'/'.$request['randPath'].'/'.md5($request['type']).'/'.$request['filen']));
   return response()->json(['success'=>'Uspjesno ste obrisali sliku.','path'=>'images/'.md5($user->id).'/'.$request['randPath'].'/'.md5($request['type']).'/'.$request['filen'],'type' => $request['type']]);

   }
    public function store(Request $request)
    {
        
$imageName = $request->file->getClientOriginalName();
$randPath = $request['randPath'];
$type = $request['type'];
$user = Auth::user();

$path= 'images/'.md5($user->id).'/'.$randPath.'/'.md5($type).'/'.$imageName;
        $request->file->move(public_path('images/'.md5($user->id).'/'.$randPath.'/'.md5($type).'/'), $imageName);
          
        return response()->json(['success'=>'Uspjesno ste dodali sliku.','path'=>$path,'randPath' => $randPath,'type' => $type]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
