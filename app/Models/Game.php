<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Developer;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['naam', 'dev_id', 'release_date', 'platform'];

    public function developer()
    {
        return $this->belongsTo(Developer::class, 'dev_id', 'id');
    }
}
