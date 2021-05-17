<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->insert([
            [
                'name' => 'Create new topic',
                'created_at' => now()
            ],
            [
                'name' => 'View topic list',
                'created_at' => now()
            ],
            [
                'name' => 'Update topic setting',
                'created_at' => now()
            ],
            [
                'name' => 'Update topic content (incl. topic version, docs breakdown and post)',
                'created_at' => now()
            ],
            [
                'name' => 'Delete topic',
                'created_at' => now()
            ],
            [
                'name' => 'View user list',
                'created_at' => now()
            ],
            [
                'name' => 'Create new user',
                'created_at' => now()
            ],
            [
                'name' => 'Update user',
                'created_at' => now()
            ],
            [
                'name' => 'Delete user',
                'created_at' => now()
            ],
            [
                'name' => 'Manage user permission',
                'created_at' => now()
            ],
        ]);
    }
}
