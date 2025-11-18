<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistCommissionDetailController extends Controller
{
    public function detail($id)
    {
        $commission = Commission::with(['progressImages', 'member'])
            ->findOrFail($id);
        // dd($commission);
        return view("artist.commission_detail", [
            'commission' => $commission,
            'member' => $commission->member
        ]);
    }

    function update_progress_status(Request $request, $commissionId)
    {
        $request->validate([
            'status' => 'required|string|in:accepted,declined,in_progress_sketch, in_progress_coloring, completed, cancelled'
        ]);

        $commission = Commission::findOrFail($commissionId);
        $commission->progress_status = $request->status;
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Commission status updated successfully.'
        ]);
    }

    function update_price(Request $request, $commissionId)
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $commission = Commission::findOrFail($commissionId);
        $commission->price = $request->price;
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Commission price updated successfully.'
        ]);
    }

    function update_deadline(Request $request, $commissionId)
    {
        $request->validate([
            'deadline' => 'required|date|after:today'
        ]);

        $commission = Commission::findOrFail($commissionId);
        $commission->deadline = $request->deadline;
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Commission deadline updated successfully.'
        ]);
    }

    function cancel(Request $request, $commissionId)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:1000'
        ]);

        $commission = Commission::findOrFail($commissionId);
        $commission->progress_status = 'cancelled';
        $commission->cancellation_reason = $request->cancellation_reason;
        $commission->cancelled_by = 'artist';
        $commission->cancelled_at = now();
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Commission cancelled successfully.'
        ]);
    }

    function update_payment_status(Request $request, $commissionId)
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,dp,paid,refunded'
        ]);

        $commission = Commission::findOrFail($commissionId);
        $commission->payment_status = $request->payment_status;
        if ($request->payment_status === 'paid') {
            $commission->fully_paid_at = now();
        }
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully.'
        ]);
    }

    /**
     * Unified upload handler for both progress and revision images
     * Determines the stage based on previous uploads and commission status
     */
    function upload_image(Request $request, $commissionId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:10240', // 10MB max
            'stage' => 'nullable|string|in:sketch,sketch_revision,coloring,coloring_revision,final'
        ]);

        $commission = Commission::with('progressImages')->findOrFail($commissionId);

        // Determine the stage if not provided
        $stage = $request->stage;
        if (!$stage) {
            $stage = $this->determineNextStage($commission);
        }

        // Create directory if it doesn't exist
        $uploadPath = public_path('commissions/' . $commissionId);
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $stage . '_' . time() . '.' . $extension;

        // Move file to public/commissions/{id}/
        $request->file('image')->move($uploadPath, $filename);

        // Store relative path in database
        $imagePath = 'commissions/' . $commissionId . '/' . $filename;

        // Create commission progress record
        CommissionProgress::create([
            'commission_id' => $commissionId,
            'image_link' => $imagePath,
            'stage' => $stage,
            'revision_notes' => null, // Artist uploads don't have revision notes
        ]);

        // Update commission status to 'review'
        $commission->progress_status = 'review';
        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully. Status updated to review.',
            'image_path' => $imagePath,
            'stage' => $stage
        ]);
    }

    /**
     * Determine the next stage based on previous uploads and commission status
     * Progression: sketch → coloring → final
     * Revisions: sketch_revision, coloring_revision (based on current phase)
     */
    private function determineNextStage($commission)
    {
        // Get the latest uploaded image
        $latestProgress = $commission->progressImages()
            ->orderBy('created_at', 'desc')
            ->first();

        // If no previous uploads, start with sketch
        if (!$latestProgress) {
            return 'sketch';
        }

        $latestStage = $latestProgress->stage;
        $currentStatus = $commission->progress_status;

        // If commission is in revision status, determine which phase to revise
        if ($currentStatus === 'revision') {
            // Check the latest non-revision stage to determine revision type
            if (in_array($latestStage, ['sketch', 'sketch_revision'])) {
                return 'sketch_revision';
            } elseif (in_array($latestStage, ['coloring', 'coloring_revision'])) {
                return 'coloring_revision';
            }
        }

        // Normal progression based on latest stage
        switch ($latestStage) {
            case 'sketch':
            case 'sketch_revision':
                // After sketch is approved, move to coloring
                if ($currentStatus === 'in_progress_coloring') {
                    return 'coloring';
                }
                // Still in sketch phase
                return 'sketch';

            case 'coloring':
            case 'coloring_revision':
                // After coloring is approved, upload final
                if (in_array($currentStatus, ['completed', 'in_progress_coloring'])) {
                    return 'final';
                }
                return 'coloring';

            case 'final':
                // Already at final stage
                return 'final';

            default:
                return 'sketch';
        }
    }
}
