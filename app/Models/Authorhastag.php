<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorhastag extends Model
{
    use HasFactory;
    protected $table = "authorhastag";
    public $timestamps = false;
    protected $fillable = ['author_id','hastag_id'];
    protected $with = ['authors','hastag'];

    public function hastag()
    {
        return $this->belongsTo(Hastag::class);
    }
    public function authors()
    {
        return $this->belongsTo(Author::class);
    }

}
