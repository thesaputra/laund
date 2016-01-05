<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@laundry.id',
            'role_id' => '2',
            'name' => 'admin',
            'password' => Hash::make('12341234')
        ]);
    }
}
