<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'img', 'subtitle_1', 'subtitle_2', 'title_1', 'title_2', 'caption', 'button_text', 'url', 'status'
    ];
    
}
