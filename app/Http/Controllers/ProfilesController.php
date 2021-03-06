<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;

class ProfilesController extends Controller
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
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        return view('profiles.show', [
            'user' => $user,
            'needs' => $user->feed()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('profiles.edit', [
            'user' => $user,
            'categories' => Category::all(),
            'tags' => Tag::all()->pluck('name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {     
        $this->authorize('update', $user);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'excerpt' => ['max:255'],
            'categories.*.slug'=> ['exists:categories'],
            'web_link' => ['url', 'nullable'],
            'facebook_link' => ['url', 'nullable'],
            'instagram_link' => ['url', 'nullable'],
            'tweeter_link' => ['url', 'nullable'],
            'lat' => ['numeric', 'nullable'],
            'lng' => ['numeric', 'nullable'],
            'activity_area' => ['integer', 'nullable']
        ]);        
            
        $user->update([
            'name' => $request->name,
            'description' => $request->description,
            'excerpt' => $request->excerpt,
            'helper' => $request->helper,
            'web_link' => $request->web_link,
            'facebook_link' => $request->facebook_link,
            'instagram_link' => $request->instagram_link,
            'tweeter_link' => $request->tweeter_link,
            'location' => $request->location,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'activity_area' => $request->activity_area,
            'enable_matching' => $request->enable_matching
        ]);
            
        $user->updateCategories($request->categories); 
        $user->retag($request->tags);          
    }    
}
