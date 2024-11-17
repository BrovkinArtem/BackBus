<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Stop;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\Schedule;
use Carbon\Carbon;

class StopsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (Schema::hasTable('schedules')) {
            Schedule::truncate();
        }
        if (Schema::hasTable('bus_stop')) {
            BusStop::truncate();
        }
        if (Schema::hasTable('stops')) {
            Stop::truncate();
        }
        if (Schema::hasTable('buses')) {
            Bus::truncate();
        }

        $stops = [
            'ул. Пушкина',
            'ул. Ленина',
            'ул. Горького',
            'ул. Чехова',
            'ул. Попова',
            'ул. Советская',
            'ул. Молодежная',
            'ул. Транспортная',
        ];

        $stopIds = [];
        foreach ($stops as $stopName) {
            $stop = Stop::create(['name' => $stopName]);
            $stopIds[] = $stop->id;
        }

        $buses = [
            ['name' => 'Автобус №1', 'route' => 'Площадь Свободы - ул. Пушкина'],
            ['name' => 'Автобус №2', 'route' => 'Железнодорожный вокзал - ул. Горького'],
            ['name' => 'Автобус №3', 'route' => 'Старый город - ул. Советская'],
            ['name' => 'Автобус №4', 'route' => 'Новый район - ул. Молодежная'],
        ];

        $busIds = [];
        foreach ($buses as $busData) {
            $bus = Bus::create($busData);
            $busIds[] = $bus->id;
        }

        $busStopData = [];
        foreach ($busIds as $busId) {
            foreach ($stopIds as $stopId) {
                $direction = (rand(0, 1) === 0) ? 'forward' : 'backward';

                $busStopData[] = [
                    'bus_id' => $busId,
                    'stop_id' => $stopId,
                    'direction' => $direction,
                ];
            }
        }
        BusStop::insert($busStopData);

        $scheduleData = [];
        foreach ($busIds as $busId) {
            foreach ($stopIds as $stopId) {
                $scheduleData[] = [
                    'bus_id' => $busId,
                    'stop_id' => $stopId,
                    'arrival_time' => Carbon::now()->addMinutes(rand(5, 60))->format('H:i:s'), // случайное время прибытия
                ];
            }
        }
        Schedule::insert($scheduleData);

        $this->command->info('Данные для таблиц "stops", "buses", "bus_stop", и "schedule" были успешно добавлены!');
    }
}
