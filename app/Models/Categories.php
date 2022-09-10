<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['name', 'image', 'icon', 'row_order', 'section_id', 'premium', 'status'];
    protected $with = [ "section"];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    protected static function boot()
    {
        parent::boot();

        Categories::creating(function ($model) {
            $model->row_order = Categories::max('row_order') + 1;
        });
    }
    
    /*rendra dont include this quote on these ya. to many load quote*/
    // public function QC()
    // {
    //     return $this->hasMany(QuotesCategories::class);
    // }
     
}
