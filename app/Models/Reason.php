<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
    protected $table = "reason";
    public $fillable = ['title','image','mood_id']; 
    protected $with = [ "mood"];
    
    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
     
    
}
