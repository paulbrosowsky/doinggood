<?php

namespace App;

trait Categorizable
{
    protected static function bootCategorizable()
    {
        static::deleting(function($model){            
            $model->categories()->detach();
        });
    }    

    /**
     *  A Model Belongs to Many Categories
     * 
     * @return morphToMany
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     *  Update Categories the Model attached to
     *  
     *  @param array $categories
     */
    public function updateCategories($categories)
    {    
        $this->categories()->detach();
        if ($categories) {           
            foreach ($categories as $category) {            
                $this->categories()->attach($category['id']);
            }
        }       

        return $this;
    }
}