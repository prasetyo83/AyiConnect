<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $table = "authors";
    protected $fillable = ['name', 'image', 'row_order', 'premium', 'delete'];
    protected $with = ['authorhastag'];
    protected static function boot()
    {
        parent::boot();

        Author::creating(function ($model) {
            $model->row_order = Author::max('row_order') + 1;
        });
    }
    // perlu definsi relasi
    public function authorhastag()
    {
        return $this->hasMany(Authorhastag::class);
    }
    public function authorsocial()
    {
        return $this->hasMany(Authorsocial::class);
    }
   
}
