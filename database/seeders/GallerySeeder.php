<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // Path folder tempat gambar disimpan
        $imageFolder = public_path('gallery_image');

        // Ambil semua file dalam folder (boleh kosong)
        $images = File::exists($imageFolder) ? File::files($imageFolder) : [];

        // Hindari ID duplicate jika seeder dijalankan beberapa kali
        $startId = (int) DB::table('gallery')->max('gallery_id');

        // Hard-coded realistic dataset (no Faker, no fallbacks)
        $seedData = [
            [
                'title' => 'Sunset Over The Harbor',
                'description' => 'Warm tones of a late-afternoon sun reflecting on calm waters. Framed and ready for exhibition.',
                'price' => 75000,
                'status' => 'available',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Abstract Color Study',
                'description' => 'Bold brush strokes and layered textures exploring motion and depth.',
                'price' => 120000,
                'status' => 'sold',
                'file_format' => 'PNG',
            ],
            [
                'title' => 'Portrait: Quiet Gaze',
                'description' => 'A tight portrait study capturing subtle emotion and light across the face.',
                'price' => 95000,
                'status' => 'sold',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Industrial Geometry',
                'description' => 'High-contrast study of shapes and steel; minimal color palette.',
                'price' => 65000,
                'status' => 'reserved',
                'file_format' => 'PNG',
            ],
            [
                'title' => 'Forest Morning',
                'description' => 'Mist between trees with soft green highlights—a calming landscape piece.',
                'price' => 88000,
                'status' => 'reserved',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Vintage Architecture',
                'description' => 'Study of old facades and ornate details in natural light.',
                'price' => 70000,
                'status' => 'sold',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Macro: Dew on Petal',
                'description' => 'Close-up study of texture and color with shallow depth of field.',
                'price' => 45000,
                'status' => 'available',
                'file_format' => 'PNG',
            ],
            [
                'title' => 'Night Traffic Trails',
                'description' => 'Long exposure capturing movement and urban rhythm.',
                'price' => 98000,
                'status' => 'available',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Minimal Still Life',
                'description' => 'Soft light, careful composition, and muted tones for a refined result.',
                'price' => 53000,
                'status' => 'available',
                'file_format' => 'PNG',
            ],
            [
                'title' => 'Coastal Cliffs',
                'description' => 'Dramatic coastline captured with wide-angle perspective.',
                'price' => 110000,
                'status' => 'available',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Cityscape at Dusk',
                'description' => 'Skyline silhouette against a colorful sunset sky.',
                'price' => 115000,
                'status' => 'available',
                'file_format' => 'JPG',
            ],
            [
                'title' => 'Floral Explosion',
                'description' => 'Vibrant bouquet captured with high saturation and contrast.',
                'price' => 60000,
                'status' => 'available',
                'file_format' => 'PNG',
            ],
            // add more entries as needed...
        ];

        $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'psd', 'blend'];

        $totalImages = count($images);
        if ($totalImages === 0) {
            $this->command->info('GallerySeeder: No images found in public/gallery_image — nothing to insert.');
            return;
        }

        foreach ($images as $index => $imageFile) {
            $ext = strtolower($imageFile->getExtension());
            if (!in_array($ext, $validExtensions)) {
                // skip non-image files
                continue;
            }

            // Use seedData metadata if available, otherwise derive from filename
            if (array_key_exists($index, $seedData)) {
                $meta = $seedData[$index];
                $title = $meta['title'];
                $description = $meta['description'];
                $price = $meta['price'];
                $status = $meta['status'];
                $fileFormat = strtoupper($ext ?: $meta['file_format']);
            } else {
                // derive title from filename
                $name = pathinfo($imageFile->getFilename(), PATHINFO_FILENAME);
                $title = ucwords(str_replace(['-', '_'], ' ', $name));
                $description = 'Imported image: ' . $name;
                $price = 50000;
                $status = 'available';
                $fileFormat = strtoupper($ext);
            }

            DB::table('gallery')->insert([
                'gallery_id' => $startId + $index + 1,
                'title' => $title,
                'description' => $description,
                'image_url' => 'gallery_image/' . $imageFile->getFilename(),
                'file_format' => $fileFormat,
                'status' => $status,
                'price' => $price,
                'created_at' => now()->subDays(rand(0, 720)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info("GallerySeeder: Inserted images from public/gallery_image ({$totalImages} files scanned).");
    }
}
