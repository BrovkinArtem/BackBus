<?php

// namespace Tests\Feature;

// use App\Models\Stop;
// use App\Models\Bus;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;

// class BusControllerTest extends TestCase
// {
//     use RefreshDatabase;

//     /** @test */
//     public function it_can_find_bus_between_two_stops()
//     {
//         // Создаем остановки
//         $from = Stop::create(['name' => 'ул. Ленина']);
//         $to = Stop::create(['name' => 'ул. Пушкина']);

//         // Создаем автобус
//         $bus = Bus::create(['id' => 1]);

//         // Привязываем автобус к остановкам
//         $bus->stops()->attach($from, ['direction' => 'forward']);
//         $bus->stops()->attach($to, ['direction' => 'forward']);

//         // Выполняем запрос к методу findBus
//         $response = $this->json('GET', '/api/find-bus', [
//             'from' => 'ул. Ленина',
//             'to' => 'ул. Пушкина'
//         ]);

//         // Проверяем, что запрос был успешным и ответ содержит ожидаемые данные
//         $response->assertStatus(200)
//                  ->assertJsonFragment(['from' => 'ул. Ленина'])
//                  ->assertJsonFragment(['to' => 'ул. Пушкина']);
//     }
// }
