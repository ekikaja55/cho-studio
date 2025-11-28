<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HistoryMemberController extends Controller
{
    public function index()
    {
        return view('member.history');
    }

    public function getHistory(Request $request)
    {
        $user = auth()->user();

        // 1. Extract Filters from Request
        $type = $request->input('type', 'all');
        $search = $request->input('search');
        $commissionStatus = $request->input('commission_status', 'all');
        $adoptionStatus = $request->input('adoption_status', 'all');

        $historyData = collect();

        // 2. Query Commissions (if 'all' or 'commission' is selected)
        if ($type === 'all' || strtolower($type) === 'commission') {
            $commissions = Commission::where('member_id', $user->member_id)
                ->when($search, function ($query, $term) {
                    return $query->where('description', 'like', '%' . $term . '%');
                })
                ->when(strtolower($commissionStatus) !== 'all', function ($query) use ($commissionStatus) {
                    return $query->where('progress_status', strtolower($commissionStatus));
                })
                ->get();

            $historyData = $historyData->merge($commissions->map(function ($commission) {
                return [
                    ...$commission->toArray(),
                    'type' => 'Commission',
                ];
            }));
        }

        // 3. Query Adoptions
        if ($type === 'all' || strtolower($type) === 'adoption') {
            $adoptions = Adoption::with('gallery')
                ->where('email', $user->email)
                // Apply search filter if present (search in gallery title)
                ->when($search, function ($query, $term) {
                    return $query->whereHas('gallery', function ($q) use ($term) {
                        $q->where('title', 'like', '%' . $term . '%');
                    });
                })
                ->when(strtolower($adoptionStatus) !== 'all', function ($query) use ($adoptionStatus) {
                    return $query->where('order_status', strtolower($adoptionStatus));
                })
                ->get();

            $historyData = $historyData->merge($adoptions->map(function ($adoption) {
                return [
                    ...$adoption->toArray(),
                    'type' => 'Adoption',
                ];
            }));
        }


        // 4. Sort and return
        $historyData = $historyData->sortByDesc('created_at')->values();

        return response()->json([
            'success' => true,
            'data' => $historyData,
        ]);
    }

    public function adoption_detail($id)
    {
        $user = auth()->user();

        // PERBAIKAN: Tambahkan pengecekan kepemilikan (berdasarkan email user)
        $adoption = Adoption::with("gallery")
            ->where('id', $id)
            ->where('email', $user->email) // Pastikan email cocok dengan user login
            ->first();

        if (!$adoption) {
            // Menggunakan 404 agar user iseng tidak tahu bahwa ID tersebut sebenarnya ada tapi milik orang lain
            abort(404, 'Data adopsi tidak ditemukan atau Anda tidak memiliki akses.');
        }

        return view('member.history_adoption_detail', ['adoption' => $adoption]);
    }

    public function commission_detail($id)
    {
        $user = auth()->user();

        // PERBAIKAN: Tambahkan pengecekan kepemilikan (berdasarkan member_id)
        // Menggunakan 'where' sebelum 'first' atau 'firstOrFail'
        $commission = Commission::with(['progressImages', 'member'])
            ->where('commission_id', $id) // Pastikan nama kolom primary key benar (id atau commission_id)
            ->where('member_id', $user->member_id) // KUNCI KEAMANAN: Hanya milik user login
            ->first();

        if (!$commission) {
            // Arahkan ke 404 jika data tidak ditemukan atau bukan milik user tersebut
            abort(404, 'Riwayat komisi tidak ditemukan atau Anda tidak berhak mengakses halaman ini.');
        }

        return view('member.history_commission_detail', ['commission' => $commission, 'member' => $commission->member]);
    }

    public function submit_review(Request $request, $commissionId)
    {
        $request->validate([
            'type' => 'required|string|in:accept,revision',
            'revision_notes' => 'nullable|string',
        ]);

        $notes = $request->input('revision_notes', '');

        // Log the review action
        Log::info("Review action '{$request->input('type')}' for Commission ID {$commissionId}: " . $notes);

        $commission = Commission::with('progressImages')->findOrFail($commissionId);

        $action = strtolower($request->input('type'));

        // Default new status
        $newStatus = $commission->progress_status;

        if ($action === 'revision') {
            // Customer requested revision
            $newStatus = 'revision';

            // update notes in commission progress table
            $latestProgress = $commission->progressImages()
                ->orderBy('created_at', 'desc')
                ->first();
            if ($latestProgress) {
                $latestProgress->revision_notes = $notes;
                $latestProgress->save();
            }
        } else {
            // Customer accepted the current stage — determine next status based on latest stage
            $latestProgress = $commission->progressImages()
                ->orderBy('created_at', 'desc')
                ->first();

            $latestStage = $latestProgress->stage ?? null;

            switch ($latestStage) {
                case 'sketch':
                case 'sketch_revision':
                    // Sketch accepted -> move to coloring phase
                    $newStatus = 'in_progress_coloring';
                    // mark started if not already
                    if (empty($commission->started_at)) {
                        $commission->started_at = now();
                    }
                    break;

                case 'coloring':
                case 'coloring_revision':
                case 'final':
                    // Coloring/final accepted -> mark completed
                    $newStatus = 'completed';
                    if (empty($commission->completed_at)) {
                        $commission->completed_at = now();
                    }
                    break;

                default:
                    // Fallback: mark as accepted
                    $newStatus = 'accepted';
                    break;
            }
        }

        $commission->progress_status = $newStatus;

        $commission->save();

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully.',
        ]);
    }

    function get_commission_progress($commissionId)
    {
        $commission = Commission::find($commissionId);
        if (!$commission) {
            return 0;
        }

        $status = $commission->progress_status;
        $latestProgress = $commission->progressImages()
            ->orderBy('created_at', 'desc')
            ->first();
        $stage = $latestProgress ? $latestProgress->stage : null;

        // dd($status, $stage);

        $statusMap = [
            "pending" => 0,
            "accepted" => 10,
            "in_progress_sketch" => 25,
            "review" => $stage === "sketch" ? 30 : ($stage === "coloring" ? 60 : 80),
            "in_progress_coloring" => 50,
            "revision" => $stage === "sketch_revision" ? 40 : ($stage === "coloring_revision" ? 70 : 90),
            "completed" => 100,
        ];

        return $statusMap[$status] ?? 0;
    }
}
