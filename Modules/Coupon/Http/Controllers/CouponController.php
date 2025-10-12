<?php

namespace Modules\Coupon\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Trait\ModuleTrait;
use Modules\Coupon\Models\Coupon;
use Modules\Tax\Models\Tax;
use Illuminate\Support\Str;
use Modules\Subscriptions\Models\Plan;


class CouponController extends Controller
{
    protected string $exportClass = '\App\Exports\CouponExport';
    protected $module_title;
    protected $module_name;
    protected $module_path;
    protected $module_icon;
    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct()
    {
        $this->module_title = 'profile.title';
        $this->module_name = 'coupon';
        $this->module_path = 'users';
        $this->module_icon = 'fa-solid fa-users';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Display coupon listing page.
     */
    public function index(Request $request)
    {
            $module_action = __('List');
            $export_import = true;
            $filter = ['status' => null];

            $module_title = __('messages.coupon');
            $export_columns = [

            [
                'value' => 'code',
                'text' => __('messages.code'),
            ],
            [
                'value' => 'description',
                'text' => __('messages.description'),
            ],
            [
                'value' => 'start_date',
                'text' => __('messages.start_date'),
            ],
            [
                'value' => 'expire_date',
                'text' => __('messages.end_date'),
            ],
            [
                'value' => 'discount',
                'text' => __('messages.discount'),
            ],
            [
                'value' => 'subscription_type',
                'text' => __('messages.subscription_type'),
            ],
            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ],
            [
                'value' => 'created_at',
                'text' => __('messages.created_at'),
            ],
            [
                'value' => 'updated_at',
                'text' => __('messages.updated_at'),
            ]
        ];
        $export_url = route('backend.coupon.export');

        return view('coupon::backend.coupon.index', compact('module_action','filter','export_import','module_title', 'export_columns', 'export_url'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('coupon::backend.coupon.create', [
            'module_title' => __('messages.add_coupon'),
            'module_action' => __('Create'),
            'plans' => Plan::where('status', 1)->get()
        ]);
    }

    /**
     * Store a newly created coupon in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'start_date' => 'required|date',
            'expire_date' => 'required|date',
            'status' => 'nullable|boolean',
            'subscription_plan_ids' => 'required|array',
            'description' => 'required|string|max:500',
            'discount' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d+(\.\d{1,2})?$/', // Ensures up to two decimal places
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail(__('Discount value should be less than 100'));
                    }
                },
            ],[
                'code.size' => 'Coupon Code Length must be 6 Characters.',
            ]
        ]);


        // Create the coupon and associate subscription plans
        $coupon = Coupon::create($request->except('subscription_plan_ids'));

        if ($request->filled('subscription_plan_ids')) {
            $coupon->subscriptionPlans()->attach($request->subscription_plan_ids);
        }

        return redirect()->route('backend.coupon.index')->with('success', __('Coupon created successfully.'));
    }

    /**
     * Show the form for editing a coupon.
     */
    public function edit(Coupon $coupon)
    {
        return view('coupon::backend.coupon.create', [
            'coupon' => $coupon,
            'module_title' => __('Edit Coupon'),
            'module_action' => __('Update'),
            'plans' => Plan::where('status', 1)->get()
        ]);
    }

    /**
     * Update a coupon in the database.
     */
public function update(Request $request, Coupon $coupon)
{
    $request->validate([
        'code' => [
            'required',
            'unique:coupons,code,' . $coupon->id,
        ],
        'discount_type' => 'required|in:percentage,fixed',
        'start_date' => 'required|date',  // Changed validation rule
        'expire_date' => 'required|date', // Changed validation rule
        'status' => 'required|boolean',
        'subscription_plan_ids' => 'required|array',
        'description' => 'required|string|max:500',
        'discount' => [
            'required',
            'numeric',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->discount_type === 'percentage' && $value > 100) {
                    $fail(__('Discount value should be less than 100.'));
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
                    $fail(__('The discount must be a number with up to two decimal places.'));
                }
            },
        ],[
            'code.size' => 'Coupon Code Length must be 6 Characters.',
        ]
    ]);

    // Format dates before saving
    $request->merge([
        'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
        'expire_date' => Carbon::parse($request->expire_date)->format('Y-m-d'),
    ]);

    $coupon->update($request->except('subscription_plan_ids'));

    if ($request->has('subscription_plan_ids')) {
        $coupon->subscriptionPlans()->sync($request->subscription_plan_ids);
    }

    return redirect()->route('backend.coupon.index')->with('success', __('messages.coupon_updated_successfully'));
}


