<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Stop;
use App\Models\BusStop;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BusController extends Controller
{
    public function findBus(Request $request)
    {
        // Получаем имена остановок из запроса
        $from = $request->input('from');
        $to = $request->input('to');

        // Находим остановки по имени
        $fromStop = Stop::where('name', $from)->first();
        $toStop = Stop::where('name', $to)->first();

        // Проверяем, что остановки существуют
        if (!$fromStop || !$toStop) {
            return response()->json(['error' => 'Invalid stops provided'], 400);
        }

        // Находим автобусы, которые проходят через обе остановки в нужном порядке
        $buses = Bus::whereHas('stops', function ($query) use ($from, $to) {
            $query->where(function ($query) use ($from, $to) {
                $query->where('name', $from)
                      ->orWhere('name', $to);
            })->where('direction', 'forward');
        })->get();


        $result = [];
        foreach ($buses as $bus) {
            $finalStop = $bus->stops()
                 ->where('direction', 'forward')
                 ->latest()
                 ->first();


            // Формируем название маршрута
            $routeName = 'Автобус No' . $bus->id . ' в сторону ост.' . $finalStop->name;

            // Получаем расписание для маршрута
            $schedules = Schedule::where('bus_id', $bus->id)
                                ->whereHas('stop', function ($query) use ($from) {
                                    $query->where('name', $from);
                                })
                                ->where('arrival_time', '>=', now()->format('H:i'))
                                ->orderBy('arrival_time')
                                ->limit(3)
                                ->pluck('arrival_time');

            // Если расписание не найдено, генерируем его
            if ($schedules->isEmpty()) {
                $schedules = $this->generateSchedule($bus, $fromStop, $toStop);
            }

            $result[] = [
                'route' => $routeName,
                'next_arrivals' => $schedules,
            ];
        }

        // Возвращаем результат с правильной кодировкой
        return response()->json([
            'from' => $fromStop->name,
            'to' => $toStop->name,
            'buses' => $result,
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    // Метод для генерации расписания, если его нет в базе
    protected function generateSchedule(Bus $bus, Stop $fromStop, Stop $toStop)
    {
        $currentTime = Carbon::now();
        $schedule = [];

        // Генерируем расписание, с интервалом в 15 минут
        for ($i = 0; $i < 3; $i++) {
            $time = $currentTime->copy()->addMinutes($i * 15);
            $schedule[] = $time->format('H:i');
        }

        return $schedule;
    }

            public function updateRoute(Request $request)
        {
            $validated = $request->validate([
                'route_id' => 'required|exists:buses,id',
                'stops' => 'required|array',
                'stops.*.stop_id' => 'required|exists:stops,id',
                'stops.*.direction' => 'required|in:forward,backward',
            ]);

            $bus = Bus::findOrFail($validated['route_id']);

            // Проходим по переданным остановкам и обновляем их
            foreach ($validated['stops'] as $stopData) {
                $stop = Stop::find($stopData['stop_id']);

                if (!$stop) {
                    return response()->json(['error' => 'Остановка не найдена'], 400);
                }

                // Проверяем, существует ли уже такая остановка для этого маршрута
                $existingStop = BusStop::where('bus_id', $bus->id)
                    ->where('stop_id', $stop->id)
                    ->first();

                if ($existingStop) {
                    $existingStop->update(['direction' => $stopData['direction']]);
                } else {
                    BusStop::create([
                        'bus_id' => $bus->id,
                        'stop_id' => $stop->id,
                        'direction' => $stopData['direction'],
                    ]);
                }
            }

            // Возвращаем обновленный маршрут
            $updatedBus = Bus::with(['stops.stop'])->findOrFail($bus->id);

            return response()->json([
                'message' => 'Маршрут обновлен успешно!',
                'route' => $updatedBus
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }


    public function showRoutes()
    {
        // Получаем все маршруты и их остановки
        $buses = Bus::with('stops')->get();

        $routes = [];
        foreach ($buses as $bus) {
            // Проходим по остановкам маршрута
            $stops = $bus->stops->map(function ($busStop) {
                return [
                    'name' => $busStop->name,
                    'direction' => $busStop->pivot->direction,
                ];
            });

            $routes[] = [
                'route_id' => $bus->id,
                'stops' => $stops
            ];
        }

        return response()->json([
            'routes' => $routes
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }


}
