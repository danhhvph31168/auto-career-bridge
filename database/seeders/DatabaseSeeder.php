<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Enterprise;
use App\Models\Job;
use App\Models\Major;
use App\Models\Notification;
use App\Models\Role;
use App\Models\University;
use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Enterprise::factory(5)->create();

        University::factory(5)->create();

        Major::factory(5)->create();

        Job::factory(5)->create();

        Workshop::factory(5)->create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('collaborations')->insert([
                'enterprise_id' => rand(1, 5),
                'university_id' => rand(1, 5),
                'send_name' => 'enterprise'
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            DB::table('workshop_enterprise')->insert([
                'enterprise_id' => rand(1, 5),
                'workshop_id' => rand(1, 5),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            DB::table('job_university')->insert([
                'job_id' => rand(1, 5),
                'university_id' => rand(1, 5),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            DB::table('workshop_major')->insert([
                'major_id' => rand(1, 5),
                'workshop_id' => rand(1, 5),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            DB::table('university_major')->insert([
                'major_id' => rand(1, 5),
                'university_id' => rand(1, 5),
            ]);
        }

        Role::create([
            'name' => 'Admin',
        ]);

        Role::create([
            'name' => 'User',
        ]);

        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Notification::factory(5)->create();
        $this->call(SuperAdminSeeder::class);

    }
}
