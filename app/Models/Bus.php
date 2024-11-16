<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    // Устанавливаем связь с остановками
    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'bus_stop', 'bus_id', 'stop_id');
    }
}
