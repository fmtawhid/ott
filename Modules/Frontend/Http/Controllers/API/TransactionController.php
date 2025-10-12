<?php

namespace Modules\Frontend\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Frontend\Models\PayPerView;
use Modules\Frontend\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Get user's transaction history
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactionHistory(Request $request)
    {
        $payPerViews = PayPerView::where('user_id', $request->user_id)
            ->with(['movie', 'episode', 'video','PayperviewTransaction'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'status' => true,
            'data' => TransactionResource::collection($payPerViews),
            'pagination' => [
                'total' => $payPerViews->total(),
                'per_page' => $payPerViews->perPage(),
                'current_page' => $payPerViews->currentPage(),
                'last_page' => $payPerViews->lastPage(),
                'from' => $payPerViews->firstItem(),
                'to' => $payPerViews->lastItem()
            ]
        ]);
    }
} 