<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SamplesController extends Controller
{
    public function index()
    {
        $samples = Sample::orderBy('sort_order', 'asc')->get();
        return view('pages.samples', compact('samples'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:png,jpg,webp,jpeg',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'badge' => 'required|string|max:255',
            'badge_type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sizes' => 'required|string', // Expecting comma-separated or JSON string
            'features' => 'required|string', // Expecting comma-separated or JSON string
            'is_active' => 'required|integer',
            'sort_order' => 'required|integer',
            'cloth_types' => 'required|string',
            'gsm' => 'required|string',
            'colors' => 'required',
        ]);

        $data = $request->all();
        $data['stocks'] = 999999;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/samples'), $imageName);
            $data['image'] = 'samples/' . $imageName;
        }

        // Handle JSON fields if they come as strings
        $data['sizes'] = explode(',', $request->sizes);
        $data['features'] = explode(',', $request->features);
        $data['gsm'] = explode(',', $request->gsm);
        $data['colors'] = is_array($request->colors) ? $request->colors : explode(',', $request->colors);

        Sample::create($data);

        $samples = Sample::orderBy('sort_order', 'asc')->get();
        return response()->json([
            'message' => 'Sample Created Successfully',
            'samples' => $samples
        ]);
    }

    public function update(Request $request, $id)
    {
        $sample = Sample::findOrFail($id);

        $request->validate([
            'image' => $request->hasFile('image') ? 'required|mimes:png,jpg,webp,jpeg' : '',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'badge' => 'required|string|max:255',
            'badge_type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sizes' => 'required|string',
            'features' => 'required|string',
            'is_active' => 'required|integer',
            'sort_order' => 'required|integer',
            'cloth_types' => 'required|string',
            'gsm' => 'required|string',
            'colors' => 'required',
        ]);

        $data = $request->all();
        $data['stocks'] = 999999;

        if ($request->hasFile('image')) {
            if (File::exists(public_path($sample->image))) {
                File::delete(public_path($sample->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/samples'), $imageName);
            $data['image'] = 'samples/' . $imageName;
        }

        $data['sizes'] = explode(',', $request->sizes);
        $data['features'] = explode(',', $request->features);
        $data['gsm'] = explode(',', $request->gsm);
        $data['colors'] = is_array($request->colors) ? $request->colors : explode(',', $request->colors);

        $sample->update($data);

        $samples = Sample::orderBy('sort_order', 'asc')->get();
        return response()->json([
            'message' => 'Sample Updated Successfully',
            'samples' => $samples
        ]);
    }

    public function destroy($id)
    {
        $sample = Sample::findOrFail($id);

        if (File::exists(public_path($sample->image))) {
            File::delete(public_path($sample->image));
        }

        $sample->delete();

        $samples = Sample::orderBy('sort_order', 'asc')->get();
        return response()->json([
            'message' => 'Sample Deleted Successfully',
            'samples' => $samples
        ]);
    }
}
