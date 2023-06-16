<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;

class Developer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['naam'];


    public function games()
    {
        return $this->hasMany(Game::class, 'game_id', 'id');
    }
}
