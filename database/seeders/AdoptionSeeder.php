<?php
// database/seeders/AdoptionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adoption;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdoptionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('adoptions')->delete();

        $soldGalleries = DB::table('gallery')->where('status', 'sold')->get();

        if ($soldGalleries->isEmpty()) {
            $this->command->warn('⚠️ No "sold" galleries found to seed adoptions.');
            return;
        }

        $adoptions = [];
        foreach ($soldGalleries as $gallery) {
            $adoptions[] = [
                'gallery_id' => $gallery->gallery_id,
                'email' => "buyer" . $gallery->gallery_id . "@example.com",
                'payment_confirmation' => null,
                'order_status' => 'delivered',
                'payment_status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('adoptions')->insert($adoptions);
        $this->command->info('✅ AdoptionSeeder: ' . count($adoptions) . ' dummy adoptions inserted.');

    }
}
