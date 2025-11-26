<?php
// database/seeders/AdoptionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adoption;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdoptionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear previous adoptions (keep simple delete to work across DB drivers)
        DB::table('adoptions')->delete();

        // Load payment confirmation images from public/adoption_payment
        $paymentFolder = public_path('adoption_payment');
        $paymentFiles = File::exists($paymentFolder) ? File::files($paymentFolder) : [];
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        $paymentList = [];
        foreach ($paymentFiles as $pf) {
            $ext = strtolower($pf->getExtension());
            if (!in_array($ext, $validExtensions)) {
                continue;
            }
            $paymentList[] = $pf->getFilename();
        }

        // Grab galleries that are either sold or reserved
        $galleries = DB::table('gallery')->whereIn('status', ['sold', 'reserved'])->get();

        if ($galleries->isEmpty()) {
            $this->command->warn('No "sold" or "reserved" galleries found to seed adoptions.');
            return;
        }

        $inserted = 0;
        $skipped = 0;
        $adoptions = [];

        foreach ($galleries as $gallery) {
            // Skip if an adoption already exists for this gallery_id
            $exists = DB::table('adoptions')->where('gallery_id', $gallery->gallery_id)->exists();
            if ($exists) {
                $skipped++;
                continue;
            }

            // Determine adoption/order/payment statuses based on gallery status
            if (!empty($gallery->updated_at)) {
                $galleryTime = Carbon::parse($gallery->updated_at);
            } elseif (!empty($gallery->created_at)) {
                $galleryTime = Carbon::parse($gallery->created_at);
            } else {
                $galleryTime = Carbon::now();
            }

            if ($gallery->status === 'sold') {
                $orderStatus = 'delivered';
                $paymentStatus = 'paid';
                $adoptionTime = $galleryTime->copy()->addDays(rand(1, 14));
            } else { // reserved
                $orderStatus = 'placed';
                $paymentStatus = 'pending';
                $adoptionTime = $galleryTime->copy()->addDays(rand(0, 7));
            }

            // Select payment confirmation image:
            // 1) try to find a file that contains the gallery_id in its name
            // 2) otherwise, take the next available payment file
            $paymentConfirmation = null;
            $foundKey = null;
            foreach ($paymentList as $key => $filename) {
                if (strpos($filename, (string)$gallery->gallery_id) !== false) {
                    $paymentConfirmation = 'adoption_payment/' . $filename;
                    $foundKey = $key;
                    break;
                }
            }
            if ($paymentConfirmation === null && !empty($paymentList)) {
                // take the first unused one
                $filename = array_shift($paymentList);
                $paymentConfirmation = 'adoption_payment/' . $filename;
            } elseif ($foundKey !== null) {
                // remove used file from list
                unset($paymentList[$foundKey]);
                // reindex array to keep array_shift behavior consistent
                $paymentList = array_values($paymentList);
            }

            // randomly set between random email and members email
            $useMemberEmail = mt_rand(0, 2);
            if ($useMemberEmail === 1) {
                $email = 'biasa@gmail.com';
            } elseif ($useMemberEmail === 2) {
                $email = 'vip.client@gmail.com';
            } else {
                $email = "randombuyer@example.com";
            }

            $adoptions[] = [
                'gallery_id' => $gallery->gallery_id,
                'email' => $email,
                'payment_confirmation' => $paymentConfirmation,
                'order_status' => $orderStatus,
                'payment_status' => $paymentStatus,
                "delivery_notes" => "",
                "delivery_type" => $orderStatus == "delivered" ? "link" : null,
                'delivery_file' => $orderStatus == "delivered" ? "https://drive.google.com/file/d/1-XtTcKqzTsduUHaEjKZN6YBs8hPe_2G6/view?usp=sharing" : null,
                // ensure datetime strings for DB inserts
                'created_at' => $adoptionTime->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];

            $inserted++;
        }

        if (!empty($adoptions)) {
            DB::table('adoptions')->insert($adoptions);
        }

        $this->command->info("AdoptionSeeder: inserted {$inserted} adoptions, skipped {$skipped} existing.");
    }
}
