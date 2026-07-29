<?php

namespace App\Http\Controllers;

use App\Models\BulkOrder;
use App\Models\Design;
use App\Models\CustomproductDesign;
use App\Models\AppSetting;
use App\Mail\BulkOrderInquiryMail;
use App\Mail\BulkOrderUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class BulkOrderController extends Controller
{
    public function index()
    {
        $ownDesigns = Design::all();
        $userCustomDesigns = [];
        $appSettings = AppSetting::all();
        
        if (Auth::check()) {
            $userCustomDesigns = CustomproductDesign::where('user_id', Auth::user()->user_id)
                ->with('customproduct')
                ->get();
        }

        return view('pages.bulkorder', compact('ownDesigns', 'userCustomDesigns', 'appSettings'));
    }

    public function store(Request $request)
    {
        $utMap = [ 'Normal User' => 'Normal', 'B2B' => 'B2B' ];
        $ptMap = [ 'own_design' => 'Own Design', 'custom_design' => 'Bulk Custom', 'own_custom' => 'Own Custom' ];

        // Clean user type to avoid sneaky tab issues
        $userType = trim($request->user_type);
        $dbUT = $utMap[$userType] ?? $userType;
        $dbPT = $ptMap[$request->product_type] ?? $request->product_type;

        $setting = AppSetting::where('user_type', $dbUT)->where('product_type', $dbPT)->first();
        $min = $setting ? $setting->min_quantity : 1;
        $max = $setting ? $setting->max_quantity : 10000;

        $request->merge(['user_type' => $userType]); // Override request to pass validation

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'user_type' => 'required|string',
            'quantity' => "required|integer|min:$min|max:$max",
            'product_type' => 'required|string|in:own_design,custom_design,own_custom',
            'product_id' => 'required_if:product_type,own_design,custom_design|nullable',
            'custom_image' => 'required_if:product_type,own_custom|nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'notes' => 'nullable|string',
        ], [
            'quantity.min' => "The minimum quantity for your selection is $min units.",
            'quantity.max' => "The maximum quantity for your selection is $max units.",
        ]);

        $data = $request->only(['name', 'email', 'user_type', 'quantity', 'product_type', 'notes']);

        if ($request->product_type === 'own_custom' && $request->hasFile('custom_image')) {
            $file = $request->file('custom_image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '', $file->getClientOriginalName());
            
            // 1. Save locally (for email embedding)
            $path = $file->storeAs('bulk_orders', $filename, 'public');
            $data['custom_image'] = $path;

            // 2. Sync to Main Dashboard Project images folder
            try {
                // Use the configured UPLOAD_PATH from .env
                $targetDir = env('UPLOAD_PATH') . DIRECTORY_SEPARATOR . 'bulk_orders';
                
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                
                copy(public_path('storage/' . $path), $targetDir . DIRECTORY_SEPARATOR . $filename);
            } catch (\Exception $e) {
                \Log::warning('Sync to Main URL directory failed: ' . $e->getMessage());
            }
        } else {
            $data['product_id'] = $request->product_id;
        }

        $data['order_id'] = $this->generateBulkOrderId();
        $bulkOrder = BulkOrder::create($data);

        // Resolve Product Name for Email
        $productName = 'N/A';
        if ($bulkOrder->product_type === 'own_design' && $bulkOrder->product_id) {
            $design = \App\Models\Design::find($bulkOrder->product_id);
            $productName = $design ? $design->title : 'Unknown Catalog Item';
        } elseif ($bulkOrder->product_type === 'custom_design' && $bulkOrder->product_id) {
            $custom = \App\Models\CustomproductDesign::with('customproduct')->find($bulkOrder->product_id);
            $productName = ($custom && $custom->customproduct) ? $custom->customproduct->name : 'Unknown Custom Design';
            if($custom) $productName .= " (" . $custom->created_at->format('M d') . ")";
        } elseif ($bulkOrder->product_type === 'own_custom') {
            $productName = 'User Uploaded Art/Logo';
        }
        $bulkOrder->resolved_product_name = $productName;

        // Send Email Notifications
        $adminEmail = env('ADMIN_EMAIL', 'ss9819690@gmail.com');

        // 1. Send Detailed Notification to Admin (with image embedding/attachment)
        try {
            Mail::to($adminEmail)->send(new BulkOrderInquiryMail($bulkOrder, true));
        } catch (\Exception $e) {
            \Log::error('Bulk Order Admin Email Failed: ' . $e->getMessage());
        }
        
        // 2. Send Simple Receipt to User (New simpler mailable)
        try {
            Mail::to($request->email)->send(new BulkOrderUserMail($bulkOrder));
        } catch (\Exception $e) {
            \Log::error('Bulk Order User Receipt Failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk order inquiry submitted successfully! Our team will contact you soon.'
        ]);
    }

    private function generateBulkOrderId()
    {
        $prefix = 'ORD-SAA-BULK-';
        $latestOrder = BulkOrder::where('order_id', 'LIKE', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$latestOrder) {
            return $prefix . '001';
        }

        $latestOrderId = $latestOrder->order_id;
        $orderNumber = (int) str_replace($prefix, '', $latestOrderId);
        $newOrderNumber = $orderNumber + 1;

        return $prefix . str_pad($newOrderNumber, 3, '0', STR_PAD_LEFT);
    }
}