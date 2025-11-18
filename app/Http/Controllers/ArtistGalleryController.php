<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Adoption;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ArtistGalleryController extends Controller
{
    public function index()
    {
        // Ambil data gallery dan relasi adopsi (jika ada)
        $galleries = Gallery::where('status', 'available')->get();
        $adoptions = Adoption::with('gallery')->get();

        // Gabungkan data jika perlu (contoh: tampilkan semua gallery dengan status)
        $galleryData = $galleries->map(function ($item) use ($adoptions) {
            $adoption = $adoptions->firstWhere('gallery_id', $item->gallery_id);
            return [
                'gallery_id' => $item->gallery_id,
                'image_url' => $item->image_url,
                'title' => $item->title,
                'description' => $item->description,
                'price' => $item->price,
                'file_type' => $item->file_type,
                'purchase' => $item->purchase,
                'status' => $adoption ? $adoption->order_status : 'available'
            ];
        });

        return view('artist.gallery', compact('galleryData'));
    }
    
    public function destroy($id): JsonResponse
    {
        $gallery = Gallery::findOrFail($id);

        // hapus file gambar
        if ($gallery->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $gallery->image_url));
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery deleted successfully.',
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'file_format' => 'required|string|max:10',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        // kalau user upload gambar baru
        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($gallery->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $gallery->image_url));
            }
            $path = $request->file('image')->store('gallery', 'public');
            $gallery->image_url = Storage::url($path);
        }

        // update data lainnya
        $gallery->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_format' => $validated['file_format'],
            'price' => $validated['price'] ?? null,
            'status' => $validated['price'] ? 'available' : 'draft',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery updated successfully.',
            'gallery' => $gallery,
        ]);
    }


    /**
     * Store a newly created gallery item.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'file_format' => 'required|string|max:10',
            'price' => 'nullable|numeric',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        // Store image on public disk inside 'gallery' folder
        $path = $request->file('image')->store('gallery', 'public');
        // Use Storage::url when returning to views that expect a full URL
        $imageUrl = Storage::url($path);

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imageUrl,
            'file_format' => $validated['file_format'],
            'price' => $validated['price'] ?? null,
            'status' => 'available',
        ]);

        return response()->json([
            'success' => true,
            'gallery' => [
                'gallery_id' => $gallery->gallery_id,
                'image_url' => $gallery->image_url,
                'title' => $gallery->title,
                'description' => $gallery->description,
                'price' => $gallery->price,
                'file_format' => $gallery->file_format,
            ],
        ]);
    }
}
