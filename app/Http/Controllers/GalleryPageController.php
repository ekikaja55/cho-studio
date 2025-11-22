<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AdminAdoptionNotification;
use App\Mail\AdoptionConfirmation;
use App\Mail\AdoptionDeliveryMail;

class GalleryPageController extends Controller
{
    /**
     * Menampilkan halaman galeri dengan data dari database.
     * Mengambil HANYA galeri yang statusnya 'available'.
     */
    public function index()
    {
        // Fetch all gallery items ordered by newest first
        $allGallery = Gallery::orderBy('created_at', 'desc')->get();

        // available: items that are available for adoption/sale
        $available = $allGallery->where('status', 'available')->values();

        // not_sold: items that are not for sale (not_sold status)
        $not_sold = $allGallery->where('status', 'not_sold')->values();

        $allGalleryExceptNotSold = $allGallery->where('status', '!=', 'not_sold')->values();

        // Return only the requested collections: available, not_sold, and allGallery
        return view('gallery.gallery', compact('available', 'not_sold', 'allGalleryExceptNotSold'));
    }

    /**
     * Menyimpan data adopsi baru, mengunggah file, dan mengirim email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:gallery,gallery_id',
            'email' => 'required|email|max:255',
            // allow png/jpg/jpeg + webp/svg; ensure it's a file and limit 5MB
            'paymentProof' => 'required|file|mimes:jpeg,png,jpg,webp,svg|max:5120', // max 5MB
        ]);

        // create new adoption record
        $adoption = new Adoption();
        $adoption->gallery_id = $request->gallery_id;
        $adoption->email = $request->email;
        $adoption->order_status = 'placed';
        $adoption->payment_status = 'pending';
        $adoption->save();

        if ($request->has("paymentProof")) {
            $uploadPath = public_path('adoption_payment');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Use the model primary key (may be 'adoption_id') rather than assuming 'id'
            $pkName = $adoption->getKeyName();
            $pkValue = $adoption->{$pkName} ?? null;

            // Normalize extension to lowercase to avoid ".PNG" style names
            $extension = strtolower($request->file('paymentProof')->getClientOriginalExtension() ?? '');

            // Fallback to timestamp if primary key is missing for any reason
            if (empty($pkValue)) {
                $pkValue = time();
            }

            $fileName = $pkValue . ($extension ? '.' . $extension : '');
            $request->file('paymentProof')->move($uploadPath, $fileName);
            $adoption->payment_confirmation = 'adoption_payment/' . $fileName;
            $adoption->save();
        }

        // update gallery status to 'reserved'
        $galleryItem = Gallery::find($request->gallery_id);
        if ($galleryItem) {
            $galleryItem->status = 'reserved';
            $galleryItem->save();
        }

        Mail::to($request->email)->send(new AdoptionConfirmation($adoption));
        Mail::to(env('MAIL_USERNAME', config('mail.from.address', null)))->send(new AdminAdoptionNotification($adoption));

        return response()->json(['success' => true, 'message' => 'Submission successful!']);

        // if ($validator->fails()) {
        //     // Extra debug for file mime/extension if present (safe to log)
        //     $fileDebug = null;
        //     if ($request->hasFile('paymentProof')) {
        //         try {
        //             $f = $request->file('paymentProof');
        //             $fileDebug = [
        //                 'client_mime' => $f->getClientMimeType(),
        //                 'client_ext' => $f->getClientOriginalExtension(),
        //                 'size' => $f->getSize(),
        //             ];
        //         } catch (\Exception $e) {
        //             $fileDebug = ['error' => $e->getMessage()];
        //         }
        //     }

        //     Log::warning('Adoption validation failed', [
        //         'errors' => $validator->errors()->toArray(),
        //         'request_keys' => array_keys($request->all()),
        //         'has_file' => $request->hasFile('paymentProof'),
        //         'file_debug' => $fileDebug,
        //     ]);

        //     // Return friendlier error messages (include detected mime for helpful debugging)
        //     $errors = $validator->errors()->toArray();
        //     if (isset($errors['paymentProof'])) {
        //         $errors['paymentProof'][] = 'Allowed file types: jpeg, jpg, png, webp, svg. Max size 5MB.';
        //     }
        //     return response()->json(['success' => false, 'errors' => $errors], 422);
        // }

        // $galleryItem = Gallery::find($request->gallery_id);
        // if (!$galleryItem || $galleryItem->status !== 'available') {
        //     return response()->json(['success' => false, 'message' => 'Sorry, this artwork is no longer available.'], 404);
        // }

        // $filePath = null;
        // if ($request->hasFile('paymentProof')) {
        //     $file = $request->file('paymentProof');
        //     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //     $filePath = $file->storeAs('payment_confirmations', $fileName, 'public');
        // }

        // // Build adoption data
        // $adoptionData = [
        //     'gallery_id' => $galleryItem->gallery_id,
        //     'email' => $request->email,
        //     'payment_confirmation' => $filePath, // simpan path bukti pembayaran
        //     'order_status' => 'placed', // default saat baru kirim bukti
        //     'payment_status' => 'pending', // tunggu verifikasi admin
        // ];

        // $adoption = Adoption::create($adoptionData);

        // // NOTE: do NOT mark gallery->status = 'sold' here.
        // // Keep gallery.status in DB controlled by admin or when adoption.payment_status == 'paid'.

        // // Prepare email recipients
        // $adminEmail = env('MAIL_USERNAME', config('mail.from.address', null));
        // $buyerEmail = $adoption->email;

        // // Send emails: admin notification + buyer confirmation
        // try {
        //     // Admin notification
        //   Log::info('Queueing emails for adoption ID: ' . $adoption->adoption_id);
        //     if ($adminEmail) {
        //         Mail::to($adminEmail)->send(new AdminAdoptionNotification($adoption));
        //     }
        //     if ($buyerEmail) {
        //         Mail::to($buyerEmail)->send(new AdoptionConfirmation($adoption));
        //     }
        // } catch (\Exception $e) {
        //     // don't fail the request — log the error
        //     Log::error('Failed to queue email for adoption ID ' . $adoption->adoption_id . ': ' . $e->getMessage());
        // }

        // return response()->json(['success' => true, 'message' => 'Submission successful!']);
    }

    // public function show($id)
    // {
    //     $gallery = Gallery::findOrFail($id);
    //     return view('gallery.index', compact('gallery'));
    // }

    /**
     * Return a minimal, safe JSON payload for a gallery item.
     * This endpoint is intended to be called from client-side code
     * and only returns non-sensitive public fields.
     */
    public function json($id)
    {
        $gallery = Gallery::where('gallery_id', $id)->first();
        if (!$gallery) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // Determine if this gallery has a paid adoption
        $isPaid = Adoption::where('gallery_id', $gallery->gallery_id)->where('payment_status', 'paid')->exists();

        $payload = [
            'id' => $gallery->gallery_id,
            'title' => $gallery->title,
            'price' => $gallery->price,
            'image_url' => asset($gallery->image_url),
            'file_format' => $gallery->file_format,
            'status' => $gallery->status,
            'is_paid' => $isPaid,
        ];

        return response()->json($payload);
    }

    // public function processAdoption(Request $request, $id)
    // {
    //     $gallery = Gallery::findOrFail($id);
    //     Gallery::where('id', $request->$id)->update([
    //         'status' => 'reserved'
    //     ]);

    //     $adoption = Adoption::create([
    //         'gallery_id' => $gallery->id,
    //         'adoption_id' => 'ADP' . time(),
    //         'email' => $request->email,
    //         'payment_status' => 'pending',
    //         // Add other necessary fields
    //     ]);

    //     // Send email
    //     Mail::to($adoption->email)->send(new AdoptionDeliveryMail($adoption));

    //     return back()->with('success', 'Email sent successfully!');
    // }
}
