<?php
class UserSeeder extends Seeder {
    public function run()
    {
        User::create([
            'email'    => 'admin@penghaining.com',
            'password' => Hash::make('123456'),
            'nickname' => 'admin',
            'is_admin' => 1,
        ]);
    }
}
?>