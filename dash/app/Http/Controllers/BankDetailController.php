<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    public function index()
    {
        $bankDetails = BankDetail::all();
        return view('pages.bank_details', compact('bankDetails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_country' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        BankDetail::create($request->all());

        return redirect()->back()->with('success', 'Bank details added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_country' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $bankDetail = BankDetail::findOrFail($id);
        $bankDetail->update($request->all());

        return redirect()->back()->with('success', 'Bank details updated successfully!');
    }

    public function destroy($id)
    {
        $bankDetail = BankDetail::findOrFail($id);
        $bankDetail->delete();

        return redirect()->back()->with('success', 'Bank details deleted successfully!');
    }
}
