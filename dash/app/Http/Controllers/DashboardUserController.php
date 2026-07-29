<?php

namespace App\Http\Controllers;

use App\Models\DashboardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardUserController extends Controller
{
    public function index()
    {
        $users = DashboardUser::all();
        return view('pages.dashboard_user', compact("users"));
    }

    public function userss(Request $request)
    {
        $validated = $request->validate([
            'name' => "required",
            'email' => "required",
            'phone_number' => "required",
            'role' => "required",
            'status' => "required",
            'password' => "required",
        ]);

        // Hash the password before inserting it into the database
        $validated['password'] = Hash::make($validated['password']);

        // Generate the employee_id
        $lastInsertId = DashboardUser::max('id');
        $maxValue = $lastInsertId ? $lastInsertId + 1 : 1;
        $invID = str_pad($maxValue, 5, '0', STR_PAD_LEFT);
        $stylecode = "HG-EMP-" . $invID;

        $validated['empl_num'] = $stylecode;



        // Create a new user record with the employee_id
        DashboardUser::create($validated);

        // Retrieve all users including the newly created one
        $users = DashboardUser::all();

        return response()->json([
            "message" => "User Added Successfully",
            "users" => $users
        ]);
    }


    public function update(Request $request, $id){

        $users = DashboardUser::findOrFail($id);
        $validated = $request->validate([
            'name' => "required",
            'email' => "required",
            'phone_number' => "required",
            'role' => "required",
            'status' => "required",


         ]);
         $users->update([
            'name' => $validated["name"],
            'email' => $validated["email"],
            'phone_number' => $validated["phone_number"],
            'role' => $validated["role"],
            'status' => $validated["status"],


        ]);
        $users =  DashboardUser::all();
        return response()->json([
            "message" => "User Added Successfully",
            "users" => $users
        ]);
    }


    public function destroy($id)
{
    // Use a SQL DELETE query to remove the coupon with the given ID
    $deletedRows = DashboardUser::where('id', $id)->delete();

    if ($deletedRows) {
        $users = DashboardUser::all();
        return response()->json([
            "message" => "User Deleted Successfully",
            "users" => $users
        ]);
    } else {
        return response()->json([
            "message" => "User Not Found or Could Not Be Deleted",
        ], 404); // You can use a different HTTP status code if needed
    }
}

public function update1(Request $request, $id){

    $users = DashboardUser::findOrFail($id);

    $validated = $request->validate([
        'password' => 'required',
    ]);

    $hashedPassword =  Hash::make($validated['password']);


    $users->update([
        'password' => $hashedPassword,
    ]);

    $users = DashboardUser::all();

    return response()->json([
        'message' => 'User Password Successfully Updated',
        'users' => $users,
    ]);
}



}
