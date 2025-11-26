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
        $galleries = Gallery::orderBy('updated_at', 'desc')->get();
        $adoptions = Adoption::with('gallery')->get();

        // Gabungkan data jika perlu (contoh: tampilkan semua gallery dengan status)
        $galleryData = $galleries->map(function ($item) use ($adoptions) {
            $adoption = $adoptions->firstWhere('gallery_id', $item->gallery_id);
            return [
                'gallery_id' => $item->gallery_id,
                'image_url' => asset($item->image_url),
                'title' => $item->title,
                'description' => $item->description,
                'price' => $item->price,
                'file_format' => $item->file_format,
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
            Storage::disk('public')->delete(asset($gallery->image_url));
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
            'status' => 'nullable|string|in:available,not_sold',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('image')) {

            // Hapus gambar lama (gunakan public_path!)
            if ($gallery->image_url && file_exists(public_path($gallery->image_url))) {
                unlink(public_path($gallery->image_url));
            }

            // Simpan gambar baru
            $filename = $id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('gallery_image'), $filename);

            $gallery->image_url = 'gallery_image/' . $filename;
        }

        // update data lain
        $gallery->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_format' => $validated['file_format'],
            'price' => $validated['price'] ?? null,
            'status' => $validated['status'] ?? ($validated['price'] ? 'available' : 'not_sold'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery updated successfully.',
            'gallery' => [
                'gallery_id' => $gallery->gallery_id,
                'image_url' => asset($gallery->image_url),
                'title' => $gallery->title,
                'description' => $gallery->description,
                'price' => $gallery->price,
                'status' => $gallery->status,
                'file_format' => $gallery->file_format,
            ],
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
            'status' => 'nullable|string|in:available,not_sold',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('gallery_image'), $filename);

        $imageUrl = 'gallery_image/' . $filename;


        $gallery = Gallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imageUrl,
            'file_format' => $validated['file_format'],
            'price' => $validated['price'] ?? null,
            'status' => $validated['status'] ?? 'available',
        ]);

        return response()->json([
            'success' => true,
            'gallery' => [
                'gallery_id' => $gallery->gallery_id,
                'image_url' => asset($gallery->image_url),
                'title' => $gallery->title,
                'description' => $gallery->description,
                'price' => $gallery->price,
                'status' => $gallery->status,
                'file_format' => $gallery->file_format,
            ],
        ]);
    }
}
