<?php

use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permission')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 5,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 6,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 7,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 8,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 9,
                'created_at' => now()
            ],
            [
                'role_id' => 1,
                'permission_id' => 10,
                'created_at' => now()
            ]
        ]);
    }
}
