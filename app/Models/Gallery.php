<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['images', 'user', 'comments'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // public static function search($searchTerm = "")
    // {
    //     return self::whereHas("user", function ($q) use ($searchTerm) {
    //         $q->where("firstName", "LIKE", "%$searchTerm%")->orWhere("lastName", "LIKE", "%$searchTerm%");
    //     })->orWhere("name", "LIKE", "%$searchTerm%")->orWhere("description", "LIKE", "%$searchTerm%");
    // }


    public function scopeSearch($query, $searchTerm)
    {
        return $query->whereHas("user", function ($q) use ($searchTerm) {
            $q->where("firstName", "LIKE", "%$searchTerm%")->orWhere("lastName", "LIKE", "%$searchTerm%");
        })->orWhere("name", "LIKE", "%$searchTerm%")->orWhere("description", "LIKE", "%$searchTerm%");
    }
}
