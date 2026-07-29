<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    /**
     * Store a newly created address in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_username' => 'required|string|max:255',
            'address_line_one' => 'required|string|max:255',
            'address_line_two' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'address_phone_number' => 'required|regex:/^[0-9]{1,20}$/',
            'address_type_id' => 'required|integer|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();

        $address = UserAddress::create([
            'user_id' => $user->user_id,
            'address_username' => $request->address_username,
            'address_line_one' => $request->address_line_one,
            'address_line_two' => $request->address_line_two,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'country' => $request->country,
            'address_phone_number' => $request->address_phone_number,
            'address_type_id' => $request->address_type_id,
        ]);

        // If this is the user's first address, make it default
        if (!$user->user_default_address_id) {
            $user->user_default_address_id = $address->id;
            $user->save();
        }

        return response()->json(['success' => true, 'message' => 'Address added successfully!']);
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, $id)
    {
        $address = UserAddress::where('id', $id)->where('user_id', Auth::user()->user_id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'address_username' => 'required|string|max:255',
            'address_line_one' => 'required|string|max:255',
            'address_line_two' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'address_phone_number' => 'required|regex:/^[0-9]{1,20}$/',
            'address_type_id' => 'required|integer|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $address->update($request->all());

        return response()->json(['success' => true, 'message' => 'Address updated successfully!']);
    }

    /**
     * Set address as default.
     */
    public function setDefault($id)
    {
        $user = Auth::user();
        $address = UserAddress::where('id', $id)->where('user_id', $user->user_id)->firstOrFail();

        $user->user_default_address_id = $address->id;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Default address updated!']);
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $address = UserAddress::where('id', $id)->where('user_id', $user->user_id)->firstOrFail();

        // If deleting default address, clear it from user record
        if ($user->user_default_address_id == $address->id) {
            $user->user_default_address_id = null;
            $user->save();
        }

        $address->delete();

        return response()->json(['success' => true, 'message' => 'Address deleted successfully!']);
    }
}
