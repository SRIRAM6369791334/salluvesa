<?php

namespace App\Http\Controllers;

use App\Models\BannerImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BannerImagesController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $bannerImages =  BannerImage::orderBy( 'id', 'asc' )->get();
        return view( 'pages.banner_images', compact( 'bannerImages' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $request->validate( [
            'banner_image' => 'required|mimes:png,jpg,webp,jpeg',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255'
        ] );

        if ( $request->hasFile( 'banner_image' ) ) {
            $bannerImage = $request->file( 'banner_image' );
            $path =  $bannerImage->store( 'banner_images', 'public' );
            BannerImage::create( [
                'banner_image' =>  $path,
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ] );

            $bannerImages =  BannerImage::orderBy( 'id', 'asc' )->get();
            return response()->json( [
                'message' => 'Banner Image Added Successfully',
                'bannerImages' => $bannerImages
            ] );
        }
        return redirect( 'bannerImages' )->with( 'error', 'No Image found' );
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {

        $banner = BannerImage::findOrFail( $id );

        $request->validate( [
            'banner_image' => $request->hasFile( 'banner_image' ) ? 'required|mimes:png,jpg,webp,jpeg' : '',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255'
        ] );
        if ( $request->hasFile( 'banner_image' ) ) {
            $bannerImage = $request->file( 'banner_image' );
            $path =  $bannerImage->store( 'banner_images', 'public' );
            File::delete( public_path( 'images/' ) . $banner->banner_image );
            $banner->update( [
                'banner_image' =>  $path,
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ] );

            $bannerImages =  BannerImage::orderBy( 'id', 'asc' )->get();

            return response()->json( [
                'message' => 'Banner Image Updated Successfully',
                'bannerImages' => $bannerImages
            ] );
        } else {
            $banner->update( [
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ] );

            $bannerImages =  BannerImage::orderBy( 'id', 'asc' )->get();

            return response()->json( [
                'message' => 'Banner Image Updated Successfully',
                'bannerImages' => $bannerImages
            ] );
        }
    }

    public function updateimage( Request $request, $id ) {

        $banner = BannerImage::findOrFail( $id );

        $request->validate( [
            'banner_image' => $request->hasFile( 'banner_image' ) ? 'required|mimes:png,jpg,webp,jpeg' : '',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255'
        ] );
        if ( $request->hasFile( 'banner_image' ) ) {
            $bannerImage = $request->file( 'banner_image' );
            $path =  $bannerImage->store( 'banner_images', 'public' );
            File::delete( public_path( 'images/' ) . $banner->banner_image );
            $banner->update( [
                'banner_image' =>  $path,
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ] );

            $webbannerImages = BannerImage::orderBy( 'id', 'asc' )->get();

            return response()->json( [
                'message' => 'Banner Image Added Successfully',
                'webbannerImages' => $webbannerImages
            ] );
        } else {
            $banner->update( [
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ] );

            $webbannerImages = BannerImage::orderBy( 'id', 'asc' )->get();
            return response()->json( [
                'message' => 'Banner Image Added Successfully',
                'webbannerImages' => $webbannerImages
            ] );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $banner = BannerImage::findOrFail( $id );

        if ( File::exists( public_path( 'images/' ) . $banner->banner_image ) ) {
            File::delete( public_path( 'images/' ) . $banner->banner_image );
            $banner->delete();

            $bannerImages =  BannerImage::orderBy( 'id', 'asc' )->get();

            return response()->json( [
                'message' => 'Banner Added Successfully',
                'bannerImages' => $bannerImages
            ] );
        }

        return redirect( 'bannerImages' )->with( 'error', 'Banner Image Deleted Failed' );
    }

    // web banner delete

    public function destroyweb( $id ) {
        $webbannerImages = BannerImage::findOrFail( $id );

        if ( File::exists( public_path( 'images/' ) . $webbannerImages->banner_image ) ) {
            File::delete( public_path( 'images/' ) . $webbannerImages->banner_image );
            $webbannerImages->delete();

            $webbannerImages = BannerImage::orderBy( 'id', 'asc' )->get();

            return response()->json( [
                'webbannerImages' => 'Banner Delete Successfully',
                'webbannerImages' => $webbannerImages
            ] );
        }

        return redirect( 'webbannerImages' )->with( 'error', 'Banner Image Deleted Failed' );
    }

    public function updateOrder( Request $request ) {
        $newOrder = $request->input( 'order' );
        foreach ( $newOrder as $position => $bannerId ) {
            BannerImage::where( 'id', $bannerId )->update( [ 'banner_position' => $position ] );
        }
        return response()->json( [ 'success' => true ] );
    }

    public function addbanner( Request $request ) {
        $request->validate( [
            'banner_image' => 'required|mimes:png,jpg,webp,jpeg',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255'
        ] );
        // dd($request);

        if ( $request->hasFile( 'banner_image' ) ) {
            $bannerImage = $request->file( 'banner_image' );
            $path =  $bannerImage->store( 'banner_images', 'public' );
            BannerImage::create( [
                'banner_image' =>  $path,
                'title' => $request->title,
                'subtitle' => $request->subtitle
            ] );

            $webbannerImages = BannerImage::orderBy( 'id', 'asc' )->get();

            return response()->json( [
                'message' => 'Banner Image Added Successfully',
                'webbannerImages' => $webbannerImages
            ] );
        }
        return redirect( 'webbannerImages' )->with( 'error', 'No Image found' );
    }
}
