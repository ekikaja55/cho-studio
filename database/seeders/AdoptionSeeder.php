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

        // $adoptions = [
        //     // 1. Pending order - just placed, waiting for artist confirmation
        //     [
        //         'gallery_id' => 1, // Sunset Dreams
        //         'buyer_name' => 'Jessica Smith',
        //         'buyer_email' => 'jessica.smith@email.com',
        //         'buyer_phone' => '081234567890',
        //         'price' => 150000.00,
        //         'buyer_message' => 'I love this artwork! Can I get the high-res version?',
        //         'delivery_notes' => null,
        //         'order_status' => 'pending',
        //         'payment_status' => 'unpaid',
        //         'confirmed_at' => null,
        //         'paid_at' => null,
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(1),
        //     ],

        //     // 2. Confirmed order - artist approved, waiting for payment
        //     [
        //         'gallery_id' => 2, // Urban Jungle
        //         'buyer_name' => 'Michael Chen',
        //         'buyer_email' => 'michael.chen@email.com',
        //         'buyer_phone' => '081298765432',
        //         'price' => 200000.00,
        //         'buyer_message' => 'This is perfect for my office!',
        //         'delivery_notes' => 'Will send PSD and PNG versions',
        //         'order_status' => 'confirmed',
        //         'payment_status' => 'unpaid',
        //         'confirmed_at' => Carbon::now()->subHours(12),
        //         'paid_at' => null,
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(2),
        //     ],

        //     // 3. Processing order - payment confirmed, artist preparing files
        //     [
        //         'gallery_id' => 3, // Ocean Waves
        //         'buyer_name' => 'Sarah Williams',
        //         'buyer_email' => 'sarah.williams@email.com',
        //         'buyer_phone' => null,
        //         'price' => 120000.00,
        //         'buyer_message' => null,
        //         'delivery_notes' => 'PNG format, 4K resolution',
        //         'order_status' => 'processing',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(3),
        //         'paid_at' => Carbon::now()->subDays(2),
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(4),
        //     ],

        //     // 4. Delivered order - files sent, waiting for buyer confirmation
        //     [
        //         'gallery_id' => 5, // Cherry Blossom
        //         'buyer_name' => 'David Martinez',
        //         'buyer_email' => 'david.martinez@email.com',
        //         'buyer_phone' => '081223344556',
        //         'price' => 135000.00,
        //         'buyer_message' => 'Beautiful work! Looking forward to using it.',
        //         'delivery_notes' => 'Sent via Google Drive - PSD and PNG files included',
        //         'order_status' => 'delivered',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(7),
        //         'paid_at' => Carbon::now()->subDays(6),
        //         'delivered_at' => Carbon::now()->subDays(5),
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(8),
        //         'delivery_type' => 'upload_file',
        //         'delivery_file' => 'adoptions/midnight_garden_180000.zip', // upload method - stored under public/adoptions/
        //         'files_uploaded_at' => Carbon::now()->subDays(11),
        //     ],

        //     // 5. Completed order - fully finished
        //     [
        //         'gallery_id' => 4, // Midnight Garden (marked as sold)
        //         'buyer_name' => 'Emily Johnson',
        //         'buyer_email' => 'emily.johnson@email.com',
        //         'buyer_phone' => '081234123412',
        //         'price' => 180000.00,
        //         'buyer_message' => 'This is exactly what I needed for my project!',
        //         'delivery_notes' => 'All files delivered successfully',
        //         'order_status' => 'completed',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(15),
        //         'paid_at' => Carbon::now()->subDays(14),
        //         'delivered_at' => Carbon::now()->subDays(12),
        //         'completed_at' => Carbon::now()->subDays(10),
        //         'created_at' => Carbon::now()->subDays(16),
        //         'delivery_type' => 'link',
        //         'delivery_file' => 'https://drive.google.com/file/d/1ARptIjiiUlv8DslCOZPrSDDSEWg7kjEI/view?usp=drive_link', // link method
        //         'files_uploaded_at' => Carbon::now()->subDays(11), // upload file method
        //     ],

        //     // 6. Cancelled order
        //     [
        //         'gallery_id' => 6, // Starry Night Sky
        //         'buyer_name' => 'Robert Brown',
        //         'buyer_email' => 'robert.brown@email.com',
        //         'buyer_phone' => null,
        //         'price' => 175000.00,
        //         'buyer_message' => 'Changed my mind, sorry!',
        //         'delivery_notes' => null,
        //         'order_status' => 'cancelled',
        //         'payment_status' => 'unpaid',
        //         'confirmed_at' => Carbon::now()->subDays(5),
        //         'paid_at' => null,
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(6),
        //     ],

        //     // 7. Another pending order
        //     [
        //         'gallery_id' => 7, // Mountain Peak
        //         'buyer_name' => 'Lisa Anderson',
        //         'buyer_email' => 'lisa.anderson@email.com',
        //         'buyer_phone' => '081345678901',
        //         'price' => 160000.00,
        //         'buyer_message' => 'Can I get this in both PSD and AI formats?',
        //         'delivery_notes' => null,
        //         'order_status' => 'pending',
        //         'payment_status' => 'unpaid',
        //         'confirmed_at' => null,
        //         'paid_at' => null,
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subHours(6),
        //     ],

        //     // 8. Processing order with discount
        //     [
        //         'gallery_id' => 8, // Autumn Forest
        //         'buyer_name' => 'James Taylor',
        //         'buyer_email' => 'james.taylor@email.com',
        //         'buyer_phone' => '081456789012',
        //         'price' => 125000.00, // Discounted from 140000
        //         'buyer_message' => 'Thanks for the discount!',
        //         'delivery_notes' => 'Special discount applied - 10% off',
        //         'order_status' => 'processing',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(2),
        //         'paid_at' => Carbon::now()->subDays(1),
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(3),
        //     ],

        //     // proccessing order
        //     [
        //         'gallery_id' => 9, // Winter Wonderland
        //         'buyer_name' => 'Marcella Thamrin',
        //         'buyer_email' => 'marcella.t23@mhs.istts.ac.id',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'processing',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(4),
        //         'paid_at' => Carbon::now()->subDays(3),
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(5),
        //     ],

        //     [
        //         'gallery_id' => 10, // Winter Wonderland
        //         'buyer_name' => 'Marcella Thamrin',
        //         'buyer_email' => 'marcella.t23@mhs.istts.ac.id',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'processing',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(4),
        //         'paid_at' => Carbon::now()->subDays(3),
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(5),
        //     ],

        //     [
        //         'gallery_id' => 2, // Winter Wonderland
        //         'buyer_name' => 'Marcella Thamrin',
        //         'buyer_email' => 'marcella.t23@mhs.istts.ac.id',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'pending',
        //         'payment_status' => 'unpaid',
        //         'delivered_at' => null,
        //         'completed_at' => null,
        //         'created_at' => Carbon::now()->subDays(5),
        //     ],

        //     // order adoption for member id 3
        //     [
        //         'gallery_id' => 3, // Winter Wonderland
        //         'buyer_name' => 'Pengguna Biasa',
        //         'buyer_email' => 'biasa@gmail.com',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'completed',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(10),
        //         'paid_at' => Carbon::now()->subDays(9),
        //         'delivered_at' => Carbon::now()->subDays(7),
        //         'completed_at' => Carbon::now()->subDays(5),
        //         'created_at' => Carbon::now()->subDays(11)
        //     ],

        //     [
        //         'gallery_id' => 3, // Winter Wonderland
        //         'buyer_name' => 'Pengguna Biasa',
        //         'buyer_email' => 'biasa@gmail.com',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'completed',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(10),
        //         'paid_at' => Carbon::now()->subDays(9),
        //         'delivered_at' => Carbon::now()->subDays(7),
        //         'completed_at' => Carbon::now()->subDays(5),
        //         'created_at' => Carbon::now()->subDays(11)
        //     ],

        //     [
        //         'gallery_id' => 3, // Winter Wonderland
        //         'buyer_name' => 'Pengguna Biasa',
        //         'buyer_email' => 'biasa@gmail.com',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'completed',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(10),
        //         'paid_at' => Carbon::now()->subDays(9),
        //         'delivered_at' => Carbon::now()->subDays(7),
        //         'completed_at' => Carbon::now()->subDays(5),
        //         'created_at' => Carbon::now()->subDays(11)
        //     ],

        //     [
        //         'gallery_id' => 3, // Winter Wonderland
        //         'buyer_name' => 'Pengguna Biasa',
        //         'buyer_email' => 'biasa@gmail.com',
        //         'buyer_phone' => '081567890123',
        //         'price' => 155000.00,
        //         'buyer_message' => 'Excited to receive this artwork!',
        //         'delivery_notes' => 'Please provide PNG format',
        //         'order_status' => 'completed',
        //         'payment_status' => 'paid',
        //         'confirmed_at' => Carbon::now()->subDays(10),
        //         'paid_at' => Carbon::now()->subDays(9),
        //         'delivered_at' => Carbon::now()->subDays(7),
        //         'completed_at' => Carbon::now()->subDays(5),
        //         'created_at' => Carbon::now()->subDays(11)
        //     ]
        // ];

        // foreach ($adoptions as $adoption) {
        //     Adoption::create($adoption);
        // }
        // // Ambil gallery_id dari gallery yang available atau sold
        // $eligibleGalleryIds = DB::table('gallery')
        //     ->whereIn('status', ['available', 'sold'])
        //     ->pluck('gallery_id')
        //     ->toArray();

        // $soldGalleries = DB::table('gallery')->where('status', 'sold')->get();

        // if ($soldGalleries->isEmpty()) {
        //     $this->command->warn('⚠️ No "sold" galleries found to seed adoptions.');
        //     return;
        // }

        // $adoptions = [];
        // foreach ($soldGalleries as $gallery) {
        //     $adoptions[] = [
        //         'gallery_id' => collect($eligibleGalleryIds)->random(),
        //         'buyer_name' => "User Example {$i}",
        //         'buyer_email' => "user{$i}@example.com",
        //         'buyer_phone' => '08123456789',
        //         'price' => rand(100000, 300000),
        //         'buyer_message' => "This is a message from User Example {$i}.",
        //         'delivery_notes' => "Please deliver the files in high resolution.",
        //         // Use 'cancelled' to match the enum defined in the migration
        //         'order_status' => collect(['pending', 'confirmed', 'processing', 'delivered', 'cancelled'])->random(),
        //         'payment_status' => collect(['unpaid', 'paid'])->random(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }

        // DB::table('adoptions')->insert($adoptions);
        // $this->command->info('✅ AdoptionSeeder: ' . count($adoptions) . ' dummy adoptions inserted.');
    }
}
