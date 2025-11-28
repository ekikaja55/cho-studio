<?php

namespace App\Http\Controllers;

use App\Mail\UniversalNotificationMail; // Import Universal Mail
use App\Models\Commission;
use App\Models\CommissionProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArtistCommissionDetailController extends Controller
{
    public function detail($id)
    {
        $commission = Commission::with(['progressImages', 'member'])->findOrFail($id);
        return view("artist.commission_detail", [
            'commission' => $commission,
            'member' => $commission->member
        ]);
    }

    function update_progress_status(Request $request, $commissionId)
    {
        $request->validate(['status' => 'required|string']);
        $commission = Commission::with('member')->findOrFail($commissionId);
        $commission->progress_status = $request->status;
        $commission->save();

        $this->sendNotification($commission, 'status_updated');

        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }

    function update_price(Request $request, $commissionId)
    {
        $request->validate(['price' => 'required|numeric|min:0']);
        $commission = Commission::with('member')->findOrFail($commissionId);
        $commission->price = $request->price;
        $commission->save();

        $this->sendNotification($commission, 'price_updated');

        return response()->json(['success' => true, 'message' => 'Price updated.']);
    }

    function update_deadline(Request $request, $commissionId)
    {
        $request->validate(['deadline' => 'required|date|after:today']);
        $commission = Commission::with('member')->findOrFail($commissionId);
        $commission->deadline = $request->deadline;
        $commission->save();

        $this->sendNotification($commission, 'deadline_updated');

        return response()->json(['success' => true, 'message' => 'Deadline updated.']);
    }

    function cancel(Request $request, $commissionId)
    {
        $request->validate(['cancellation_reason' => 'required|string|max:1000']);
        $commission = Commission::with('member')->findOrFail($commissionId);
        $commission->progress_status = 'cancelled';
        $commission->cancellation_reason = $request->cancellation_reason;
        $commission->cancelled_by = 'artist';
        $commission->cancelled_at = now();
        $commission->save();

        $this->sendNotification($commission, 'cancelled');

        return response()->json(['success' => true, 'message' => 'Cancelled.']);
    }

    function update_payment_status(Request $request, $commissionId)
    {
        $request->validate(['payment_status' => 'required|string']);
        $commission = Commission::with('member')->findOrFail($commissionId);
        $commission->payment_status = $request->payment_status;
        if ($request->payment_status === 'paid') { $commission->fully_paid_at = now(); }
        $commission->save();

        $this->sendNotification($commission, 'payment_updated');

        return response()->json(['success' => true, 'message' => 'Payment updated.']);
    }

    function upload_image(Request $request, $commissionId)
    {
        // ... (Validasi & Logic Upload File sama seperti sebelumnya) ...
        $request->validate([
            'image' => 'required|image|max:10240',
            'stage' => 'nullable|string'
        ]);

        $commission = Commission::with(['progressImages', 'member'])->findOrFail($commissionId);
        
        $stage = $request->stage ?? $this->determineNextStage($commission);
        
        $uploadPath = public_path('commissions/' . $commissionId);
        if (!file_exists($uploadPath)) { mkdir($uploadPath, 0755, true); }
        
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $stage . '_' . time() . '.' . $extension;
        $request->file('image')->move($uploadPath, $filename);
        $imagePath = 'commissions/' . $commissionId . '/' . $filename;

        CommissionProgress::create([
            'commission_id' => $commissionId,
            'image_link' => $imagePath,
            'stage' => $stage,
        ]);

        $commission->progress_status = 'review';
        $commission->save();

        // Panggil Notifikasi dengan Extra Data (Path Gambar)
        $this->sendNotification($commission, 'progress_uploaded', ['image_path' => $imagePath, 'stage' => $stage]);

        return response()->json(['success' => true, 'image_path' => $imagePath]);
    }

    // ... (Fungsi determineNextStage sama seperti sebelumnya) ...
    private function determineNextStage($commission) {
        // ... Copy logika determineNextStage anda disini ...
        return 'sketch'; // Dummy return agar tidak error saat dicopy
    }

    // ============================================
    // PRIVATE FUNCTION UNTUK NOTIFIKASI COMMISSION
    // ============================================
    private function sendNotification($commission, $type, $extraData = [])
    {
        $details = [
            'Commission ID' => '#' . $commission->id,
            'Price' => 'Rp ' . number_format($commission->price, 0, ',', '.'),
            'Deadline' => $commission->deadline ? date('d M Y', strtotime($commission->deadline)) : '-',
        ];

        // Default Config
        $data = [
            'subject' => 'Update on Commission #' . $commission->id,
            'headline' => 'Commission Update',
            'message' => 'There is an update on your commission.',
            'type' => 'info',
            'action_url' => url('/member/commission/' . $commission->id),
            'action_text' => 'Check Dashboard',
            'details' => $details
        ];

        switch ($type) {
            case 'progress_uploaded':
                $stageName = ucfirst(str_replace('_', ' ', $extraData['stage'] ?? 'Progress'));
                $data['headline'] = 'New Art Progress!';
                $data['message'] = "Artist has uploaded a new <strong>{$stageName}</strong>. Please review it.";
                $data['type'] = 'success';
                if(isset($extraData['image_path'])) {
                    $data['image_url'] = asset($extraData['image_path']);
                }
                break;

            case 'price_updated':
                $data['headline'] = 'Price Updated';
                $data['message'] = 'The artist has updated the price for your commission.';
                break;

            case 'deadline_updated':
                $data['headline'] = 'Deadline Updated';
                $data['message'] = 'The artist has set/updated the deadline.';
                break;

            case 'cancelled':
                $data['subject'] = 'Commission Cancelled #' . $commission->id;
                $data['headline'] = 'Commission Cancelled';
                $data['message'] = 'We are sorry, the artist has cancelled this commission.<br>Reason: "<i>'.$commission->cancellation_reason.'</i>"';
                $data['type'] = 'error';
                break;

            case 'payment_updated':
                $data['headline'] = 'Payment Status Updated';
                $data['message'] = "Payment status changed to: <strong>" . strtoupper($commission->payment_status) . "</strong>";
                $data['type'] = $commission->payment_status == 'paid' ? 'success' : 'info';
                break;

            case 'status_updated':
                $data['message'] = "Commission status changed to: <strong>" . ucwords(str_replace('_', ' ', $commission->progress_status)) . "</strong>";
                break;
        }

        Mail::to($commission->member->email)->send(new \App\Mail\UniversalNotificationMail($data));
    }
}