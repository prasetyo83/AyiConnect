<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyProse extends Model
{
    use HasFactory;
    protected $table = "dailyprose";
    protected $fillable = ['mood_id', 'author_id', 'prose', 'status'];
    protected $with = ['mood','author'];
    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
