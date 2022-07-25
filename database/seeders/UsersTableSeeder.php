<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        User::create([
            'fname'=>'kalisa',
            'lname'=>'kiki',
            'location'=>'Niboye',
            'phone'=>'0789596784',
            'email'=>'kalisa@gmail.com',
            'password'=>Hash::make('password'),
            'district'=>'kicukiro',
            'city'=>'kigali',
            'streetNumber'=>'kk105st',
            'iscollector'=>true
        ]);

        User::create([
            'fname' => 'musangwa',
            'lname' => 'robert',
            'location' => 'Kanombe',
            'phone' => '0789596784',
            'email' => 'robert@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'kicukiro',
            'city' => 'kigali',
            'streetNumber' => 'kk105st',
            'iscollector' => true
        ]);

        User::create([
            'fname' => 'hakiza',
            'lname' => 'jean',
            'location' => 'Nyamirambo',
            'phone' => '0789596723',
            'email' => 'hakiza@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'Nyarugenge',
            'city' => 'kigali',
            'streetNumber' => 'kn105st',
            'ismanufacture' => true
        ]);

        User::create([
            'fname' => 'mugabo',
            'lname' => 'robert',
            'location' => 'kimironko',
            'phone' => '0789333784',
            'email' => 'mugabo@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'gasabo',
            'city' => 'kigali',
            'streetNumber' => 'kg105st',
            'ismanufacture' => true
        ]);

        User::create([
            'fname' => 'sam',
            'lname' => 'john',
            'location' => 'fablab',
            'phone' => '0745893784',
            'email' => 'sam@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'gasabo',
            'city' => 'kigali',
            'streetNumber' => 'kg588st',
            'isadmin' => true
        ]);
    }
}
