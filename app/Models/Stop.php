<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    protected $fillable = ['name'];

    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'bus_stop')
                    ->withPivot('direction');
    }
}

