<?php

namespace Modules\Subscriptions\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Subscriptions\Models\Subscription;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function all()
    {
        return Subscription::query()
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function find($id)
    {
        $subscriptionQuery = Subscription::query()->with(['user', 'plan'])->withTrashed();

        $subscriptionQuery->whereNull('deleted_at');
        
        $subscription = $subscriptionQuery->findOrFail($id);

        return $subscription;
    }

    public function create(array $data)
    {
        return Subscription::create($data);
    }

    public function update($id, array $data)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($data);
        return $subscription;
    }

    public function delete($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);
        $subscription->subscription_transaction()->delete();
        $subscription->Delete();
        return $subscription;
    }

    public function restore($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);
        $subscription->restore();
        return $subscription;
    }

    public function forceDelete($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);
    
        $subscription->subscription_transaction()->forceDelete();
    
        $subscription->forceDelete();
        return $subscription;
    }

    public function query()
    {
        $subscriptionQuery = Subscription::with(['user', 'plan'])->withTrashed();

        if (Auth::user()->hasRole('user')) {
            $subscriptionQuery->where('user_id', Auth::id())->whereNull('deleted_at');
        }

        return $subscriptionQuery;
    }

    public function list($perPage, $searchTerm = null)
    {
        $query = Subscription::query();

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $query->where('status', 1)
              ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage);
    }
}
