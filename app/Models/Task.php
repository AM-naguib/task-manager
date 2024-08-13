<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }


    public function project(){

        return $this->belongsTo(Project::class);
    }


    public function createdBy(){

        return $this->belongsTo(User::class, 'created_by');
    }
}
