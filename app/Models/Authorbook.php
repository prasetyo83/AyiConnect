<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorbook extends Model
{
    use HasFactory;
    protected $table = "authorbook";
    protected $fillable = ['author_id','link','image','title'];
    public $timestamps = false;
    protected $with = [ "authorbookcountries"];
   
    public function authorbookcountries()
    {
        return $this->hasOne(Authorbookcountries::class);
    }
}
