<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
            INSERT INTO users
            (company_id, name, email, password, role, created_at, updated_at)
            VALUES
            (
                NULL,
                'Super Admin',
                'superadmin@admin.com',
                '".Hash::make('Admin@123')."',
                'super_admin',
                NOW(),
                NOW()
            )
        ");
    }
}
