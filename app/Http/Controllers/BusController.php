<?

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Stop;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function findBus(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $buses = Bus::whereHas('stops', function ($query) use ($from, $to) {
            $query->where('name', $from)
                ->orWhere('name', $to);
        })->get();

        $result = [];

        foreach ($buses as $bus) {
            $result[] = [
                'route' => $bus->route,
                'next_arrivals' => ['08:15', '08:40', '09:15'],
            ];
        }

        return response()->json([
            'from' => $from,
            'to' => $to,
            'buses' => $result
        ]);
    }
}
