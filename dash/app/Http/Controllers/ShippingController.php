<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function getship()
    {
        $shipping = Shipping::all();
        return view('pages.shippings', compact('shipping'));
    }
    public function addshipping(Request $request)
    {

        $shipping = new Shipping();
        $shipping->location = $request->input('location');
        $shipping->shipping_amt = $request->input('shipping_amt');
        $shipping->save();
        return redirect()->back()->with('success', 'Shipping Amount Added Successfully');
    }
    public function updateship(Request $request)
    {
        $id = $request->input('id');
        $shipping =  Shipping::find($id);
        $shipping->location = $request->input('location');
        $shipping->shipping_amt = $request->input('shipping_amt');
        $shipping->update();
        return redirect()->back()->with('success', 'Shipping Amount Updated Successfully');
    }
    public function destroyshipping($id)
    {

        $shipping =  Shipping::find($id);
        if ($shipping) {
            $shipping->delete();
        }
        return redirect()->back()->with('success', 'Shipping Amount Deleted Successfully');
    }
}
