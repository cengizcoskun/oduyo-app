<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::updateOrCreate(['id' => 1], [
            'project_title' => 'Oduyo App',
            'project_description' => 'Laravel 11, MySQL ve Vue.js kullanarak güvenli ve sağlam bir ödeme platformu geliştirmek, Garanti sanal POS ile dokümanına uygun şekilde 3D ve 2D işlemleri gerçekleştirebilmek.',

            'bank_name' => 'Garanti Bankası',
            'merchant_id' => 7000679,
            'prov_user_id' => 'PROVAUT',
            'provision_password' => '123qweASD/',
            'terminal_id' => 30691297,
            'store_key' => 12345678,
            'pos_url' => 'https://sanalposprovtest.garantibbva.com.tr/VPServlet',
        ]);
    }
}
