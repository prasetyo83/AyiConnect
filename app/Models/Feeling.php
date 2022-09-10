<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeling extends Model
{
   use HasFactory;
    protected $table = "feeling";
    public $fillable = ['title','image','reason_id']; 
    protected $with = ["reason"];
    
    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
}