<?php

namespace Modules\Subscriptions\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
// use Illuminate\Routing\Controller;
use Modules\Subscriptions\Models\Subscription;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Currency;
use App\Trait\ModuleTrait;
use Modules\Subscriptions\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Subscriptions\Services\SubscriptionService;
use Modules\Subscriptions\Http\Requests\SubscriptionRequest;
use Illuminate\Support\Facades\Cache;
use Modules\Tax\Models\Tax;
use Modules\Frontend\Models\PayPerView;

class SubscriptionController extends Controller
{
    protected string $exportClass = '\App\Exports\SubscriptionExport';
    protected $subscriptionService;
    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }
    public function __construct(SubscriptionService $subscriptionService,Request $request)
    {
        $routeName = $request->route()->getName();

        if ($routeName == 'backend.pay-per-view-export' || $routeName == 'backend.pay-per-view-history') {
            $this->exportClass = '\App\Exports\PayPerViewExport';
            $this->module_name = 'renthistory';
        }else{
            $this->exportClass = '\App\Exports\SubscriptionExport';
            $this->module_name = 'subscriptions';
        }
        // dd($routeName);
        $this->subscriptionService = $subscriptionService;
        // Page Title
        $this->module_title = 'Subscriptions';

        // module name
        // $this->module_name = 'subscriptions';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $module_action = 'User List';
        $export_import = true;


        $export_columns = [

            [
                'value' => 'user_details',
                'text' => __('messages.user'),
            ],
            [
                'value' => 'name',
                'text' => __('messages.name'),
            ],
            [
                'value' => 'duration',
                'text' => __('dashboard.duration'),
            ],
             [
                'value' => 'payment_method',
                'text' => __('messages.payment_method'),
            ],
            [
                'value' => 'start_date',
                'text' => __('messages.start_date'),
            ],
            [
                'value' => 'end_date',
                'text' => __('messages.end_date'),
            ],
            [
                'value' => 'amount',
                'text' => __('dashboard.amount'),
            ],
            [
                'value' => 'coupon_discount',
                'text' => __('messages.coupon_discount'),
            ],
            [
                'value' => 'tax_amount',
                'text' => __('tax.title') . ' ' . __('dashboard.amount'),
            ],
            [
                'value' => 'total_amount',
                'text' => __('messages.total_amount'),
            ],
            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ],
        ];
        $export_url = route('backend.subscriptions.export');
        $filter = [
            'status' => $request->status,
        ];
        $plans= Plan::all();
        return view('subscriptions::backend.subscriptions.index', compact('module_action','export_import', 'export_columns', 'export_url','filter','plans'));
    }


     public function pay_per_view_data(Request $request)
    {
        $module_action = 'Pay Per View List';
        $module_title = __('messages.lbl_rent_history');
        $module_name = 'pay-per-view';
        $export_import = true;
        $export_columns = [

            [
                'value' => 'user_details',
                'text' => __('messages.user'),
            ],
            [
                'value' => 'content',
                'text' => __('messages.lbl_content'),
            ],
            [
                'value' => 'duration',
                'text' => __('dashboard.duration'),
            ],
             [
                'value' => 'payment_method',
                'text' => __('messages.payment_method'),
            ],
            [
                'value' => 'start_date',
                'text' => __('messages.start_date'),
            ],
            [
                'value' => 'end_date',
                'text' => __('messages.end_date'),
            ],
            [
                'value' => 'amount',
                'text' => __('dashboard.amount'),
            ],
            [
                'value' => 'discount',
                'text' => __('frontend.discount'),
            ],

            [
                'value' => 'total_amount',
                'text' => __('messages.total_amount'),
            ],
            // [
            //     'value' => 'status',
            //     'text' => __('plan.lbl_status'),
            // ],
        ];
        $export_url = route('backend.pay-per-view-export');
        $filter = [
            'status' => $request->status,
        ];
        $plans= Plan::all();
        return view('subscriptions::backend.subscriptions.pay-per-view-data', compact('module_title','module_action','export_import', 'export_columns', 'export_url','filter','plans'));
    }

     public function RentData(Datatables $datatable,Request $request)
    {
        $query = PayPerView::query()->with(['user','movie','episode','video','PayperviewTransaction']);


            if ($request->filled('date_range') &&  $request->date_range !=null ) {
                $dates = explode(' to ', $request->date_range); // Ensure correct delimiter
                $startDate = Carbon::createFromFormat('Y-m-d', trim($dates[0]))->startOfDay();
                $endDate = isset($dates[1])
                ? Carbon::createFromFormat('Y-m-d', trim($dates[1]))->endOfDay()
                : $startDate->copy()->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="subscriptions" onclick="dataTableRowCheck('.$row->id.', this)">';
            })

            ->editColumn('user_id', function ($data) {
             return view('components.user-detail-card', ['image' => setBaseUrlWithFileName(optional($data->user)->file_url) ?? default_user_avatar() , 'name' => optional($data->user)->full_name ?? default_user_name(),'email' => optional($data->user)->email ?? '-'])->render();
                // return view('subscriptions::backend.subscriptions.user_details', compact('data'));
            })
           ->editColumn('start_date', function ($data) {

                    $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at);
                    return formatDate($start_date->format('Y-m-d'));

            })
            ->editColumn('end_date', function ($data) {
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->view_expiry_date);
                return formatDate($end_date->format('Y-m-d'));
            })
            ->editColumn('amount', function ($data) {
                return Currency::format($data->content_price);
            })
            ->editColumn('coupon_discount', function ($data) {
                return ($data->discount_percentage ?? 0) . '%';
            })

            ->filterColumn('coupon_discount', function ($query, $keyword) {
                $query->whereRaw("CONCAT(discount_percentage, '%') LIKE ?", ["%{$keyword}%"]);
            })

            ->orderColumn('coupon_discount', function ($query, $orderDirection) {
                $query->orderBy('discount_percentage', $orderDirection);
            })

            ->editColumn('total_amount', function ($data) {
                return Currency::format(optional($data->PayperviewTransaction)->amount);
            })

           ->orderColumn('total_amount', function ($query, $orderDirection) {
                $query->leftJoin('payperviewstransactions', 'pay_per_views.id', '=', 'payperviewstransactions.pay_per_view_id')
                      ->orderBy('payperviewstransactions.amount', $orderDirection)
                      ->select('pay_per_views.*');
            })
            ->addColumn('name', function ($data) {

                if($data->type=='video'){

                     return optional($data->video)->name ?? '-';

                }elseif($data->type=='episode'){

                    return optional($data->episode)->name ?? '-';

                }elseif($data->type=='movie'){

                  return optional($data->movie)->name ?? '-';

                }else{

                     return '-';
                }


            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where(function ($q) use ($keyword) {
                        $q->where('type', 'video')
                          ->whereHas('video', function ($q) use ($keyword) {
                              $q->where('name', 'like', "%{$keyword}%");
                          });
                    })->orWhere(function ($q) use ($keyword) {
                        $q->where('type', 'episode')
                          ->whereHas('episode', function ($q) use ($keyword) {
                              $q->where('name', 'like', "%{$keyword}%");
                          });
                    })->orWhere(function ($q) use ($keyword) {
                        $q->where('type', 'movie')
                          ->whereHas('movie', function ($q) use ($keyword) {
                              $q->where('name', 'like', "%{$keyword}%");
                          });
                    });
                });
            })

            ->orderColumn('name', function($query, $order) {
                $query->orderByRaw("
                    COALESCE(
                        (SELECT name FROM videos WHERE videos.id = pay_per_views.movie_id AND pay_per_views.type = 'video'),
                        (SELECT name FROM episodes WHERE episodes.id = pay_per_views.movie_id AND pay_per_views.type = 'episode'),
                        (SELECT name FROM entertainments WHERE entertainments.id = pay_per_views.movie_id AND pay_per_views.type = 'movie'),
                        ''
                    ) {$order}
                ");
            })
            ->filterColumn('status', function($query, $keyword) {
                if ($keyword == 'inactive') {
                    $query->where('status', 'inactive');
                } else if ($keyword == 'active') {
                    $query->where('status', 'active');
                }
            })
            ->filterColumn('user_id', function($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('user', function($q) use ($keyword) {

                        $q->where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')->orWhere('email', 'like', '%' . $keyword . '%');

                    });
                }
            })
            ->filterColumn('start_date', function($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at, '%D %M %Y') like ?", ["%$keyword%"]);
            })
            ->filterColumn('end_date', function($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(view_expiry_date, '%D %M %Y') like ?", ["%$keyword%"]);
            })

            ->orderColumn('start_date', function ($query, $order) {
                 $query->orderBy('created_at', $order);
            })

            ->orderColumn('end_date', function ($query, $order) {
                   $query->orderBy('view_expiry_date', $order);
            })

            ->filterColumn('amount', function ($query, $keyword) {
                // Clean keyword to allow only numbers and dot (decimal)
                $cleanedKeyword = preg_replace('/[^0-9.]/', '', $keyword);


                // Check if the cleaned keyword is not empty

                // Check if the cleaned keyword is not empty
                if ($cleanedKeyword !== '') {
                    $query->where('content_price', 'like', "%{$cleanedKeyword}%");
                }
            })

            ->orderColumn('amount', function ($query, $orderDirection) {
                $query->orderBy('content_price', $orderDirection);
            })

            ->filterColumn('total_amount', function($query, $keyword) {
                $cleanedKeyword = preg_replace('/[^0-9.]/', '', $keyword);

                if ($cleanedKeyword !== '') {
                    $query->whereHas('PayperviewTransaction', function ($q) use ($cleanedKeyword) {
                        $q->whereRaw("CAST(amount AS CHAR) LIKE ?", ["%{$cleanedKeyword}%"]);
                    });
                }
            })


            ->addColumn('duration', function ($data) {
                return $data->available_for. ' Days' ?? '-' ;
            })

            ->filterColumn('duration', function($query, $keyword) {
                // Strip " Days" if users type it
                $numericKeyword = preg_replace('/[^0-9]/', '', $keyword);

                if (is_numeric($numericKeyword)) {
                    $query->where('available_for', '=', $numericKeyword);
                } else {
                    // Optional: return no match if not numeric
                    $query->whereRaw('1 = 0');
                }
            })

            ->orderColumn('duration', function($query, $order) {
                $query->orderBy('available_for', $order);
            })


            ->addColumn('payment_method', function ($data) {
                return $data->PayperviewTransaction->payment_type ?? '-';
            })
            ->filterColumn('payment_method', function ($query, $keyword) {
                $query->whereHas('PayperviewTransaction', function ($query) use ($keyword) {
                    $query->where('payment_type', 'like', "%$keyword%");
                });
            })

            ->addColumn('action', function ($data) {
                // return view('subscriptions::backend.subscriptions.action', compact('data'));
            })
            ->orderColumns(['id'], '-:column $1');

        return $datatable->rawColumns(array_merge(['action','check','coupon_discount','user_id', 'start_date', 'end_date', 'amount', 'name','duration']))
            ->toJson();
    }



    public function index_data(Datatables $datatable,Request $request)
    {
        // dd('hello');
        $query = Subscription::query()->with(['user','plan','subscription_transaction'])->orderBy('created_at', 'desc');


            if ($request->filled('plan_id') && $request->plan_id !=null ) {
                $query->where('plan_id', $request->plan_id);
            }
            if ($request->filled('date_range') && $request->date_range != null) {
                $dates = explode(' to ', $request->date_range);
                $startDate = Carbon::createFromFormat('Y-m-d', trim($dates[0]))->startOfDay();
                $endDate = isset($dates[1]) ? Carbon::createFromFormat('Y-m-d', trim($dates[1]))->endOfDay() : $startDate->copy()->endOfDay();
                $query->whereBetween('start_date', [$startDate, $endDate]);
            }
        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="subscriptions" onclick="dataTableRowCheck('.$row->id.', this)">';
            })

            ->editColumn('user_id', function ($data) {
             return view('components.user-detail-card', ['image' => setBaseUrlWithFileName(optional($data->user)->file_url) ?? default_user_avatar() , 'name' => optional($data->user)->full_name ?? default_user_name(),'email' => optional($data->user)->email ?? '-'])->render();
                // return view('subscriptions::backend.subscriptions.user_details', compact('data'));
            })
           ->editColumn('start_date', function ($data) {
                    $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->start_date);
                    return formatDate($start_date->format('Y-m-d'));
            })
            ->editColumn('end_date', function ($data) {
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $data->end_date);
                return formatDate($end_date->format('Y-m-d'));
            })
            ->editColumn('amount', function ($data) {
                return Currency::format($data->amount);
            })
            ->editColumn('coupon_discount', function ($data) {
                return Currency::format($data->coupon_discount ?? 0);
            })
            ->editColumn('tax_amount', function ($data) {
                return Currency::format($data->tax_amount);
            })
            ->editColumn('total_amount', function ($data) {
                return Currency::format($data->total_amount);
            })
            ->addColumn('name', function ($data) {
                return optional($data->plan)->name ?? '-';
            })
            ->filterColumn('status', function($query, $keyword) {
                if ($keyword == 'inactive') {
                    $query->where('status', 'inactive');
                } else if ($keyword == 'active') {
                    $query->where('status', 'active');
                }
            })
            ->filterColumn('user_id', function($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('user', function($q) use ($keyword) {

                        $q->where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')->orWhere('email', 'like', '%' . $keyword . '%');

                    });
                }
            })
            ->filterColumn('start_date', function($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(start_date, '%D %M %Y') like ?", ["%$keyword%"]);
            })
            ->filterColumn('end_date', function($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(end_date, '%D %M %Y') like ?", ["%$keyword%"]);
            })
            ->filterColumn('amount', function($query, $keyword) {
                // Remove any non-numeric characters except for the decimal point
                $cleanedKeyword = preg_replace('/[^0-9.]/', '', $keyword);

                // Check if the cleaned keyword is not empty
                if ($cleanedKeyword !== '') {
                    // Filter the query by removing non-numeric characters from the amount column
                    $query->whereRaw("CAST(REGEXP_REPLACE(amount, '[^0-9.]', '') AS DECIMAL(10, 2)) LIKE ?", ["%{$cleanedKeyword}%"]);
                }
            })
            ->filterColumn('total_amount', function($query, $keyword) {

                $cleanedKeyword = preg_replace('/[^0-9.]/', '', $keyword);

                if ($cleanedKeyword !== '') {
                    $query->whereRaw("CAST(REGEXP_REPLACE(total_amount, '[^0-9.]', '') AS DECIMAL(10, 2)) LIKE ?", ["%{$cleanedKeyword}%"]);
                }
            })

            ->filterColumn('name', function($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('plan', function($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
                }
            })
             ->orderColumn('name', function ($query, $order) {
                $query->select('subscriptions.*')
                ->leftJoin('plan', 'plan.id', '=', 'subscriptions.plan_id')
                ->groupBy('subscriptions.id')  // Add grouping by primary key
                ->orderBy('plan.name', $order);
            })
           ->addColumn('duration', function ($data) {
                if ($data->plan) {
                    return $data->plan->duration_value . ' ' . $data->plan->duration;
                }
                return '-';
            })
            ->filterColumn('duration', function($query, $keyword) {
                $query->whereHas('plan', function($q) use ($keyword) {
                    $q->whereRaw("CONCAT(duration_value, ' ', duration) LIKE ?", ["%{$keyword}%"]);
                });
            })
            ->orderColumn('duration', function ($query, $order) {
                $query->select('subscriptions.*')
                      ->leftJoin('plan', 'plan.id', '=', 'subscriptions.plan_id')
                      ->groupBy('subscriptions.id')
                      ->orderByRaw("CONCAT(plan.duration_value, ' ', plan.duration) $order");
            })
            ->orderColumn('user_id', function ($query, $order) {
                $query->select('subscriptions.*')
                ->leftJoin('users', 'users.id', '=', 'subscriptions.user_id')
                ->orderByRaw("CONCAT(users.first_name, ' ', users.last_name) $order");
            })
            ->addColumn('payment_method', function ($data) {
                return $data->subscription_transaction->payment_type ?? '-';
            })
            ->filterColumn('payment_method', function ($query, $keyword) {
                $query->whereHas('subscription_transaction', function ($query) use ($keyword) {
                    $query->where('payment_type', 'like', "%$keyword%");
                });
            })
            ->orderColumn('payment_method', function ($query, $order) {
                $query->join('subscriptions_transactions', 'subscriptions_transactions.subscriptions_id', '=', 'subscriptions.id')
                    ->orderBy('subscriptions_transactions.payment_type', $order);
            })
            ->addColumn('action', function ($data) {
                return view('subscriptions::backend.subscriptions.action', compact('data'));
            })
            ->orderColumns(['id'], '-:column $1');

        return $datatable->rawColumns(array_merge(['action','check','coupon_discount','user_id', 'start_date', 'end_date', 'amount', 'name','duration']))
            ->toJson();
    }
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'subscription';
        $messageKey = __('subscription.Post_status');

        return $this->performBulkAction(subscription::class, $ids, $actionType, $moduleName);
    }

    public function create()
    {
        $module_title = __('frontend.create_payment');
        $plans = Plan::where('status',1)->get();
        $users = User::role('user')->where('status',1)->get();
        $fixedTax = Tax::active()->where('type', 'fixed')->sum('value');
        $percentageTax = Tax::active()->where('type', 'percentage')->sum('value');
        return view('subscriptions::backend.subscriptions.create', compact('module_title','plans','users','fixedTax','percentageTax'));

    }

    public function store(SubscriptionRequest $request)
{
    try {
        $this->subscriptionService->createPayment($request->all());

        return redirect()->route('backend.subscriptions.index')
                         ->with('success', __('messages.create_form_subscription', ['type' => __('messages.payment')]));
    } catch (\Exception $e) {
        return redirect()->back()
                         ->withInput()
                         ->withErrors(['coupon_discount' => $e->getMessage()]);
    }
}

    public function edit($id)
    {
        $module_action = __('messages.edit_payment');
        $data = $this->subscriptionService->getPaymentById($id);

        return view('subscriptions::backend.subscriptions.edit', array_merge(['module_action' => $module_action], $data));
    }
    public function update(SubscriptionRequest $request,$id)
    {
        $requestData = $request->all();
        $requestData['id'] = $id;

        $this->subscriptionService->updatePayment($requestData);
        return redirect()->route('backend.subscriptions.index')->with('success', __('messages.update_form_subscription'));

    }
    public function destroy($id)
    {
        $this->subscriptionService->deletePayment($id);
        $message = __('messages.delete_form_subscription', ['form' => 'Payment']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $this->subscriptionService->restorePayment($id);
        $message = __('messages.restore_form_subscription', ['form' => 'Payment']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $this->subscriptionService->forceDeletePayment($id);
        $message = __('messages.permanent_delete_form_subscription', ['form' => 'Payment']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
