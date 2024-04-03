<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Database\Factories\MemberFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expired_date = Carbon::tomorrow()->toDateString();
        \App\Models\Member::factory(MemberFactory::class)->count(1000)->create();
        \App\Models\Member::factory(MemberFactory::class)->count(1000)->create(['code' => null, 'is_member' => 1, 'expired_date' => $expired_date]);
        \App\Models\CheckIn::factory('checkin')->count(2000)->create();
    }
}
