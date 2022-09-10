<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorsocial extends Model
{
    use HasFactory;
    protected $table = "authorsocial";
    protected $fillable = ['author_id','link','network','social_id'];
    protected $with = [ "author"];
    public $timestamps = false;
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
