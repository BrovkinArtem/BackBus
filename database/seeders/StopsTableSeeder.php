<?

// database/seeders/StopsTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stop;

class StopsTableSeeder extends Seeder
{
    public function run()
    {
        Stop::create(['name' => 'ул. Пушкина']);
        Stop::create(['name' => 'ул. Ленина']);
    }
}
