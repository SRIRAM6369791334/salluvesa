<?php

namespace App\Http\Controllers;

use App\Models\ProductOrder;
use App\Models\ProductSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class OrderAssetsController extends Controller
{
    /**
     * Download all assets for a specific order as a ZIP.
     */
    public function downloadZip($orderId)
    {
        // 1. Find the order and its design
        // Note: In 'web', ProductOrder usually has 'order_id' as the human-readable ID
        $order = DB::table('product_orders')->where('order_id', $orderId)->orWhere('id', $orderId)->first();
        
        if (!$order) {
            return abort(404, 'Order not found.');
        }

        // 2. Find all slots with design_id
        $slots = DB::table('product_slots')
            ->whereIn('order_id', [$order->id, (string)$order->order_id])
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

        if ($layers->isEmpty()) {
            return back()->with('error', 'No original assets (images/icons) found for these designs.');
        }

        // 4. Create ZIP
        $zip = new ZipArchive();
        $zipFileName = 'My_Design_Assets_' . ($order->order_id ?? $order->id) . '.zip';
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
                
                $fullPath = public_path($sourcePath);
                if (!file_exists($fullPath) || !is_file($fullPath)) {
                    $fullPath = public_path('uploads/' . $sourcePath);
                }
                
                // Fallback to absolute shared upload path if configured
                if ((!file_exists($fullPath) || !is_file($fullPath)) && config('filesystems.disks.shared.root')) {
                    $fullPath = rtrim(config('filesystems.disks.shared.root'), '/') . '/' . ltrim($sourcePath, '/');
                }

                if (file_exists($fullPath) && is_file($fullPath)) {
                    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                    $zipEntryName = $layerName . '_' . uniqid() . '.' . $extension;
                    $zip->addFile($fullPath, $zipEntryName);
                    $addedFiles[] = $zipEntryName;
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
        
        // Fallback to absolute shared upload path if configured
        if ((!file_exists($fullPath) || !is_file($fullPath)) && config('filesystems.disks.shared.root')) {
            $fullPath = rtrim(config('filesystems.disks.shared.root'), '/') . '/' . ltrim($path, '/');
        }

        if (file_exists($fullPath) && is_file($fullPath)) {
            return response()->download($fullPath);
        }

        return abort(404, 'File not found');
    }
}
