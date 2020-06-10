<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exceptions\NeedNotAssignable;
use App\Exceptions\NeedNotCompletable;
use App\Need;
use Carbon\Carbon;
use Conner\Tagging\Model\Tag;
use DateTime;
use Illuminate\Http\Request;

class NeedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $needs = Need::latest()->get();

        return view('needs.index', compact('needs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('needs.create', [                    
            'categories' => Category::all(),
            'tags' => Tag::all()->pluck('name')            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {              
        $request->validate([
            'title' => ['required', 'max:140'],
            'deadline' => ['required', 'date'],
            'categories' => ['required'],
            'categories.*.slug'=> ['exists:categories'],
        ]);

        $need = Need::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'project_description' => $request->project_description,
            'need_description' => $request->need_description,
            'deadline' => new DateTime($request->deadline)
        ]);

        $need->updateCategories($request->categories);
        $need->retag($request->tags);

        return $need;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Need $need)
    {   
        $helps = $need->helps->groupBy('state.name')->sortBy(function($query){
            return $query->first()->state_id;
        });
                 
        return view('needs.show', [
            'need' => $need,
            'helps' => $helps
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Need $need
     * @return view
     */
    public function edit(Need $need)
    {        
        $this->authorize('update', $need);
        
        return view('needs.edit', [
            'need' => $need,
            'categories' => Category::all(),
            'tags' => Tag::all()->pluck('name')  
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Need $need
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Need $need)
    {
        $this->authorize('update', $need);

        $request->validate([
            'title' => ['required', 'max:140'],
            'deadline' => ['required', 'date'],
            'categories' => ['required'],
            'categories.*.slug'=> ['exists:categories'],
        ]);
        
        $need->update([            
            'title' => $request->title,
            'project_description' => $request->project_description,
            'need_description' => $request->need_description,
            'deadline' => Carbon::parse($request->deadline)
        ]);
        
        $need->updateCategories($request->categories);        
        $need->retag($request->tags);

        return $need;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Need $need 
     */
    public function destroy(Need $need)
    {
        $this->authorize('update', $need);

        $need->delete();
    }

    /**
     *  Set The given Need as Assigned
     * 
     * @param Need $need
     */
    public function assign(Need $need)
    {
        $this->authorize('update', $need);

        try{
            $need->assign(); 
        }catch(NeedNotAssignable $e){   
            return $e->getMessage();
        }
    }

    /**
     *  Set Need as Completed
     * 
     * @param Need $need
     */
    public function complete(Need $need)
    {
        $this->authorize('update', $need);

        try{
            $need->complete(); 
        }catch(NeedNotCompletable $e){   
            return $e->getMessage();
        }
    }
}
