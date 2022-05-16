<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subCategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }
    
    public function posts(){
        return $this->hasMany(Post::class, 'post_id');
    }
}
