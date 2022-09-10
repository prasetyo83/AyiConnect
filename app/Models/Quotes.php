<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    use HasFactory;
    protected $table = "quotes";
    protected $fillable = ['author_id','authorbook_id', 'mood_id','reason_id','feeling_id', 'quote', 'image','reminder'];

    protected $with = [ "author","authorbook","mood","reason","feeling"];
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    
    public function authorbook()
    {
        return $this->belongsTo(Authorbook::class);
    }
    
    public function feeling()
    {
        return $this->belongsTo(Feeling::class);
    }
    
    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
    
    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
    
}
