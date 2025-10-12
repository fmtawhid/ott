<?php

namespace Modules\User\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Http\Requests\PasswordRequest;
use App\Trait\ModuleTrait;
use Hash;
use Modules\Subscriptions\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpiringSubscriptionEmail;

class UsersController extends Controller
{
    protected string $exportClass = '\App\Exports\UserExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'users.title', // module title
            'users', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];

        $module_action = 'List';
        $type=$request->type;
        $module_title = $type == 'soon-to-expire' ? 'users.soon_to_expire' : 'users.title';
        $this->traitInitializeModuleTrait(
            $module_title,
            'users',
            'fa-solid fa-clipboard-list'
        );
        $export_import = true;
        $export_columns = [
            [
                'value' => 'first_name',
                'text' => __('users.lbl_first_name'),
            ],
            [
                'value' => 'last_name',
                'text' => __('users.lbl_last_name'),
            ],
            [
                'value' => 'email',
                'text' => __('users.lbl_email'),
            ],
            [
                'value' => 'mobile',
                'text' => __('users.lbl_contact_number'),
            ],
            [
                'value' => 'gender',
                'text' => __('users.lbl_gender'),
            ]
        ];
        $export_url = route('backend.users.export');

        return view('user::backend.users.index_datatable', compact('module_action','module_title', 'filter', 'export_import', 'export_columns', 'export_url', 'type'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'User'; // Adjust as necessary for dynamic use

        return $this->performBulkAction(User::class, $ids, $actionType, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = User::where('user_type','user')->withTrashed();
        $filterValue  = $request->type;
        if($filterValue == 'soon-to-expire'){
            $query = User::role('user');
            $currentDate = Carbon::now();
            $expiryThreshold = $currentDate->copy()->addDays(7);
            $subscriptions = Subscription::with('user')
            ->where('status', 'active')
            ->whereDate('end_date','<=',$expiryThreshold)
            ->get();
            $userIds = $subscriptions->pluck('user_id');
            $query = User::where('user_type','user')->whereIn('id', $userIds);
        }
        $filter = $request->filter;

        if(isset($filter['name'])) {
            $fullName = $filter['name'];

            $query->where(function($query) use ($fullName) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$fullName%"]);
            });
        }
        if(isset($filter['email'])) {

            $query->where('email',$filter['email']);
        }

        if (isset($filter['column_status'])) {
            $query->where('status', $filter['column_status']);
        }
        return $datatable->eloquent($query)

          ->addColumn('check', function ($data) {
              return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" data-type="users" onclick="dataTableRowCheck('.$data->id.', this)">';
          })
          ->editColumn('name', function ($data) {
              return view('user::backend.users.user_details', compact('data'));
          })
          ->editColumn('mobile', function ($data) {
            if($data->mobile != null){
                return $data->mobile;
            }
            return '-';
        })
        ->editColumn('gender', function ($data) {
            if($data->gender != null){
                return $data->gender;
            }
            return '-';
        })
          ->editColumn('action', function ($data) {
             return view('user::backend.users.action_column', compact('data'));
          })
          ->editColumn('expire_date', function ($data) use ($filterValue) {
            if ($filterValue == 'soon-to-expire') {
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', optional($data->subscriptionPackage)->end_date);
                return formatDate($end_date->format('Y-m-d'));
            }
            return '-';
        })


          ->filterColumn('name', function ($query, $keyword) {
            if (!empty($keyword)) {
                $query->where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')->orWhere('email', 'like', '%' . $keyword . '%');
            }
        })

        ->filterColumn('end_date', function($query, $keyword) {
            try {
                // Attempt to parse the keyword using the display format
                $date = Carbon::createFromFormat('jS F Y', $keyword); // Adjust format based on your display format
                $formattedDate = $date->format('Y-m-d'); // Convert to 'Y-m-d' for the query

                // Apply the formatted date to the query for filtering
                $query->whereDate('end_date', '=', $formattedDate);
            } catch (\Exception $e) {
                // Fallback if parsing fails, use a generic LIKE query
                $query->whereRaw("DATE_FORMAT(end_date, '%D %M %Y') like ?", ["%$keyword%"]);
            }
        })


        ->orderColumn('name', function ($query, $order) {
            $query->orderByRaw("CONCAT(first_name, ' ', last_name) $order");
        }, 1)


        ->editColumn('status', function ($row) {
            $checked = $row->status ? 'checked="checked"' : ''; // Set the checkbox to checked if status is true
            $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the user is soft-deleted
        
            return '
                <div class="form-check form-switch">
                    <input type="checkbox" data-url="' . route('backend.users.update_status', $row->id) . '" 
                           data-token="' . csrf_token() . '" class="switch-status-change form-check-input"  
                           id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" 
                           ' . $checked . ' ' . $disabled . '>
                </div>
            ';
        })     

        ->editColumn('gender', function ($data) {
            return $data->gender ? ucwords($data->gender) : '-';
        })

        ->editColumn('mobile', function ($data) {
            return $data->mobile ? ucwords($data->mobile) : '-';
        })



          ->editColumn('updated_at', fn($data) => $this->formatUpdatedAt($data->updated_at))
          ->rawColumns(['action','name', 'status', 'check','gender'])
          ->orderColumns(['id'], '-:column $1')
          ->make(true);


    }

    private function formatUpdatedAt($updatedAt)
      {
          $diff = Carbon::now()->diffInHours($updatedAt);
          return $diff < 25 ? $updatedAt->diffForHumans() : $updatedAt->isoFormat('llll');
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

      public function create()
    {
        $module_title = __('users.lbl_add_new_user');
        $mediaUrls = getMediaUrls();

      return view('user::backend.users.form',compact('module_title','mediaUrls'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->except('profile_image');

        $data['password']=Hash::make($data['password']);
        $data['user_type']='user';

        $data['file_url'] = extractFileNameFromUrl($data['file_url']);


        $user = User::create($data);
        $user->assignRole('user');

        $message = trans('messages.create_form_user');
        return redirect()->route('backend.users.index')->with('success', 'User added successfully!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        $mediaUrls = getMediaUrls();
        $module_title = __('users.lbl_edit_user');
    return view('user::backend.users.form', compact('data','mediaUrls','module_title'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();

        $data['file_url'] = extractFileNameFromUrl($data['file_url']);

        $user->update($data);

        // if ($request->hasFile('file_url')) {
        //     $file = $request->file('file_url');
        //     StoreMediaFile($user, $file, 'file_url');
        //     $data['file_url'] = $user->getFirstMediaUrl('file_url');
        // } elseif ($request->input('file_url_removed') == 1) {

        //     $user->clearMediaCollection('file_url');

        // } else {
        //     $data['file_url'] = $user->file_url ?: '';
        // }

        // $user->update(['file_url' => $data['file_url']]);


        // return redirect()->route('backend.users.index')->with('success', __('messages.update_form'));
        $message = trans('messages.update_form_user');

        return redirect()->route('backend.users.index')->with('success', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->forceDelete();
        $message = trans('messages.delete_form_user');
        return response()->json(['message' =>  $message, 'status' => true], 200);
    }


    public function update_status(Request $request, User $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('messages.status_updated_user')]);
    }

    public function changepassword($id){

        $id = $id;
        return view('user::backend.users.changepassword', compact('id'));

    }

    public function updatePassword(PasswordRequest $request,  $id){

        $user = User::where('id', $id)->first();

        if ($user == "") {
            $message = __('messages.user_not_found');
            return redirect()->route('backend.users.changepassword',['id' => $id])->with('error', $message);
        }

        $hashedPassword = $user->password;

        $match = Hash::check($request->old_password, $hashedPassword);

        $same_exits = Hash::check($request->password, $hashedPassword);
        if ($match) {
            if ($same_exits) {
                $message = __('messages.same_pass');
                return redirect()->route('backend.users.changepassword',['id' => $user->id])->with('error', $message);
            }

            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            $message = __('messages.pass_successfull');
            return redirect()->route('backend.users.index', $user->id)->with('success', $message);
        } else {
            $message = __('messages.check_old_password');
            return redirect()->route('backend.users.changepassword',['id' => $user->id])->with('error', $message);
        }


    }

    // expire user send mail
    public function sendEmail(Request $request)
    {
        // Get user IDs with subscriptions expiring within 7 days
        $expiryThreshold = Carbon::now()->addDays(7);
        // $userIds = Subscription::where('status', '1')
        //     ->where('end_date', '<=', $expiryThreshold)
        //     ->pluck('user_id')
        //     ->toArray();
        $subscriptions = Subscription::with('user')
        ->where('status', 'active')
        ->whereDate('end_date','<=',$expiryThreshold)
        ->get();
        $userIds = $subscriptions->pluck('user_id');

        // Get users with the retrieved user IDs
        $users = User::whereIn('id', $userIds)->get();

        // Send email to each user
        foreach ($users as $user) {
            // Customize email send
            if (isSmtpConfigured()) {
                Mail::to($user->email)->send(new ExpiringSubscriptionEmail($user));
            }else{
            return response()->json(['message' => 'There is an issue with mail service please check configurations.', 'status' => true], 200);

            }
        }

        $message = __('customer.email_sent');
        return response()->json(['message' => $message, 'status' => true], 200);
    }



    public function details($id)
    {
        $data = User::with(['subscriptiondata'])->findOrFail($id);
        $module_title = __('users.title');
        $show_name = $data->first_name . ' ' . $data->last_name;
        $route = 'backend.users.index';

        return view('user::backend.users.details', compact('data', 'module_title','show_name','route'));
    }










}
