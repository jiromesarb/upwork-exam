<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['name' => 'CEO'],
            ['name' => 'Supervisor'],
            ['name' => 'Head Department'],
        ];
        Position::insert($positions);
    }
}
