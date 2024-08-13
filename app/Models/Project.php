<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function createdBy(){

        return $this->belongsTo(User::class, 'created_by');
    }


    public function document(){
        return $this->hasOne(Document::class);
    }
}
