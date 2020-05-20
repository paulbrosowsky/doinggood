<?php

namespace App\Http\Controllers;

use App\Need;
use Illuminate\Http\Request;
use Storage;

class NeedImagesController extends Controller
{
    /**
     *  Update Needs Title Images
     * 
     * @param Need $need
     * @param Request $request
     */
    public function update(Need $need, Request $request)
    {
        $this->authorize('update', $need);   

        $request->validate([            
            'image' => ['required', 'image', 'max:10000'], // max. Size 10 MB     
        ]);
      
        //Delete Previous Avatars
        if(Storage::disk('public')->exists( $need->getRawOriginal('title_image') )){            
            Storage::disk('public')->delete( $need->getRawOriginal('title_image') );
            $need->update(['title_image' => NULL]);
        }       
        
        $need->update([
            'title_image' => $request->file('image')->store('assets/need_images', 'public')
        ]); 
    }
}