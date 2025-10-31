<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run()
    {
        // create admin
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin',
            'password' => Hash::make('secret'),
            'role' => 'admin'
        ]);

        // create workers
        $worker1 = User::firstOrCreate([
            'email' => 'worker1@example.com'
        ], [
            'name' => 'Worker One',
            'password' => Hash::make('secret'),
            'role' => 'worker'
        ]);

        $worker2 = User::firstOrCreate([
            'email' => 'worker2@example.com'
        ], [
            'name' => 'Worker Two',
            'password' => Hash::make('secret'),
            'role' => 'worker'
        ]);

        // sample tasks
        Task::firstOrCreate(['title' => 'Design landing page'], [
            'description' => 'Create the initial landing page design',
            'priority' => 'high',
            'assigned_to' => $worker1->id,
            'created_by' => $admin->id,
            'due_date' => now()->addDays(7)->toDateString(),
        ]);

        Task::firstOrCreate(['title' => 'Prepare demo data'], [
            'description' => 'Seed the application with demo data',
            'priority' => 'normal',
            'assigned_to' => $worker2->id,
            'created_by' => $admin->id,
            'due_date' => now()->addDays(3)->toDateString(),
        ]);
    }
}
