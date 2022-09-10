<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $table = "social";
    protected $fillable = ['name', 'icon','row_order'];

    protected static function boot()
    {
        parent::boot();

        Section::creating(function ($model) {
            $model->row_order = Social::max('row_order') + 1;
        });
    }
}
