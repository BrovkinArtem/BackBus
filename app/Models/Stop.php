<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    // Устанавливаем связь с автобусами
    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'bus_stop', 'stop_id', 'bus_id');
    }
}
