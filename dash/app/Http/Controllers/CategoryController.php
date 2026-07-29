<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =  Category::all();
        return view("pages.categories", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "category_name" => "required",
            "category_image" => "required|mimes:png,jpg,webp,jpeg"
        ]);

        if ($request->hasFile("category_image")) {
            $categoryImage = $request->file("category_image");
            $path =  $categoryImage->store("category_images", "public");
            Category::create([
                "category_name" => $request->category_name,
                "category_image" =>  $path,
            ]);

            $categories =  Category::all();

            return response()->json([
                "message" => "Category Added Successfully",
                "categories" => $categories
            ]);
        }else{
            Category::create([
                "category_name" => $request->category_name,
            ]);
            $categories =  Category::all();

            return response()->json([
                "message" => "Category Added Successfully",
                "categories" => $categories
            ]);
        }



        return redirect("categories")->with("error", "No Image found");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)

    {

        $category = Category::findOrFail($id);

        $request->validate([
            "category_name" => "required",
            "category_image" => $request->hasFile("category_image") ? "required|mimes:png,jpg,webp,jpeg" : ""
        ]);

        if ($request->hasFile("category_image")) {
            $categoryImage = $request->file("category_image");
            $path =  $categoryImage->store("category_images", "public");
            File::delete(public_path("images/") . $category->category_image);
            $category->update([
                "category_name" => $request->category_name,
                "category_image" =>  $path,
            ]);

            $categories =  Category::all();

            return response()->json([
                "message" => "Category Added Successfully",
                "categories" => $categories
            ]);
        } else {
            $category->update([
                "category_name" => $request->category_name,
            ]);

            $categories =  Category::all();

            return response()->json([
                "message" => "Category Added Successfully",
                "categories" => $categories
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $category = Category::findOrFail($id);

        if (File::exists(public_path("images/") . $category->category_image)) {
            File::delete(public_path("images/") . $category->category_image);
            $product = DB::table( 'products' )->where( 'category_id', $category->id )->delete();
            $subcate = DB::table( 'sub_categories' )->where( 'category_name', $category->id )->delete();
            $category->delete();

            $categories =  Category::all();

            return response()->json([
                "message" => "Category Added Successfully",
                "categories" => $categories
            ]);
        }

        return redirect("categories")->with("error", "Category Deleted Failed");
    }

    public function  validateCategoryName(Request $request)
    {


        $request->validate([
            "category_name" => "required|unique:categories"
        ]);

        return response("success");
    }
}