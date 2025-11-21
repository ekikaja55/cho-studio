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

        // Ambil semua file dalam folder
        $images = File::files($imageFolder);

        foreach ($images as $index => $imageFile) {

            DB::table('gallery')->insert([
                'gallery_id' => $index + 1,
                'title' => 'Gallery Item ' . ($index + 1),
                'description' => 'Auto-generated description.',
                'image_url' => 'gallery_image/' . $imageFile->getFilename(),
                'file_format' => strtoupper($imageFile->getExtension()),
                'status' => 'available',
                'price' => rand(10000, 100000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('📸 GallerySeeder: Berhasil load gambar dari /public/gallery_image');
    }
}
