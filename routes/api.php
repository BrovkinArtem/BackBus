<?

use App\Http\Controllers\BusController;
use Illuminate\Support\Facades\Route;

Route::get('/find-bus', [BusController::class, 'findBus']);
