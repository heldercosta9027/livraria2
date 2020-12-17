<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $primaryKey="id_like";
    protected $table="likes"; 
    
    public function like(){
        return $this->hasMany('App\Models\Like','id_like');
    }
}
