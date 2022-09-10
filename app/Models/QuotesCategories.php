<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotesCategories extends Model
{
    use HasFactory;
    protected $table = "quotes_categories";
    protected $fillable = ['quote_id', 'categories_id', 'status'];
    public $timestamps = false;    
    
}
