<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorbookcountries extends Model
{
    use HasFactory;
    protected $table = "authorbookcountries";
    public $timestamps = false;
    protected $fillable = ['authorbook_id','country_code'];
    
    
}
