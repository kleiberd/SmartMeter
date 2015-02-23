<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->insert([
            'username'      => 'admin',
            'email'         => 'admin@example.com',
            'password'      => Hash::make('admin'),
            'admin'         => true,
            'created_at'    => new DateTime(),
            'updated_at'    => new DateTime()
        ]);
    }

}