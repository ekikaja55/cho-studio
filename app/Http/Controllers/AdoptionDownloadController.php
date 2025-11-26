<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AdoptionDownloadController extends Controller
{
    public function download($adoptionId)
    {
        // DEBUG: Uncommented the DD to verify access.
        // If you see this output, the routing is definitely working.
        // If you see the generic 404, stop and fix your URL.
        // dd("Controller reached for Adoption ID: " . $adoptionId); 

        // 1. Find the adoption record, ensuring the order is marked as 'delivered' OR 'completed'.
        $adoption = Adoption::where('adoption_id', $adoptionId)
                            ->where(function ($query) {
                                $query->where('order_status', 'delivered')
                                      ->orWhere('order_status', 'completed');
                            })
                            ->first();

        if (!$adoption) {
            // FAILURE POINT 1 (F1): Adoption ID is invalid or status is wrong.
            // If you see this, check your database status.
            dd('F1: Adoption not found or not delivered/completed.');
        }

        $deliveryFile = $adoption->delivery_file;
        $deliveryType = $adoption->delivery_type;

        // 2. Validate the file/link presence
        if (empty($deliveryFile)) {
            // FAILURE POINT 2 (F2): Record found, but delivery_file column is empty.
            // If you see this, check the database row for the file path.
            dd('F2: Delivery file path/link is missing in database.');
        }

        // 3. Handle external link redirection (matching your provided data)
        if ($deliveryType === 'link' || Str::startsWith($deliveryFile, ['http://', 'https://'])) {
            // Redirect the user immediately to the external link (e.g., Google Drive, Dropbox)
            return redirect()->away($deliveryFile);
        }

        // --- LOCAL FILE DELIVERY LOGIC ---
        // 4. Handle secure local file download
        $disk = 'adoptions';

        if(Storage::disk($disk)->exists($deliveryFile)) {
            return response()->download(public_path($deliveryFile));
        }

        // FAILURE POINT 3 (F3): File path exists in DB, but the file is not found on the disk.
        // If you see this, check your storage path (`storage/app/adoptions/{deliveryFile}`).
        dd('F3: File path found in DB, but file does not exist on disk.');
    }
}
