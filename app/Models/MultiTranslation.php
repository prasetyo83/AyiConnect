<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiTranslation extends Model
{
    use HasFactory;
    protected $table = "maintranslation";
    protected $fillable = ['textid', 'text','lang','createdby'];    
}
