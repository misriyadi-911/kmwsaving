<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Pilgrims;
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

        Admin::create([
            'user_account_id' => 1,
            'address' => 'Jl. Raya Kampus UNIRA No. 1, Kec. Baiturrahman, Kota Banda Aceh, Aceh 23239',
            'phone' => '085231339223',
            'gender' => 'laki-laki',
            'created_at' => '2021-07-24 11:36:16',
            'updated_at' => '2021-07-24 11:36:16',
        ]);


        UserAccount::create([
            'username' => 'Jamaah 1',
            'password' => app('hash')->make('qwerty123'),
            'email' => 'umar.ovie@gmail.com',
            'type' => 'jamaah',
            'thumbnail' => 'https://i.ibb.co/0jZGZJd/IMG-20201230-120751.jpg',
        ]);

        $categoris = ['Blue', 'Silver', 'Gold', 'Haji Plus', 'Haji Reguler'];
        $limits = [1000000, 2000000, 3000000, 4000000, 5000000];
        for ($i = 0; $i < count($categoris); $i++) {
            SavingCategories::create([
                'name' => $categoris[$i],
                'limit' => $limits[$i]
            ]);
        }

        Pilgrims::create([
            'pilgrims_id' => 2,
            'kode' => 'PG-0001',
            'user_account_id' => 2,
            'saving_category_id' => 1,
            'bank_name' => 'BNI',
            'bank_account_name' => 'Jamaah 1',
            'no_rekening' => '1234567890',
            'nik' => '1243243423',
            'no_kk' => '1234567890',
            'birth_date' => '1999-12-30',
            'gender' => 'laki-laki',
            'phone' => '085231339223',
            'address' => 'Jl. Raya Kampus UNIRA No. 1, Kec. Baiturrahman, Kota Banda Aceh, Aceh 23239',
            'created_at' => '2021-07-24 11:36:16',
            'updated_at' => '2021-07-24 11:36:16'
        ]);
    }
}
