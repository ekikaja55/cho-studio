<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy member yang sudah ditentukan
        $members = [
            [
                'username' => 'cholazey',
                'email' => 'cholazey@gmail.com',
                'password_plain' => 'mysecretart', 
                'line_id' => 'cholazey.line.id',
                'phone_number' => '080011223344',
                'instagram' => '@cholazey',
                'role' => 'artist', // Ditetapkan sebagai ARTIST
            ],
            [
                'username' => 'klien_vip',
                'email' => 'vip.client@gmail.com',
                'password_plain' => 'vip_client_pass',
                'line_id' => null,
                'phone_number' => '085000111222',
                'instagram' => '@klien_spesial',
                'role' => 'client', // Ditetapkan sebagai CLIENT
            ],
            [
                'username' => 'user_biasa',
                'email' => 'biasa@gmail.com',
                'password_plain' => 'user_pass456',
                'line_id' => 'userlineid',
                'phone_number' => null,
                'instagram' => null,
                'role' => 'client', // Ditetapkan sebagai CLIENT
            ],
        ];

        foreach ($members as $memberData) {
            DB::table('members')->insert([
                'username' => $memberData['username'],
                'email' => $memberData['email'],
                'password' => Hash::make($memberData['password_plain']), // Hashing password
                'line_id' => $memberData['line_id'],
                'phone_number' => $memberData['phone_number'],
                'instagram' => $memberData['instagram'],
                'role' => $memberData['role'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
