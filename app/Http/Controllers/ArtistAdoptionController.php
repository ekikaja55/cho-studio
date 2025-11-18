<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use Illuminate\Http\Request;

class ArtistAdoptionController extends Controller
{
    public function index()
    {
        return view("artist.adoptions");
    }

    public function getAdoptions(Request $request)
    {
        $query = Adoption::with('gallery');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('buyer_name', 'like', "%{$search}%")
                    ->orWhere('buyer_email', 'like', "%{$search}%")
                    ->orWhereHas('gallery', function ($galleryQuery) use ($search) {
                        $galleryQuery->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by order status
        if ($request->has('order_status') && !empty($request->order_status)) {
            $query->where('order_status', $request->order_status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $adoptions = $query->paginate($perPage);

        // Get status counts
        $statusCounts = [
            'pending' => Adoption::where('order_status', 'pending')->count(),
            'confirmed' => Adoption::where('order_status', 'confirmed')->count(),
            'processing' => Adoption::where('order_status', 'processing')->count(),
            'delivered' => Adoption::where('order_status', 'delivered')->count(),
            'completed' => Adoption::where('order_status', 'completed')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $adoptions->items(),
            'pagination' => [
                'current_page' => $adoptions->currentPage(),
                'last_page' => $adoptions->lastPage(),
                'per_page' => $adoptions->perPage(),
                'total' => $adoptions->total(),
                'from' => $adoptions->firstItem(),
                'to' => $adoptions->lastItem(),
            ],
            'status_counts' => $statusCounts,
        ]);
    }

    
}

