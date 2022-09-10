<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = "sections";
    protected $fillable = ['section_name', 'row_order', 'premium','status'];

    protected static function boot()
    {
        parent::boot();

        Section::creating(function ($model) {
            $model->row_order = Section::max('row_order') + 1;
        });
    }
    public function categories() {
        return $this->hasMany(Category::class);
    }
}
