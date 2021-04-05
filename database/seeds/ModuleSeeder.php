<?php

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('module')->insert([
            'name' => 'Home',
            'url' => "/admin/",
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'Post',
            'url' => '',
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'User Management',
            'url' => '',
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'View post',
            'url' => '/admin/post/view',
            'parent_id' => 2,
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'Create new topic',
            'url' => '/admin/post/new-topic',
            'parent_id' => 2,
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'View user list',
            'url' => '/admin/user-management/view-user-list',
            'parent_id' => 3,
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'Create new user',
            'url' => '/admin/user-management/new-user',
            'parent_id' => 3,
            'created_at' => now()
        ]);

        DB::table('module')->insert([
            'name' => 'Manage access',
            'url' => '/admin/user-management/manage-access',
            'parent_id' => 3,
            'created_at' => now()
        ]);
    }
}
