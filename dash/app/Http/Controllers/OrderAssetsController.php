<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\ProductSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class OrderAssetsController extends Controller
{
    /**
     * Download all assets for a specific order as a ZIP.
     */
    public function downloadZip($orderId)
    {
        // 1. Find the order and its design
        $order = ProductOrder::where('order_id', $orderId)->orWhere('id', $orderId)->firstOrFail();
        
        // 2. Find all slots with design_id
        $slots = ProductSlot::whereIn('order_id', [$order->id, (string)$order->order_id])
            ->whereNotNull('design_id')
            ->get();

        if ($slots->isEmpty()) {
            return back()->with('error', 'No custom designs found for this order.');
        }

        $designIds = $slots->pluck('design_id')->unique();
        
        // 3. Get design layers with source_path
        $layers = DB::table('design_layers')
            ->whereIn('design_id', $designIds)
            ->whereNotNull('source_path')
            ->get();

        $designs = DB::table('customproduct_designs')
            ->whereIn('id', $designIds)
            ->get();

        if ($layers->isEmpty() && $designs->isEmpty()) {
            return back()->with('error', 'No assets or designs found for this order.');
        }

        // 4. Create ZIP
        $zip = new ZipArchive();
        $zipFileName = 'Order_Assets_' . $order->order_id . '.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $addedFiles = [];
            
            foreach ($layers as $layer) {
                $sourcePath = $layer->source_path;
                $layerName = $layer->layer_name ?? 'Untitled';

                // Skip emojis - they are not files
                if (str_starts_with($sourcePath, 'emoji:')) {
                    continue;
                }
                
                // Construct absolute path
                // source_path is usually relative to the uploads folder
                $fullPath = public_path($sourcePath);
                if (!file_exists($fullPath) || !is_file($fullPath)) {
                    $fullPath = public_path('uploads/' . $sourcePath);
                }

                if (file_exists($fullPath) && is_file($fullPath)) {
                    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                    $zipEntryName = $layerName . '_' . uniqid() . '.' . $extension;
                    $zip->addFile($fullPath, $zipEntryName);
                    $addedFiles[] = $zipEntryName;
                }
            }

            // Add merged proofs
            $proofSides = ['preview_image_front', 'preview_image_back', 'preview_image_right_shoulder', 'preview_image_left_shoulder'];
            foreach ($designs as $design) {
                foreach ($proofSides as $side) {
                    if (!empty($design->{$side})) {
                        $proofPath = public_path('uploads/' . $design->{$side});
                        if (!file_exists($proofPath) || !is_file($proofPath)) {
                            $proofPath = public_path($design->{$side});
                        }
                        if (file_exists($proofPath) && is_file($proofPath)) {
                            $sideName = ucfirst(str_replace('preview_image_', '', $side));
                            $zipEntryName = 'Proof_' . $sideName . '_' . $design->id . '.png';
                            $zip->addFile($proofPath, $zipEntryName);
                            $addedFiles[] = $zipEntryName;
                        }
                    }
                }
            }

            $zip->close();

            if (empty($addedFiles)) {
                @unlink($zipPath);
                return back()->with('error', 'Could not locate physical files for these assets.');
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Could not create ZIP archive.');
    }

    /**
     * Download a single file. (Optional utility)
     */
    public function downloadFile(Request $request)
    {
        $path = $request->query('path');
        if (!$path) return abort(404);

        $fullPath = public_path($path);
        if (!file_exists($fullPath) || !is_file($fullPath)) {
            $fullPath = public_path('uploads/' . $path);
        }

        if (file_exists($fullPath) && is_file($fullPath)) {
            return response()->download($fullPath);
        }

        return abort(404, 'File not found');
    }
}
