<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginPageController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function processLogin(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Percobaan otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            $user = Auth::user(); // Get the authenticated user

            // Tentukan URL redirect berdasarkan peran
            $redirectUrl = ($user->role === 'artist')
                ? route('artist.commissions')
                : route('member.history');

            // Respons sukses untuk AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $redirectUrl,
                    'message' => 'Login successful!'
                ]);
            }

            // Fallback untuk redirect standar
            return redirect()->to($redirectUrl)->with('success', 'Login successful!');
        }

        // 3. Otentikasi gagal
        $errorMessage = 'The current credentials do not match our records.';

        // Respons gagal untuk AJAX (Status 422 Unprocessable Entity)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        }

        // Fallback untuk redirect kembali dengan error standar
        return back()->withErrors([
            'username' => $errorMessage,
        ])->withInput();
    }

    public function register()
    {
        return view('register');
    }

    public function processRegister(Request $request)
    {
        // 1. Validation based on your registration form fields
        // Username must not contain spaces (use ^\S+$ regex)
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:members,username', 'regex:/^\S+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' checks against password_confirmation
            'line_id' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'instagram' => ['nullable', 'string', 'max:255'],
        ], [
            'username.regex' => 'Username must not contain spaces.',
        ]);

        // 2. Custom validation: Ensure at least one contact method is provided
        $hasContact = !empty($validatedData['line_id']) || 
                      !empty($validatedData['phone_number']) || 
                      !empty($validatedData['instagram']);

        if (!$hasContact) {
            $errorMessage = 'Please provide at least one contact method (Line ID, Phone Number, or Instagram).';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 422);
            }

            return back()->withErrors([
                'contact' => $errorMessage
            ])->withInput();
        }

        try {
            // 3. Create the new member using the model method (default role is 'client')
            $member = Member::createNewMember($validatedData);

            // 4. Automatically log the new user in
            Auth::login($member);

            // 5. Return success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('member.history'),
                    'message' => 'Registration successful! Welcome aboard.'
                ]);
            }

            return redirect()->route('member.history')->with('success', 'Registration successful! Welcome aboard.');

        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());

            $errorMessage = 'Registration failed. Please try again.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->withErrors([
                'error' => $errorMessage
            ])->withInput();
        }
    }

    public function termsnconditions()
    {
        return view('terms_conditions');
    }
}
