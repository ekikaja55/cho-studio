<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistCommissionController extends Controller
{
    public function index()
    {
        return view('artist.commissions');
    }

    public function getCommissions(Request $request)
    {
        $query = Commission::with('member');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($memberQuery) use ($search) {
                    $memberQuery->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('progress_status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Sort handling
        if ($request->has('sort') && !empty($request->sort)) {
            $sort = $request->sort;
            if ($sort === 'deadline_asc') {
                $query->orderBy('deadline', 'asc');
            } elseif ($sort === 'deadline_desc') {
                $query->orderBy('deadline', 'desc');
            } elseif ($sort === 'recent') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            // Default sort
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $commissions = $query->paginate($perPage);

        // Get status counts
        $statusCounts = [
            'pending' => Commission::where('progress_status', 'pending')->count(),
            'accepted' => Commission::where('progress_status', 'accepted')->count(),
            'in_progress' => Commission::whereIn('progress_status', ['in_progress_sketch', 'in_progress_coloring'])->count(),
            'revision' => Commission::where('progress_status', 'revision')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $commissions->items(),
            'pagination' => [
                'current_page' => $commissions->currentPage(),
                'last_page' => $commissions->lastPage(),
                'per_page' => $commissions->perPage(),
                'total' => $commissions->total(),
                'from' => $commissions->firstItem(),
                'to' => $commissions->lastItem(),
            ],
            'status_counts' => $statusCounts,
        ]);
    }
}
