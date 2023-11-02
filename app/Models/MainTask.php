<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainTask extends Model
{
    protected $table = 'maintasks';

    protected $fillable = ['status', 'finish_day'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
