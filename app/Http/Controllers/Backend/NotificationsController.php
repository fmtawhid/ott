<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;
use App\Models\User;

class NotificationsController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'messages.title_list';

        // module name
        $this->module_name = 'notifications';

        // directory path of the module
        $this->module_path = 'notifications';

        // module icon
        $this->module_icon = 'c-icon fas fa-bell';

        // module model name, path
        $this->module_model = "App\Models\User";

        $this->middleware(['permission:view_notification'])->only('index');
        $this->middleware(['permission:edit_notification'])->only('edit', 'update');
        $this->middleware(['permission:add_notification'])->only('store');
        $this->middleware(['permission:delete_notification'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $user = auth()->user();

        if (count($user->unreadNotifications) > 0) {
            $user->unreadNotifications->markAsRead();
        }

        $$module_name = auth()->user()->notifications()->paginate();
        $unread_notifications_count = auth()->user()->unreadNotifications()->count();

        $notifications_count = 0;

        return view(
            "backend.$module_path.index",
            compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'unread_notifications_count', 'notifications_count')
        );
    }
    public function index_data(Datatables $datatable, Request $request)
    {
        // $user = auth()->user();

        // $query = Notification::where('notifiable_id',$user->id)->value('id');
      // Fetch the user's notifications
        $query = auth()->user()->notifications();

        return $datatable->eloquent($query)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-' . e($data->id) . '" name="datatable_ids[]" value="' . e($data->id) . '" data-type="taxes" onclick="dataTableRowCheck(' . e($data->id) . ',this)">';
            })
            ->addColumn('action', function ($data) {
                return view('backend.notifications.action_column', compact('data'));
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->diffForHumans();
            })
            ->addColumn('id', function ($row) {
                $data = $this->decodeData($row->data);
                return $data['data']['id'] ?? '-';
            })
            ->addColumn('type', function ($row) {
                $data = $this->decodeData($row->data);
                if (isset($data['data']['notification_group']) && $data['data']['notification_group'] == 'subscription') {
                    // Construct the URL using route helper and PHP concatenation
                    return '<a href="' . route('backend.users.details', ['id' => $data['data']['user_id']]) . '">'.ucfirst($data['data']['notification_group']) . '</a>';
                }
                // Return the notification group or a dash if not available
                return ucfirst($data['data']['notification_group'] ?? '-');
            })
            ->addColumn('text', function ($data) {
                // $data = $this->decodeData($row->data);
                // return $data['subject'] ?? '';

                return view('backend.notifications.type', compact('data'));
            })
            ->addColumn('customer', function ($row) {
                $data = $this->decodeData($row->data);
                $user_id = $data['data']['user_id'] ?? '';
                $user = User::find($user_id);

                return view('components.user-detail-card', [
                    'image' => setBaseUrlWithFileName(optional($user)->file_url) ?? default_user_avatar(),
                    'name' => optional($user)->full_name ?? '-',
                    'email' => optional($user)->email ?? '-'
                ])->render();
            })
            ->rawColumns(['action', 'check', 'customer','type'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }
    // Helper function to decode JSON data
    private function decodeData($data) {
        return is_string($data) ? json_decode($data, true) : $data;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = Notification::where('id', '=', $id)->where('notifiable_id', '=', auth()->user()->id)->first();

        if ($$module_name_singular) {
            if ($$module_name_singular->read_at == '') {
                $$module_name_singular->read_at = Carbon::now();
                $$module_name_singular->save();
            }
        }

        return view(
            "backend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular")
        );
    }

    /**
     * Delete All the Notifications.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteAll()
    {
        $user = auth()->user();

        $user->notifications()->delete();

        Flash::success("<i class='fas fa-check'></i> All Notifications Deleted")->important();

        return back();
    }

    /**
     * Mark All Notifications As Read.
     *
     * @return [type] [description]
     */
    public function markAllAsRead()
    {
        $user = auth()->user();

        $user->unreadNotifications()->update(['read_at' => now()]);

        Flash::success("<i class='fas fa-check'></i> All Notifications Marked As Read")->important();

        return back();
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = __('sidebar.notification_list');
        return $this->performBulkAction(Notification::class, $ids, $actionType, $moduleName);
    }

    public function notificationList(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';
        $user = auth()->user();
        $user->last_notification_seen = now();
        $user->save();

        $type = isset($request->type) ? $request->type : null;
        if ($type == 'markas_read') {
            if (count($user->unreadNotifications) > 0) {
                $user->unreadNotifications->markAsRead();
            }
            $notifications = $user->notifications->take(5);
        } elseif ($type == null) {
            $notifications = $user->notifications->take(5);
        } else {
            $notifications = $user->notifications->where('data.type', $type)->take(5);
        }
        $all_unread_count = isset($user->unreadNotifications) ? $user->unreadNotifications->count() : 0;


        return response()->json([
            'status' => true,
            'type' => $type,
            'data' => view("backend.$module_name.list", compact('notifications', 'all_unread_count', 'user'))->render(),
        ]);
    }

    public function notificationRemove($id)
    {

        $data = Notification::where('id', $id)->firstOrFail();

        $data->delete();

        $message = __('notification.notification_deleted');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function notificationCounts(Request $request)
    {
        $user = auth()->user();
        $unread_count = 0;
        $unread_total_count = 0;

        if (isset($user->unreadNotifications)) {
            $unread_count = $user->unreadNotifications->where('created_at', '>', $user->last_notification_seen)->count();
            $unread_total_count = $user->unreadNotifications->count();
        }

        return response()->json([
            'status' => true,
            'counts' => $unread_count,
            'unread_total_count' => $unread_total_count,
        ]);
    }
}
