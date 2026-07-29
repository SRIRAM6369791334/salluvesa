<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load(['addresses', 'cartItems', 'designs' => function($query) {
            $query->whereIn('status', ['draft', 'confirmed'])->latest();
        }, 'orders' => function($query) {
            $query->latest();
        }]);
        $allBankDetails = \App\Models\BankDetails::all();
        $bulkOrders = \App\Models\BulkOrder::where('email', $user->email)->latest()->get();
        return view('pages.myaccount', compact('user', 'allBankDetails', 'bulkOrders'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^[0-9]{1,20}$/',
            'gender' => 'nullable|integer|in:1,2,3', // 1:Male, 2:Female, 3:Other
        ]);

        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
        ]);

        return response()->json(['success' => true, 'message' => 'Profile updated successfully!']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Current password does not match.'], 422);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => true, 'message' => 'Password changed successfully!']);
    }
}
