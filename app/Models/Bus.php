<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['route'];

    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'bus_stop')
                    ->withPivot('direction');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
