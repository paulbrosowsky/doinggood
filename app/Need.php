<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{

    protected $with= ['categories'];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
}
