<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordOTP;
use App\Mail\RegistrationSuccess;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|regex:/^[0-9]{1,20}$/',
            'password' => 'required|string|min:8|confirmed',
            'address_line_one' => 'required|string|max:255',
            'address_line_two' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'user_type' => 'required|string|in:Normal User,B2B',
            'gst_number' => 'required_if:user_type,B2B|nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'user_id' => 'USR-' . strtoupper(Str::random(10)),
            'is_guest_user' => 0, // Login user
            'from_app' => 0, // Web registration
            'user_type' => $request->user_type,
            'gst_number' => $request->gst_number,
        ]);

        UserAddress::create([
            'user_id' => $user->user_id,
            'address_username' => $user->name,
            'address_line_one' => $request->address_line_one,
            'address_line_two' => $request->address_line_two,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address_phone_number' => $request->phone_number,
            'address_type_id' => 1, // Home by default
            'country' => $request->country,
        ]);

        Auth::login($user);

        // Send welcome email
        try {
            Mail::to($user->email)->send(new RegistrationSuccess($user));
        } catch (\Exception $e) {
            // Log the error but don't fail the registration
            \Log::warning('Failed to send registration email: ' . $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Registration successful! Welcome to Saaluvesa.', 'redirect' => route('myaccount')]);
        }

        return redirect()->route('myaccount')->with('success', 'Registration successful! Welcome to Saaluvesa.');
    }

    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Logged in successfully!', 'redirect' => route('myaccount')]);
            }

            return redirect()->intended('myaccount')->with('success', 'Logged in successfully!');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.'], 401);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }

    public function showForgotPassword()
    {
        return view('pages.forgot-password');
    }

    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'We could not find a user with that email address.'], 404);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expiry = now()->addMinutes(10);
        $user->save();

        // Send email notification with OTP
        try {
            Mail::to($user->email)->send(new ForgotPasswordOTP($user, $otp));
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            \Log::warning('Failed to send OTP email: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'A 6-digit OTP has been sent to your email!']);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 422);
        }

        if (now()->gt($user->otp_expiry)) {
            return response()->json(['success' => false, 'message' => 'OTP has expired.'], 422);
        }

        return response()->json(['success' => true, 'message' => 'OTP verified successfully!']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || now()->gt($user->otp_expiry)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired session.'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null; // Clear OTP after success
        $user->otp_expiry = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password reset successfully!']);
    }
}