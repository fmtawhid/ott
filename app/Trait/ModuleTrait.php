<?php

namespace App\Trait;

use Illuminate\Support\Facades\View;

trait ModuleTrait
{
    protected string $moduleTitle;
    protected string $moduleName;
    protected string $moduleIcon;

    public function initializeModuleTrait(string $moduleTitle, string $moduleName, string $moduleIcon): void
    {
        $this->moduleTitle = $moduleTitle;
        $this->moduleName = $moduleName;
        $this->moduleIcon = $moduleIcon;

        View::share([
            'module_title' => $this->moduleTitle,
            'module_icon' => $this->moduleIcon,
            'module_name' => $this->moduleName,
        ]);
    }

    public function performBulkAction($model, $ids, $actionType, $moduleName)
{
    $message = __('messages.bulk_update');

    switch ($actionType) {
        case 'change-status':
            $model::whereIn('id', $ids)->update(['status' => request()->status]);
            $message = trans('messages.status_updated');
            break;
        case 'delete':
            if (env('IS_DEMO')) {
                return response()->json(['message' => __('messages.permission_denied'), 'status' => false]);
            }
            $model::whereIn('id', $ids)->delete();
            $message = trans('messages.delete_form');
            break;
        case 'restore':
            $model::whereIn('id', $ids)->restore();
            $message = trans('messages.restore_form');
            break;
                
        case 'permanently-delete':
            $model::whereIn('id', $ids)->forceDelete();
            $message = trans('messages.permanent_delete_form');
            break;
        default:
            return response()->json(['status' => false, 'message' => __('service_providers.invalid_action')]);
    }

    return response()->json(['status' => true, 'message' => $message]);
}

}