    /**
     * Delete a coupon from the database.
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->delete();

        return response()->json([
            'message' => __('Coupon deleted successfully.'),
            'status' => true
        ], 200);
    }


    public function force_delete($id)
    {
        $coupon = Coupon::withTrashed()->findOrFail($id);
        $coupon->forceDelete();

        return response()->json([
            'status' => true,
            'message' => __('messages.deleted_permanently')
        ]);
    }

    /**
     * Return data for DataTable.
     */
    public function index_data(DataTables $datatable, Request $request)
    {
        Coupon::where('status', 1)
            ->where('expire_date', '<', now()->toDateString())
            ->update(['status' => 0]);

        $query = Coupon::withTrashed()
            ->with('subscriptionPlans');

        $filter = $request->filter;

        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }
        return $datatable->eloquent($query)
        ->addColumn('check', function ($row) {
            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="coupon" onclick="dataTableRowCheck('.$row->id.', this)">';
        })
            ->addColumn('action', function ($data) {
                return view('coupon::backend.coupon.action_column', compact('data'));
            })
            ->addColumn('description', function ($data) {
                $short = Str::limit(strip_tags($data->description), 50);
                return '<span title="' . e($data->description) . '">' . e($short) . '</span>';
            })

            ->addColumn('subscription_type', function ($data) {
                return $data->subscriptionPlans->pluck('name')->join(', ');
            })
            ->addColumn('discount', function ($data) {
                if ($data->discount_type === 'percentage') {
                    return $data->discount . '%';
                } else {
                    return \Currency::format($data->discount ?? 0);
                }
            })
            ->filterColumn('subscription_plans.name', function($query, $keyword) {
                $query->whereHas('subscriptionPlans', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('start_date', function ($data) {
                try {
                    return $data->start_date ? Carbon::parse($data->start_date)->format('j-M-Y') : '-';
                } catch (\Exception $e) {
                    return '-';
                }
            })
            ->editColumn('expire_date', function ($data) {
                try {
                    return $data->expire_date ? Carbon::parse($data->expire_date)->format('j-M-Y') : '-';
                } catch (\Exception $e) {
                    return '-';
                }
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked="checked"' : ''; // Check if status is active
                // $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted

                return '
                    <div class="form-check form-switch">
                        <input type="checkbox" data-url="' . route('backend.coupon.update_status', $row->id) . '"
                            data-token="' . csrf_token() . '" class="switch-status-change form-check-input"
                            id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" ' . $checked . ' >
                    </div>
                ';
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })
            ->rawColumns(['check','status','action','description','start_date','expire_date'])
            ->make(true);
    }

    /**
     * Perform bulk actions on coupons.
     */
    public function bulk_action(Request $request)
{
    $ids = explode(',', $request->rowIds);
    $actionType = $request->action_type;
    $moduleName = 'coupon';

    if (empty($ids) || empty($actionType)) {
        return response()->json(['status' => false, 'message' => __('messages.invalid_request')], 400);
    }

    switch ($actionType) {
        case 'change-status':
            $status = $request->status;
            Coupon::whereIn('id', $ids)->update(['status' => $status]);
            return response()->json(['status' => true, 'message' => __('messages.status_updated')]);

        case 'delete':
            Coupon::whereIn('id', $ids)->delete();
            return response()->json(['status' => true, 'message' => __('messages.deleted_successfully')]);

        case 'restore':
            Coupon::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json(['status' => true, 'message' => __('messages.restored_successfully')]);

        case 'permanently-delete':
            Coupon::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json(['status' => true, 'message' => __('messages.permanent_delete_success')]);

        default:
            return response()->json(['status' => false, 'message' => __('messages.invalid_action')], 400);
    }
}

    public function couponsview(Request $request)
    {
        $coupon_id = $request->id ? $request->id : abort(404);
        $coupon = Coupon::find($coupon_id);



        $module_action = __('messages.list');

        return view('coupon::backend.coupon.coupon_datatable', compact('module_action',  'coupon_id', 'coupon'));
    }
    public function coupon_data(Request $request, $id)
    {
        $module_name = $this->module_name;

        $query = Coupon::with(['userRedeems', 'subscriptionPlans'])->where('id', $id);

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }

        return Datatables::of($query)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-' . $data->id . '" name="datatable_ids[]" value="' . $data->id . '" onclick="dataTableRowCheck(' . $data->id . ')">';
            })
            ->addColumn('action', function ($data) {
                return view('coupon::backend.coupon.action_column', compact('data'));
            })
            ->addColumn('description', function ($data) {
                return $data->description;
            })
            ->addColumn('start_date', function ($data) {
                return $data->start_date;
            })
            ->addColumn('expire_date', function ($data) {
                return $data->expire_date;
            })
            ->editColumn('subscription_type', function ($data) {
                return $data->subscriptionPlans->pluck('name')->join(', ') ?: '-';
            })
            ->editColumn('discount', function ($data) {
                if ($data->discount_type === 'fixed') {
                    return \Currency::format($data->discount ?? 0);
                }
                if ($data->discount_type === 'percentage') {
                    return $data->discount . '%';
                }
            })
            ->editColumn('status', function ($data) {
                return $data->status ? 'Active' : 'Inactive';
            })
            ->editColumn('is_expired', function ($data) {
                return $data->is_expired === 1 ? 'Yes' : 'No';
            })
            ->rawColumns(['action', 'status', 'check'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }


       public function calculate_discount(Request $request)
    {
        $selectedPlanId = $request->plan_id;
        $couponId = $request->coupon_id;

        $plan = Plan::find($selectedPlanId);
        $coupon = Coupon::with('subscriptionPlans')->find($couponId);

        if (!$plan || !$coupon || !$coupon->isValidForPlan($selectedPlanId)) {
            return response()->json(['error' => __('Invalid coupon or plan.')], 400);
        }

        $discountAmount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discountAmount = $plan->price * ($coupon->discount / 100);
        } elseif ($coupon->discount_type === 'fixed') {
            $discountAmount = $coupon->discount;
        }

        $discountedPrice = max(0, $plan->price - $discountAmount);

        $taxes = Tax::where(function ($query) use ($selectedPlanId) {
            $query->whereNotNull('plan_ids')
                  ->whereRaw('FIND_IN_SET(?, plan_ids)', [$selectedPlanId]);
        })->where('status', 1)->get();

        $totalTaxAmount = 0;
        $taxDetails = [];
        foreach ($taxes as $tax) {
            $taxAmount = $tax->type === 'Percentage'
                ? ($discountedPrice * $tax->value / 100)
                : $tax->value;

            $totalTaxAmount += $taxAmount;
            $taxDetails[] = [
                'title' => $tax->title,
                'type' => $tax->type,
                'value' => $tax->value,
                'amount' => $taxAmount,
            ];
        }

        $totalAmount = $discountedPrice + $totalTaxAmount;

        return response()->json([
            'price' => $plan->price,
            'discount_type' => $coupon->discount_type,
            'discount_amount' => $discountAmount,
            'subtotal' => $discountedPrice,
            'tax_array' => $taxDetails,
            'total_tax' => $totalTaxAmount,
            'total' => $totalAmount,
        ]);
    }
    public function getPlanCoupons(Request $request)
{
    $planId = $request->input('plan_id');

    // Fetch promotions or coupons for the selected plan
    $promotions = Coupon::where('status', 1)
        ->where('start_date', '<=', now())
        ->where('expire_date', '>=', now())
        ->whereHas('subscriptionPlans', function ($query) use ($planId) {
            $query->where('subscription_plan_id', $planId);
        })
        ->get();

    // Render the coupon list HTML
    $html = view('frontend::partials.coupons', compact('promotions'))->render();

    return response()->json([
        'success' => true,
        'html' => $html,
        'hasCoupons' => $promotions->isNotEmpty()
    ]);
}
public function getAvailablePromotions(Request $request)
{
    $planId = $request->input('plan_id');

    $promotions = Coupon::where('status', 1)
        ->where(function($query) use ($planId) {
            $query->whereNull('plan_id')
                  ->orWhere('plan_id', $planId);
        })
        ->where
        ('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get();

    return response()->json([
        'promotions' => $promotions
    ]);
}
public function update_status(Request $request, $id)
{
    $coupon = Coupon::findOrFail($id);
    $coupon->update(['status' => $request->status]);

    return response()->json(['status' => true, 'message' => __('messages.status_updated')]);
}

public function restore($id)
{


    $coupon = Coupon::withTrashed()->findOrFail($id);

    $coupon->restore();

    $message = __('messages.restore_form', ['form' => 'Coupon']);

    return response()->json(['message' => $message, 'status' => true], 200);

}

public function forceDelete($id)
{
    $coupon = Coupon::withTrashed()->findOrFail($id);
    $coupon->forceDelete();
    $message = __('messages.permanent_delete_form', ['form' => 'Coupon']);
    return response()->json(['message' => $message, 'status' => true], 200);
}





}
