<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DesignsController extends Controller {
    public function index() {
        $designs = Design::orderBy('id', 'asc')->get();
        return view('pages.designs', compact('designs'));
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|mimes:png,jpg,webp,jpeg',
            'title' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'size' => 'required|string',
            'cloth_types' => 'required|string'
        ]);

        $stocks = 999999;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('designs', 'public');
            Design::create([
                'image' => $path,
                'title' => $request->title,
                'tag' => $request->tag,
                'type' => $request->type,
                'price' => $request->price,
                'description' => $request->description,
                'stocks' => $stocks,
                'size' => $request->size,
                'cloth_types' => $request->cloth_types
            ]);

            $designs = Design::orderBy('id', 'asc')->get();
            return response()->json([
                'message' => 'Design Added Successfully',
                'designs' => $designs
            ]);
        }
        return response()->json(['error' => 'No Image found'], 400);
    }

    public function update(Request $request, $id) {
        $design = Design::findOrFail($id);

        $request->validate([
            'image' => $request->hasFile('image') ? 'required|mimes:png,jpg,webp,jpeg' : '',
            'title' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'size' => 'required|string',
            'cloth_types' => 'required|string'
        ]);

        $stocks = 999999;

        $data = [
            'title' => $request->title,
            'tag' => $request->tag,
            'type' => $request->type,
            'price' => $request->price,
            'description' => $request->description,
            'stocks' => $stocks,
            'size' => $request->size,
            'cloth_types' => $request->cloth_types
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('designs', 'public');
            
            // Delete old image
            if (File::exists(public_path('images/') . $design->image)) {
                File::delete(public_path('images/') . $design->image);
            }
            
            $data['image'] = $path;
        }

        $design->update($data);
        $designs = Design::orderBy('id', 'asc')->get();

        return response()->json([
            'message' => 'Design Updated Successfully',
            'designs' => $designs
        ]);
    }

    public function destroy($id) {
        $design = Design::findOrFail($id);

        if (File::exists(public_path('images/') . $design->image)) {
            File::delete(public_path('images/') . $design->image);
        }
        
        $design->delete();
        $designs = Design::orderBy('id', 'asc')->get();

        return response()->json([
            'message' => 'Design Deleted Successfully',
            'designs' => $designs
        ]);
    }
}
