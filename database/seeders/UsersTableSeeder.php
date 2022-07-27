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
            'manufactureName' => 'INYANGE INDUSTRY',
            'location' => 'murindi kigali',
            'phone' => '0789596723',
            'email' => 'inyange@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'Kicukiro',
            'city' => 'kigali',
            'streetNumber' => 'kk105st',
            'ismanufacture' => true
        ]);

        User::create([
            'fname' => 'BRALIRWA',
            'location' => 'sonatubes',
            'phone' => '0789333784',
            'email' => 'bralirwa@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'kicukiro',
            'city' => 'kigali',
            'streetNumber' => 'kk304st',
            'ismanufacture' => true
        ]);

        User::create([
            'fname' => 'sam',
            'lname' => 'john',
            'location' => 'fablab',
            'phone' => '0745893784',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'district' => 'gasabo',
            'city' => 'kigali',
            'streetNumber' => 'kg588st',
            'isadmin' => true
        ]);
    }
}
