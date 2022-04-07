<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'genephillip222@gmail.com',
            'name' => 'Gene Phillip D. Artista',
            'password' => Hash::make('genephillip222@gmail.com')
        ]);

        $user->address()->create([
            'address' => '134 Daisy St. Barangay Lingga',
            'city' => 'Calamba',
            'state' => 'Laguna',
            'zip_code' => 4027,
            'country' => 'Philippines'
        ]);

        $user->details()->create([
            'phone_number' => '+639154082715'
        ]);

        $user->socialMediaAccounts()->createMany([
            [
                'name' => 'Gmail',
                'email' => 'genephillipartista@gmail.com',
                'url' => ''
            ],
            [
                'name' => 'Facebook',
                'email' => 'gene_eyeshield21@yahoo.com',
                'url' => 'https://www.facebook.com/genephilippians/'
            ],
            [
                'name' => 'Twitter',
                'email' => '@genephillipians',
                'url' => 'https://twitter.com/genephillipians'
            ]
        ]);
    }
}
