<?php

namespace Modules\Coupon\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupon\Models\Coupon;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function index()
    {
        $coupons = Coupon::all();
        return response()->json(['success' => true, 'data' => $coupons], 200);
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|unique:coupons,code',
            'discount' => 'required|numeric',
            'discount_type' => 'nullable|in:fixed,percentage',
            'expire_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
            'subscription_plan_ids' => 'nullable|array',
        ]);
        $coupon = Coupon::create($request->except('subscription_plan_ids'));
    
        if ($request->filled('subscription_plan_ids')) {
            $coupon->subscriptionPlans()->attach($request->subscription_plan_ids);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully.',
            'data' => $coupon->load('subscriptionPlans') // include plans in response
        ], 201);
    }

    /**
     * Display the specified coupon.
     */
    public function couponlist(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'plan_id' => 'nullable|integer|exists:plan,id',
            'coupon_code' => 'nullable|string',
            'per_page' => 'nullable|integer'
        ]);   
    
        $today = now()->toDateString();
    
        $coupons = Coupon::query()
            ->where('status', 1)
            ->whereDate('start_date', '<=', $today) 
            ->where(function($query) use ($today) {
                $query->whereDate('expire_date', '>=', $today) 
                      ->orWhereNull('expire_date');           
            })
            ->orderBy('start_date', 'asc'); 
        if ($request->filled('plan_id')) {
            $coupons->whereHas('subscriptionPlans', function ($query) use ($request) {
                $query->where('subscription_plan_id', $request->plan_id);
            });
        }
        
        if ($request->filled('coupon_code')) {
            $coupons->where('code', 'like', '%' . $request->coupon_code . '%');
        }

        $perPage = $request->get('per_page', 10);

        $result = $coupons->paginate($perPage);
        
        $result->getCollection()->transform(function ($coupon) {
            $coupon->discount = (float) $coupon->discount;
            return $coupon;
        });
        
        return response()->json([
            'success' => true,
            'data' => $result->items(),
            'pagination' => [
                'current_page' => $result->currentPage(),
                'per_page' => $result->perPage(),
                'total' => $result->total(),
                'last_page' => $result->lastPage(),
                'next_page_url' => $result->nextPageUrl(),
                'prev_page_url' => $result->previousPageUrl(),
            ],
        ]);
    }
    
    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|string|unique:coupons,code,' . $id,
            'discount' => 'sometimes|numeric|min:0',
            'expiry_date' => 'sometimes|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $coupon->update($request->only(['code', 'discount', 'expiry_date']));
        return response()->json(['success' => true, 'data' => $coupon], 200);
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon not found'], 404);
        }

        $coupon->delete();
        return response()->json(['success' => true, 'message' => 'Coupon deleted successfully'], 200);
    }

    /**
     * Display a filtered list of coupons based on plan_id or coupon_code.
     */
    
}