<?php

namespace Database\Seeders;

use App\Models\Taller;
use Illuminate\Database\Seeder;

class TallerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Taller::factory()->count(10)->create();
    }
}
