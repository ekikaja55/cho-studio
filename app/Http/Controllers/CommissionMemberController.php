<?php

namespace App\Http\Controllers;

use App\Models\Commision;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommissionMemberController extends Controller
{
    public function index()
    {
        return view('member.commission_type');
    }

    public function form(Request $request)
    {
        $category = $request->query('type', null);
        return view('member.commission_form', compact('category'));
    }

public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'category' => 'required|string|in:headshot,bustup,halfbody,fullbody,cartoon_bustup,cartoon_halfbody,cartoon_fullbody',
        'background_type' => 'required|string|in:none,simple,detailed',
        'is_commercial_use' => 'required|boolean',
        'additional_characters' => 'required|integer|min:0',
        'description' => 'required|string|max:1000',
        'deadline' => 'required|date|after_or_equal:' . Carbon::now()->addWeeks(2)->format('Y-m-d'),
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $memberId = Auth::id();

    $commission = new Commission();

    // Simpan data dulu tanpa reference_image untuk mendapatkan commission_id
    $commission->member_id = $memberId;
    $commission->category = $validated['category'];
    $commission->background_type = $validated['background_type'];
    $commission->is_commercial_use = $validated['is_commercial_use'];
    $commission->additional_characters = $validated['additional_characters'];
    $commission->description = $validated['description'];
    $commission->deadline = $validated['deadline'];
    $commission->price = $validated['price'];
    $commission->payment_status = 'pending';
    $commission->progress_status = 'pending';
    $commission->save();

    // Upload file referensi jika ada, menggunakan commission_id yang sudah ada
    if ($request->hasFile('image')) {
        $uploadPath = public_path('commission_images');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $commission->commission_id . '.' . $extension;
        $request->file('image')->move($uploadPath, $filename);
        $imagePath = 'commission_images/' . $filename;

        // Update commission dengan reference_image
        $commission->reference_image = $imagePath;
        $commission->save();
    }

    return response()->json([
        'success' => true,
        'message' => 'Commission request submitted successfully.'
    ]);
}
}
