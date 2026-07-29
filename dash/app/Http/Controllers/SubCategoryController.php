<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Catch_;

class SubCategoryController extends Controller
{

    // VIEW

    public function index()
    {
        $subcate = SubCategory::with('category')->get();
        $cate = Category::all();
        return view('pages.subcategory', compact('subcate', 'cate'));
    }

    // ADD SUBCATEGORY

    public function store(Request $request)
    {
        $request->validate([
            'subcategory_name' => 'required',
            'category_name' => 'required',
        ]);

        $categoryId = $request->category_name;
        $subcategoryName = $request->subcategory_name;

        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid category selected.'
            ], 404);
        }

        // Store subcategory without checking for image
        SubCategory::create([
            'category_name' => $categoryId,
            'subcategory_name' => $subcategoryName,
            'category_display' => $category->category_name,
        ]);

        $subcategories = SubCategory::with('category')->get();

        return response()->json([
            'message' => 'Sub Category Added Successfully',
            'subcategories' => $subcategories
        ]);
    }


    // EDIT SUBCATEGORY

    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        // $request->validate([
        //     'edit_category_name' => 'required',
        //     'edit_subcategory_name' => 'required',
        //     // 'edit_subcategory_image' => 'required|mimes:png,jpg,webp,jpeg'
        // ]);

        $categoryname = $request->edit_category_name;
        $subcategoryname = $request->edit_subcategory_name;
        // dd( $categoryname );
        $subcatedisplay = Category::where('id', $categoryname)->first();
        $displayname = $subcatedisplay->category_name;
        if ($request->hasFile('edit_subcategory_image')) {
            $subcategoryImage = $request->file('edit_subcategory_image');
            $path =  $subcategoryImage->store('subcategory_images', 'public');
            File::delete(public_path('images/') . $subcategory->subcategory_image);
            $subcategory->update([
                'category_name' => $categoryname,
                // 'subcategory_image' =>  $path,
                'subcategory_name' => $subcategoryname,
                'category_display' => $displayname,
            ]);

            $subcategories = SubCategory::with('category')->get();

            return response()->json([
                'message' => 'Sub Category Added Successfully',
                'subcategories' => $subcategories
            ]);
        } else {
            $subcategory->update([
                'category_name' => $categoryname,
                'subcategory_name' => $subcategoryname,
                'category_display' => $displayname,
            ]);

            $subcategories =  SubCategory::with('category')->get();

            return response()->json([
                'message' => 'Sub Category Added Successfully',
                'subcategories' => $subcategories
            ]);
        }
    }

    public function destroy($id)
    {

        $subcategory = SubCategory::findOrFail($id);

        if (File::exists(public_path('images/') . $subcategory->subcategory_image)) {
            File::delete(public_path('images/') . $subcategory->subcategory_image);
            $subcategory->delete();

            $subcategories =  SubCategory::with('category')->get();

            return response()->json([
                'message' => 'Record Deleted Successfully',
                'subcategories' => $subcategories
            ]);
        }

        return redirect('subcategories')->with('error', 'Category Deleted Failed');
    }
}
