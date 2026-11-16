<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // GANTI kata sandi ini sebelum aplikasi dipakai di server sungguhan.
        $akun = [
            ['Admin Toko',      'admin@tokocupang.test',     User::ROLE_ADMIN,    'admin12345'],
            ['Pelanggan Demo',  'pelanggan@tokocupang.test', User::ROLE_CUSTOMER, 'pelanggan123'],
        ];

        foreach ($akun as [$name, $email, $role, $password]) {
            $user = User::firstOrNew(['email' => $email]);
            $user->name = $name;
            $user->password = $password; // di-hash otomatis oleh cast 'hashed'
            $user->role = $role;
            $user->save();
        }
    }
}
