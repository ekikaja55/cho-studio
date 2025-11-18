<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Adoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAdoptionNotification; // Pastikan Anda sudah membuat Mailable ini
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
        // Ambil semua gallery yang statusnya 'available' sebagai "adopted" di konteks Anda
        $adopted = Gallery::whereIn('status', ['available','sold'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Semua gallery yang berstatus 'archived' dianggap non-adopted
        $nonAdopted = Gallery::where('status', 'archived')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pilih satu adopted item (available) untuk tampil di kiri
        $mainAdopted = $adopted->first();

        // Untuk section "ready to buy" kita tampilkan adopted items (available ones)
        $designs = $adopted;

        // Daftar gallery_id yang sudah lunas (payment_status = 'paid') dan gallery masih 'available'
        $paidIdsRaw = Adoption::where('payment_status', 'paid')->pluck('gallery_id')->toArray();
        $paidIds = Gallery::whereIn('gallery_id', $paidIdsRaw)
            ->where('status', 'available')
            ->pluck('gallery_id')
            ->toArray();

        return view('gallery', compact('designs', 'mainAdopted', 'nonAdopted', 'paidIds'));
    }

    /**
     * Menyimpan data adopsi baru, mengunggah file, dan mengirim email.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gallery_id' => 'required|exists:gallery,gallery_id',
            'email' => 'required|email|max:255',
            // allow png/jpg/jpeg + webp/svg; ensure it's a file and limit 5MB
            'paymentProof' => 'required|file|mimes:jpeg,png,jpg,webp,svg|max:5120', // max 5MB
        ]);

        if ($validator->fails()) {
            // Extra debug for file mime/extension if present (safe to log)
            $fileDebug = null;
            if ($request->hasFile('paymentProof')) {
                try {
                    $f = $request->file('paymentProof');
                    $fileDebug = [
                        'client_mime' => $f->getClientMimeType(),
                        'client_ext' => $f->getClientOriginalExtension(),
                        'size' => $f->getSize(),
                    ];
                } catch (\Exception $e) {
                    $fileDebug = ['error' => $e->getMessage()];
                }
            }

            Log::warning('Adoption validation failed', [
                'errors' => $validator->errors()->toArray(),
                'request_keys' => array_keys($request->all()),
                'has_file' => $request->hasFile('paymentProof'),
                'file_debug' => $fileDebug,
            ]);

            // Return friendlier error messages (include detected mime for helpful debugging)
            $errors = $validator->errors()->toArray();
            if (isset($errors['paymentProof'])) {
                $errors['paymentProof'][] = 'Allowed file types: jpeg, jpg, png, webp, svg. Max size 5MB.';
            }
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        $galleryItem = Gallery::find($request->gallery_id);
        if (!$galleryItem || $galleryItem->status !== 'available') {
            return response()->json(['success' => false, 'message' => 'Sorry, this artwork is no longer available.'], 404);
        }

        $filePath = null;
        if ($request->hasFile('paymentProof')) {
            $file = $request->file('paymentProof');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('payment_confirmations', $fileName, 'public');
        }

        // Build adoption data
        $adoptionData = [
            'gallery_id' => $galleryItem->gallery_id,
            'email' => $request->email,
            'payment_confirmation' => $filePath, // simpan path bukti pembayaran
            'order_status' => 'placed', // default saat baru kirim bukti
            'payment_status' => 'pending', // tunggu verifikasi admin
        ];

        $adoption = Adoption::create($adoptionData);

        // NOTE: do NOT mark gallery->status = 'sold' here.
        // Keep gallery.status in DB controlled by admin or when adoption.payment_status == 'paid'.

        // Prepare email recipients
        $adminEmail = env('MAIL_USERNAME', config('mail.from.address', null));
        $buyerEmail = $adoption->email;

        // Send emails: admin notification + buyer confirmation
        try {
            // Admin notification
          Log::info('Queueing emails for adoption ID: ' . $adoption->adoption_id);
            if ($adminEmail) {
                Mail::to($adminEmail)->queue(new AdminAdoptionNotification($adoption));
            }
            if ($buyerEmail) {
                Mail::to($buyerEmail)->queue(new AdoptionConfirmation($adoption));
            }
        } catch (\Exception $e) {
            // don't fail the request — log the error
            Log::error('Failed to queue email for adoption ID ' . $adoption->adoption_id . ': ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Submission successful!']);
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('gallery.index', compact('gallery'));
    }

    public function processAdoption(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        
        $adoption = Adoption::create([
            'gallery_id' => $gallery->id,
            'adoption_id' => 'ADP' . time(),
            'email' => $request->email,
            'payment_status' => 'pending',
            // Add other necessary fields
        ]);

        // Send email
        Mail::to($adoption->email)->send(new AdoptionDeliveryMail($adoption));

        return back()->with('success', 'Email sent successfully!');
    }
}