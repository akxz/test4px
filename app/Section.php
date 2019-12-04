<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The user that belong to the section.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
