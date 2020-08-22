<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
    );

    public function histories()
    {
      return $this->hasMany('App\History');

    }
}
