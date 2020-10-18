<?php

namespace App;

use Illuminate\Support\Facades\DB;

class NeedMatching
{   
    /** 
     * Availiable Matching Parameters
     */
    protected $parameters =  ['helpers', 'categories', 'location', 'tags'];

    protected $need;

    protected $builder;

    public function __construct(Need $need) {        
        $this->need = $need;
    }

    /** 
     *  Apply Need Matching
     * 
     * @return Collection
     */
    public function apply()
    {
        foreach ($this->parameters as $parameter) {
            if (method_exists($this, $parameter)) {
                $this->$parameter();
            }
        }

        $userIds = $this->builder->get()->pluck('id')->toArray();

        return User::whereIn('id', $userIds)->get();
    }

    /**
     *  Find Users as Helpers
     * 
     * @return Builder
     */
    public function helpers()
    {
        return $this->builder = DB::table('users')
                                ->where('helper', true)
                                ->where('enable_matching', true);
    }

     /**
     *  Find Users Matching with Needs Categories
     * 
     * @return Builder
     */
    public function categories()
    {
        $needsCategories = $this->need->fresh()->categories->pluck('id')->toArray();

        return $this->builder                        
                    ->join( 'categorizables as c', function($join) use ($needsCategories){
                        $join->on( 'users.id', '=', 'c.categorizable_id' )
                            ->where( 'c.categorizable_type', '=', 'App\User' )
                            ->whereIn( 'c.category_id', $needsCategories );
                    })
                    ->selectRaw('DISTINCT users.*') 
                    ->groupByRaw('users.id, c.category_id');
    }

    /**
     *  Find Users Matching with Loaction
     * 
     * @return Builder
    */
    public function location()
    {
        $need = $this->need;
        if(!isset($need->lat) && !isset($need->lng)){
            return $this->builder->whereRaw( "users.lat <= $need->lat + (users.activity_area/111.3)")
                                ->whereRaw( "users.lat  >= $need->lat - (users.activity_area/111.3)" )
                                ->whereRaw( "users.lng <= $need->lng + users.activity_area/71.5" )
                                ->WhereRaw( "users.lng >= $need->lng - users.activity_area/71.5");
        }
        
    }

    /**
     *  Find Users with at least 50% Tags Matching
     * 
     * @return Builder
     */
    public function tags()
    {
        $needTags = $this->need->fresh()->tagSlugs();
        $needTagsCount= count($needTags);
        
        return $this->builder 
                    ->join( 'tagging_tagged as t', function($join) use ($needTags){
                        $join->on( 'users.id', '=', 't.taggable_id' )
                            ->where( 't.taggable_type', '=', 'App\User' );                            
                    })
                    ->whereIn( 't.tag_slug', $needTags)
                    ->selectRaw("CAST( 100*count(t.tag_slug)/$needTagsCount as UNSIGNED ) as tags_matching")
                    ->havingRaw('tags_matching >= ?', [50]);       
    }

    

   

    
}
