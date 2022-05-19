<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function comment(){
        return $this->belongsTo(Post::class);
    }

    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_tags', 'post_id', 'tag_name');
    }

}
