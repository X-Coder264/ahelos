<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ahelos\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        User::create([
            'name' => 'Mario',
            'surname' => 'Šunc',
            'company' => 'Šunc d.o.o.',
            'company_id' => '12345678910',
            'post' => ' 10297',
            'place' => 'Jakovlje',
            'address' => 'Zagrebačka 9b',
            'phone' => '0981962984',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456', ['rounds' => 15]),
            'admin' => true,
            'verified' => true
        ]);

        //factory(Ahelos\User::class, 11)->create();

        Model::reguard();
    }
}
