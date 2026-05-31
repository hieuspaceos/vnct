<?php
// app/Http/Controllers/Admin/BusinessController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Mail\BusinessApprovedMail;
use App\Mail\BusinessRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BusinessController extends Controller
{
    // Danh sách doanh nghiệp
    public function index(Request $request)
    {

        $status = $request->get('status', 'all');
        
        $query = Business::query();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        $title = "List Business";
        $businesses = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.page.businesses.index', compact('businesses', 'status','title'));
    }

    // Xem chi tiết doanh nghiệp
    public function show($id)
    {
        $title = "Chi tiết ";
        $business = Business::findOrFail($id);
        return view('admin.page.businesses.show', compact('business','title'));
    }

    // Duyệt doanh nghiệp
    public function approve($id)
    {
        $business = Business::findOrFail($id);
        $business->status = 'approved';
        $business->approved_at = now();
        $business->save();
        Mail::to($business->email)->send(new BusinessApprovedMail($business));
        return response()->json([
            'success' => true,
            'message' => 'Đã duyệt doanh nghiệp: ' . $business->company_name
        ]);
    }

    // Từ chối doanh nghiệp
     public function reject(Request $request, $id)
    {
        try {
            $business = Business::findOrFail($id);
            $reason = $request->input('reason', 'Không đáp ứng đủ điều kiện đăng ký'); // Lấy reason từ request
            
            $business->status = 'rejected';
            $business->save();
            
            // Gửi email thông báo từ chối
            Mail::to($business->email)->send(new BusinessRejectedMail($business, $reason));

            return response()->json([
                'success' => true,
                'message' => 'Đã từ chối doanh nghiệp: ' . $business->company_name
            ]);
            
        } catch (\Exception $e) {
            Log::error('Lỗi khi từ chối doanh nghiệp: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    // Xóa doanh nghiệp
    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa doanh nghiệp thành công'
        ]);
    }

    // Thống kê
    public function stats()
    {
        $stats = [
            'total' => Business::count(),
            'pending' => Business::where('status', 'pending')->count(),
            'approved' => Business::where('status', 'approved')->count(),
            'rejected' => Business::where('status', 'rejected')->count(),
            'recent' => Business::orderBy('created_at', 'desc')->limit(10)->get()
        ];

        return view('admin.page.businesses.stats', compact('stats'));
    }
}