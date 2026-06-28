<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class DebugLoginCommand extends Command
{
    protected $signature = 'debug:login {email} {password}';
    protected $description = 'Debug login credentials';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->info("Mencari pengguna dengan email: {$email}");

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Pengguna tidak ditemukan.");
            return 1;
        }

        $this->info("Pengguna ditemukan: {$user->name}");
        $this->info("Hash password dari database: {$user->password}");
        $this->info("Mencoba memverifikasi password...");

        if (Hash::check($password, $user->password)) {
            $this->info("✅ Password Benar.");
        } else {
            $this->error("❌ Password Salah.");
        }

        return 0;
    }
}
