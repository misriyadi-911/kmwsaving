<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\SavingCategories;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserAccount::create([
            'username' => 'Administrator',
            'password' => app('hash')->make('qwerty123'),
            'email' => 'admin@gmail.com',
            'type' => 'admin',
            'thumbnail' => 'https://api.unira.ac.id/img/profil/mhs/d9674b9d198eecaa13f3f057d5390a12.jpg',
        ]);
        UserAccount::create([
            'username' => 'Jamaah 1',
            'password' => app('hash')->make('qwerty123'),
            'email' => 'jamaah1@gmail.com',
            'type' => 'jamaah',
            'thumbnail' => 'https://i.ibb.co/0jZGZJd/IMG-20201230-120751.jpg',
        ]);

        $categoris = ['Blue', 'Silver', 'Gold', 'Haji Plus', 'Haji Reguler'];
        $limits = [1000000, 2000000, 3000000, 4000000, 5000000];
        for ($i=0; $i < count($categoris); $i++) { 
            SavingCategories::create([
                'name' => $categoris[$i],
                'limit' => $limits[$i]
            ]);
        }
    }
}
