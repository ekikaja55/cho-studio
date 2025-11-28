<?php

namespace App\Http\Controllers;

use App\Mail\AdoptionDeliveryMail;
use App\Mail\UniversalNotificationMail; // Import Universal Mail
use App\Models\Adoption;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArtistAdoptionDetailController extends Controller
{
    public function detail($adoptionId)
    {
        $adoption = Adoption::with('gallery')->findOrFail($adoptionId);
        return view("artist.adoption_detail", ["adoption" => $adoption]);
    }

    function update_order_status(Request $request, $adoptionId)
    {
        $request->validate([
            'status' => 'required|string|in:processing,delivered,completed,cancelled'
        ]);

        $adoption = Adoption::with('gallery')->findOrFail($adoptionId);
        $adoption->order_status = $request->status;
        $adoption->save();

        // Panggil Function Notifikasi
        $this->sendNotification($adoption, 'status_updated');

        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }

    function confirm_payment($adoptionId)
    {
        $adoption = Adoption::with('gallery')->findOrFail($adoptionId);
        $adoption->payment_status = 'paid';
        $adoption->order_status = 'processing';
        $adoption->save();

        // Panggil Function Notifikasi
        $this->sendNotification($adoption, 'payment_confirmed');

        return response()->json(['success' => true, 'message' => 'Payment confirmed.']);
    }

    function invalidate_payment($adoptionId)
    {
        $adoption = Adoption::with('gallery')->findOrFail($adoptionId);
        $adoption->order_status = "cancelled";
        $adoption->payment_status = 'invalid';
        $adoption->save();

        $galleryItem = Gallery::findOrFail($adoption->gallery_id);
        $galleryItem->status = "available";
        $galleryItem->save();

        // Panggil Function Notifikasi
        $this->sendNotification($adoption, 'payment_invalid');

        return response()->json(['success' => true, 'message' => 'Payment invalid.']);
    }

    function mark_complete($adoptionId)
    {
        $adoption = Adoption::with('gallery')->findOrFail($adoptionId);
        $adoption->order_status = 'completed';
        $adoption->completed_at = now();
        $adoption->save();

        // Panggil Function Notifikasi
        $this->sendNotification($adoption, 'completed');

        return response()->json(['success' => true, 'message' => 'Marked as completed.']);
    }

    function save_notes(Request $request, $adoptionId)
    {
        $request->validate(['notes' => 'nullable|string|max:2000']);
        $adoption = Adoption::findOrFail($adoptionId);
        $adoption->delivery_notes = $request->notes;
        $adoption->save();
        return response()->json(['success' => true, 'message' => 'Notes saved.']);
    }

    function deliver_file(Request $request, $adoptionId)
    {
        // ... (Logika upload file tetap sama seperti kode Anda) ...
        $request->validate([
            'delivery_file' => 'nullable|file|max:10240',
            'delivery_type' => 'required|string|in:upload_file,link',
        ]);

        $adoption = Adoption::findOrFail($adoptionId);

        if ($request->delivery_type == 'upload_file' && $request->hasFile('delivery_file')) {
            $uploadPath = public_path('adoptions/' . $adoptionId);
            if (!file_exists($uploadPath)) { mkdir($uploadPath, 0755, true); }
            $extension = $request->file('delivery_file')->getClientOriginalExtension();
            $filename = 'delivery_' . time() . '.' . $extension;
            $request->file('delivery_file')->move($uploadPath, $filename);
            $imagePath = 'adoptions/' . $adoptionId . '/' . $filename;

            $adoption->delivery_file = $imagePath;
        } else if ($request->delivery_type == 'link' && $request->has('delivery_link')) {
            $adoption->delivery_file = $request->delivery_link;
        } else {
            return response()->json(['error' => 'No file or link provided'], 422);
        }

        $adoption->delivery_type = $request->delivery_type;
        $adoption->order_status = 'delivered';
        $adoption->save();

        $galleryItem = Gallery::findOrFail($adoption->gallery_id);
        $galleryItem->status = "sold";
        $galleryItem->save();

        $adoptionInfo = Adoption::with('gallery')->findOrFail($adoptionId);

        Mail::to($adoption->email)->send(new AdoptionDeliveryMail($adoptionInfo));

        return response()->json(['success' => true, 'message' => 'Delivered.']);
    }

    // ==========================================
    // PRIVATE FUNCTION UNTUK NOTIFIKASI ADOPTION
    // ==========================================
    private function sendNotification($adoption, $type)
    {
        $details = [
            'Adoption ID' => '#' . $adoption->adoption_id,
            'Artwork' => $adoption->gallery->title ?? '-',
            'Status' => strtoupper($adoption->order_status)
        ];

        // Default Config
        $data = [
            'subject' => 'Update on Adoption #' . $adoption->adoption_id,
            'headline' => 'Status Updated',
            'message' => 'There has been an update to your adoption request.',
            'type' => 'info',
            'image_url' => asset($adoption->gallery->image_url ?? ''),
            'action_url' => url('/member/adoption'), // Sesuaikan route user dashboard
            'action_text' => 'View Order',
            'details' => $details
        ];

        // Logic Per Tipe
        switch ($type) {
            case 'payment_confirmed':
                $data['subject'] = 'Payment Verified: Adoption #' . $adoption->adoption_id;
                $data['headline'] = 'Payment Accepted!';
                $data['message'] = 'We have verified your payment. We will process your files shortly.';
                $data['type'] = 'success';
                break;

            case 'payment_invalid':
                $data['subject'] = 'Payment Issue: Adoption #' . $adoption->adoption_id;
                $data['headline'] = 'Payment Invalid';
                $data['message'] = 'We could not verify your payment. The order has been cancelled.';
                $data['type'] = 'error';
                break;

            case 'completed':
                $data['headline'] = 'Order Completed';
                $data['message'] = 'Thank you for adopting! The order is now marked as completed.';
                $data['type'] = 'success';
                break;
                
            case 'status_updated':
                $data['message'] = 'The artist has updated the status to: <strong>'.strtoupper($adoption->order_status).'</strong>';
                break;
        }

         Mail::to($adoption->email)->send(new \App\Mail\UniversalNotificationMail($data));
    }
}