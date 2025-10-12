<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Modules\Entertainment\Models\EntertainmentDownload;
use Modules\Entertainment\Models\EntertainmentView;
use Modules\Subscriptions\Models\SubscriptionTransactions;
use Modules\Entertainment\Models\Entertainment;
use Modules\Video\Models\Video;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Modules\Genres\Models\Genres;
use Modules\Entertainment\Models\Review;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Modules\Frontend\Models\PayperviewTransaction;
use Modules\Episode\Models\Episode;



class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Fetch all regular users
        $allUsers = User::where('user_type', 'user')->get();

        // Total entertainment downloads
        $totalDownloads = EntertainmentDownload::count();

        // Total subscription transactions
        $totalTransactions = SubscriptionTransactions::count();

        // Count of new users  this month
        $startOfMonth = Carbon::now()->startOfMonth();
        $newUsersCount = User::where('user_type', 'user')
            ->whereDate('created_at', '>=', $startOfMonth)
            ->count();
        $totalusers = $allUsers->count();
        $activeusers = $allUsers->where('status', 1)->count();
        $totalSubscribers = $allUsers->where('is_subscribe', 1)->count();
        $entertainments = Entertainment::where('status', 1)->get();
        $totalmovies = $entertainments->where('type', 'movie')->count();
        $totaltvshow = $entertainments->where('type', 'tvshow')->count();
        $video = Video::where('status', 1)->get();
        $totalvideo = $video->count();
        $currentDate = Carbon::now();
        $expiryThreshold = $currentDate->copy()->addDays(7);
        $subscriptions = Subscription::with('user')
        ->where('status', 'active')
        ->whereDate('end_date','<=',$expiryThreshold)
        ->get();
        $userIds = $subscriptions->pluck('user_id');
        $totalsoontoexpire = $allUsers->whereIn('id', $userIds)->where('status',1)->count();
        $totalreview = Review::count();

        // Latest 4 subscription transactions
        $transactions = SubscriptionTransactions::orderBy('created_at', 'desc')
            ->take(4)
            ->get();


        //view
        $mostFrequentIds = EntertainmentView::select('entertainment_id')
            ->groupBy('entertainment_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(4)
            ->pluck('entertainment_id')
            ->toArray();


        $entertainments = Entertainment::whereIn('id', $mostFrequentIds)->get();


      $reviewData = Review::with(['entertainment', 'user'])
      ->whereHas('entertainment', function($query) {

          if(isenablemodule('tvshow') == 1 &&  isenablemodule('movie') == 1){
              $query->where('type', 'movie')->orwhere('type', 'tvshow');
          }else{
            if (isenablemodule('movie') == 1) {
                $query->where('type', 'movie');
            }

            if (isenablemodule('tvshow') == 1) {
                $query->Where('type', 'tvshow');
            }

          }
     })
    //   ->where('rating', 5)
      ->orderBy('created_at', 'desc')
      ->take(6)
      ->get();


        $subscriptionData = Subscription::with('user', 'subscription_transaction', 'plan')->orderBy('created_at', 'desc')->take(6)->get();

        $subscription_revenue = (float) Subscription::sum('total_amount');

        $rent_revenue = (float) PayperviewTransaction::sum('amount');

        $total_revenue = (float) Subscription::sum('total_amount')+(float) PayperviewTransaction::sum('amount');

        $count_of_rent_movie =  Entertainment::where('type','movie')->where('status',1)->where('movie_access','pay-per-view')->count();
        $count_of_rent_episode =  Episode::where('access','pay-per-view')->where('status',1)->count();



        $diskType = env('ACTIVE_STORAGE', 'local');
        // if ($diskType == 'local') {
        //     // Use local storage disk
        //     $totalUsageInBytes = $this->getTotalStorageUsage($diskType);
        // } else {
        //     // Use DigitalOcean Spaces for production
        //     $totalUsageInBytes = $this->getTotalStorageUsage($diskType);
        // }
        // // Format the storage usage into a readable format
        // $totalUsageFormatted = $this->formatBytes($totalUsageInBytes);

        $totalUsageFormatted=0;

        return view('backend.dashboard.index', compact('totalUsageFormatted','count_of_rent_movie','count_of_rent_episode','rent_revenue','subscription_revenue','totalreview','totalsoontoexpire','total_revenue','allUsers', 'newUsersCount', 'totalDownloads', 'totalTransactions', 'transactions', 'entertainments','totalusers','activeusers','totalSubscribers','totalmovies','totaltvshow','totalvideo','reviewData','subscriptionData'));
    }

    private function getTotalStorageUsage($disk)
    {
        $totalSize = 0;
        $files = Storage::disk($disk)->allFiles();

        foreach ($files as $file) {
            $fileSize = Storage::disk($disk)->size($file);

            $totalSize += $fileSize;
        }
        return $totalSize;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    public function getRevenuechartData(Request $request, $type)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        if ($type == 'Year') {

            $monthlyTotals = SubscriptionTransactions::selectRaw('YEAR(updated_at) as year')
                ->selectRaw('MONTH(updated_at) as month')
                ->selectRaw('SUM(amount) as total_amount')
                ->where('payment_status', 'paid')
                ->groupByRaw('YEAR(updated_at), MONTH(updated_at)')
                ->orderByRaw('YEAR(updated_at), MONTH(updated_at)')
                ->get();

            $monthlyPayPerViewTotals = PayperviewTransaction::selectRaw('YEAR(updated_at) as year')
                ->selectRaw('MONTH(updated_at) as month')
                ->selectRaw('SUM(amount) as amount')
                ->groupByRaw('YEAR(updated_at), MONTH(updated_at)')
                ->orderByRaw('YEAR(updated_at), MONTH(updated_at)')
                ->get();

            $chartData = [];

            for ($month = 1; $month <= 12; $month++) {
                $subscriptionAmount = 0;
                $payPerViewAmount = 0;

                foreach ($monthlyTotals as $total) {
                    if ((int)$total->month === $month) {
                        $subscriptionAmount = (float)$total->total_amount;
                        break;
                    }
                }

                foreach ($monthlyPayPerViewTotals as $total) {
                    if ((int)$total->month === $month) {
                        $payPerViewAmount = (float)$total->amount;
                        break;
                    }
                }

                $chartData[] = $subscriptionAmount + $payPerViewAmount;
            };

            $category = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ];
        } else if ($type == 'Month') {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Fetch daily totals for the current month
            $dailyTotals = SubscriptionTransactions::selectRaw('DAY(updated_at) as day, COALESCE(SUM(amount), 0) as total_amount')
                ->where('payment_status', 'paid')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $currentMonth)
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            $dailyPayPerViewTotals = PayperviewTransaction::selectRaw('DAY(updated_at) as day, COALESCE(SUM(amount), 0) as amount')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $currentMonth)
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            $chartData = [];

            // Number of weeks based on 7-day intervals
            $weeksInMonth = ceil($endOfMonth->day / 7);

            // Loop over each week (7-day block) in the current month
            for ($week = 1; $week <= $weeksInMonth; $week++) {
                $weekTotal = 0;
                $found = false;

                // Loop over each day in the current week
                for ($day = ($week - 1) * 7 + 1; $day <= min($week * 7, $endOfMonth->day); $day++) {
                    foreach ($dailyTotals as $total) {
                        if ((int)$total->day === $day) {
                            $weekTotal += (float)$total->total_amount;
                            $found = true;
                        }
                    }
                    foreach ($dailyPayPerViewTotals as $total) {
                        if ((int)$total->day === $day) {
                            $weekTotal += (float)$total->amount;
                            $found = true;
                        }
                    }
                }

                // If no data is found for the current week, set the value to 0
                $chartData[] = $found ? $weekTotal : 0;
            }

            // Set the category for weeks
            $category = [];
            for ($i = 1; $i <= $weeksInMonth; $i++) {
                $category[] = "Week " . $i;
            }
        } else if ($type == 'Week') {

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = SubscriptionTransactions::selectRaw('DAY(updated_at) as day, COALESCE(SUM(amount), 0) as total_amount')
                ->where('payment_status', 'paid')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $currentMonth)
                ->whereBetween('updated_at', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            $weeklyPayPerViewDayTotals = PayperviewTransaction::selectRaw('DAY(updated_at) as day, COALESCE(SUM(amount), 0) as amount')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $currentMonth)
                ->whereBetween('updated_at', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            $chartData = [];

            for ($day =  $currentWeekStartDate; $day <= $lastDayOfWeek; $day->addDay()) {
                $dayTotal = 0;
                $found = false;

                foreach ($weeklyDayTotals as $total) {
                    if ((int)$total->day === $day->day) {
                        $dayTotal += (float)$total->total_amount;
                        $found = true;
                    }
                }

                foreach ($weeklyPayPerViewDayTotals as $total) {
                    if ((int)$total->day === $day->day) {
                        $dayTotal += (float)$total->amount;
                        $found = true;
                    }
                }

                $chartData[] = $found ? $dayTotal : 0;
            };

            $category = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        }

        $data = [
            'chartData' => $chartData,
            'category' => $category
        ];

        return response()->json(['data' => $data, 'status' => true]);
    }

    public function getSubscriberChartData(Request $request, $type)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $plans = Plan::all();

        $plans = Plan::all()->keyBy('id');

        if ($type == 'Year') {
            $monthlyTotals = Subscription::selectRaw('YEAR(start_date) as year, MONTH(start_date) as month, plan_id')
            ->selectRaw('COUNT(*) as total_subscribers') // Get a comma-separated list of unique user_ids
            ->groupByRaw('YEAR(start_date), MONTH(start_date), plan_id')
            ->orderByRaw('YEAR(start_date), MONTH(start_date), plan_id')
            ->get()
            ->groupBy('plan_id');

            $chartData = [];

            foreach ($plans as $planId => $plan) {
                $planData = [];
                $planName = $plan->name;

                for ($month = 1; $month <= 12; $month++) {
                    $found = false;
                    if (isset($monthlyTotals[$planId])) {
                        foreach ($monthlyTotals[$planId] as $total) {
                            if ((int)$total->month === $month) {
                                $planData[] = $total->total_subscribers;
                                $found = true;
                                break;
                            }
                        }
                    }
                    if (!$found) {
                        $planData[] = 0;
                    }
                }

                $chartData[] = [
                    'name' => $planName,
                    'data' => $planData
                ];
            }


            $category = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ];
        } else if ($type == 'Month') {

            // Get the start and end of the current month
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Fetch daily subscription totals for the current month
            $monthlyDayTotals = Subscription::selectRaw('DAY(start_date) as day, plan_id')
                ->selectRaw('COUNT(*) as total_subscribers')
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $currentMonth)
                ->groupBy('day', 'plan_id')
                ->orderBy('day')
                ->get()
                ->groupBy('plan_id');

            $chartData = [];

            // Calculate the total number of weeks in the month (based on 7-day blocks)
            $weeksInMonth = ceil($endOfMonth->day / 7);

            foreach ($plans as $planId => $plan) {
                $planData = [];
                $planName = $plan->name;

                // Loop through each week of the month
                for ($week = 1; $week <= $weeksInMonth; $week++) {
                    $weekTotal = 0;
                    $found = false;

                    // Loop over each day in the current week (7-day block)
                    for ($day = ($week - 1) * 7 + 1; $day <= min($week * 7, $endOfMonth->day); $day++) {
                        // Check if we have data for the current day and plan
                        if (isset($monthlyDayTotals[$planId])) {
                            foreach ($monthlyDayTotals[$planId] as $total) {
                                if ((int)$total->day === $day) {
                                    $weekTotal += $total->total_subscribers;
                                    $found = true;
                                }
                            }
                        }
                    }

                    // Add the total subscribers for this week (or 0 if no data found)
                    $planData[] = $found ? $weekTotal : 0;
                }

                $chartData[] = [
                    'name' => $planName,
                    'data' => $planData
                ];
            }

            // Create categories for the weeks
            $category = [];
            for ($i = 1; $i <= $weeksInMonth; $i++) {
                $category[] = "Week " . $i;
            }
        } else if ($type == 'Week') {

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = Subscription::selectRaw('DAY(start_date) as day, plan_id')
                ->selectRaw('COUNT(*) as total_subscribers')
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $currentMonth)
                ->whereBetween('start_date', [$currentWeekStartDate, $lastDayOfWeek])
                ->groupBy('day', 'plan_id')
                ->orderBy('day')
                ->get();

            $chartData = [];

            foreach ($plans as $planId => $plan) {
                $planData = [];
                $planName = $plan->name;

                for ($day = clone $currentWeekStartDate; $day <= $lastDayOfWeek; $day->addDay()) {
                    $found = false;

                    foreach ($weeklyDayTotals as $total) {
                        if ((int)$total->day === $day->day && $total->plan_id == $planId) {
                            $planData[] = $total->total_subscribers;
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $planData[] = 0;
                    }
                }

                $chartData[] = [
                    'name' => $planName,
                    'data' => $planData
                ];
            }
            $category = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        }

        $data = [

            'chartData' => $chartData,
            'category' => $category

        ];

        return response()->json(['data' => $data, 'status' => true]);
    }

    public function getGenreChartData(Request $request)
    {
        $genreData = Genres::withCount('entertainmentGenerMappings')
            ->orderBy('entertainment_gener_mappings_count', 'desc')
            ->limit(5)
            ->get();

        $genreNames = [];
        $entertainmentCounts = [];

        foreach ($genreData as $genre) {
            $genreNames[] = $genre->name;
            $entertainmentCounts[] = $genre->entertainment_gener_mappings_count;
        }


        $data = [

            'chartData' => $entertainmentCounts,
            'category' => $genreNames

        ];


        return response()->json(['data' => $data, 'status' => true]);
    }

    public function getMostwatchChartData(Request $request, $type)
    {

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $entertainmentTypes = [];

        if (isenablemodule('movie') == 1) {
            $entertainmentTypes['movie'] = 'Movie';
        }

        if (isenablemodule('tvshow') == 1) {
            $entertainmentTypes['tvshow'] = 'TV Show';
        }



        if ($type == 'Year') {
            $monthlyTotals = EntertainmentView::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, entertainment_id')
                ->selectRaw('COUNT(*) as total_views')
                ->whereYear('created_at', $currentYear)
                ->groupByRaw('YEAR(created_at), MONTH(created_at), entertainment_id')
                ->orderByRaw('YEAR(created_at), MONTH(created_at), entertainment_id')
                ->get()
                ->groupBy('entertainment_id');

            $chartData = [];

            foreach ($entertainmentTypes as $type => $typeName) {
                $typeData = [];

                for ($month = 1; $month <= 12; $month++) {
                    $totalViews = 0;
                    foreach ($monthlyTotals as $entertainmentId => $totals) {
                        $entertainment = Entertainment::find($entertainmentId);
                        if ($entertainment && $entertainment->type === $type) {
                            foreach ($totals as $total) {
                                if ((int)$total->month === $month) {
                                    $totalViews += $total->total_views;
                                }
                            }
                        }
                    }
                    $typeData[] = $totalViews;
                }

                $chartData[] = [
                    'name' => $typeName,
                    'data' => $typeData
                ];
            }

            $category = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ];
        } elseif ($type == 'Month') {

            $firstWeek = Carbon::now()->startOfMonth()->week;
            $lastWeek = Carbon::now()->endOfMonth()->week;

            $monthlyWeekTotals = EntertainmentView::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, WEEK(created_at, 1) as week, entertainment_id')
                ->selectRaw('COUNT(*) as total_views')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->groupBy('year', 'month', 'week', 'entertainment_id')
                ->orderBy('year')
                ->orderBy('month')
                ->orderBy('week')
                ->get()
                ->groupBy('entertainment_id');

            $chartData = [];

            foreach ($entertainmentTypes as $type => $typeName) {
                $typeData = [];

                for ($week = $firstWeek; $week <= $lastWeek; $week++) {
                    $totalViews = 0;
                    foreach ($monthlyWeekTotals as $entertainmentId => $totals) {
                        $entertainment = Entertainment::find($entertainmentId);
                        if ($entertainment && $entertainment->type === $type) {
                            foreach ($totals as $total) {
                                if ((int)$total->week === $week) {
                                    $totalViews += $total->total_views;
                                }
                            }
                        }
                    }
                    $typeData[] = $totalViews;
                }

                $chartData[] = [
                    'name' => $typeName,
                    'data' => $typeData
                ];
            }

            $category = [];
            for ($week = $firstWeek; $week <= $lastWeek; $week++) {
                $category[] = "Week " . ($week - $firstWeek + 1);
            }
        } elseif ($type == 'Week') {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = EntertainmentView::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, entertainment_id')
                ->selectRaw('COUNT(*) as total_views')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('year', 'month', 'day', 'entertainment_id')
                ->orderBy('year')
                ->orderBy('month')
                ->orderBy('day')
                ->get()
                ->groupBy('entertainment_id');

            $chartData = [];

            foreach ($entertainmentTypes as $type => $typeName) {
                $typeData = [];

                for ($day = 0; $day < 7; $day++) {
                    $date = Carbon::now()->startOfWeek()->addDays($day);
                    $totalViews = 0;
                    foreach ($weeklyDayTotals as $entertainmentId => $totals) {
                        $entertainment = Entertainment::find($entertainmentId);
                        if ($entertainment && $entertainment->type === $type) {
                            foreach ($totals as $total) {
                                if ($total->day == $date->day) {
                                    $totalViews += $total->total_views;
                                }
                            }
                        }
                    }
                    $typeData[] = $totalViews;
                }

                $chartData[] = [
                    'name' => $typeName,
                    'data' => $typeData
                ];
            }

            $category = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        }

        $data = [

            'chartData' => $chartData,
            'category' => $category

        ];

        return response()->json(['data' => $data, 'status' => true]);
    }

    public function getTopRatedChartData(Request $request)
    {

        $topRatedData = Review::select('entertainment_id', DB::raw('AVG(rating) as avg_rating'))
            ->groupBy('entertainment_id')
            ->orderBy('avg_rating', 'desc')
            ->get();

        $entertainmentData = Entertainment::whereIn('id', $topRatedData->pluck('entertainment_id'))
            ->get()
            ->keyBy('id');

        $movieCount = 0;
        $tvShowCount = 0;

        foreach ($topRatedData as $data) {
            $entertainment = $entertainmentData->get($data->entertainment_id);
            if ($entertainment) {
                if ($entertainment->type == 'movie') {
                    $movieCount++;
                } elseif ($entertainment->type == 'tvshow') {
                    $tvShowCount++;
                }
            }
        }

        $chartData = [];
        $category = [];

        // Check for enabled modules and build the chartData and category arrays accordingly
        if (isenablemodule('movie') == 1) {
            $chartData[] = [
                'name' => 'Movies',
                'data' => [$movieCount] // Use an array for radialBar chart
            ];
            $category[] = 'Movies';
        }

        if (isenablemodule('tvshow') == 1) {
            $chartData[] = [
                'name' => 'TV Shows',
                'data' => [$tvShowCount] // Use an array for radialBar chart
            ];
            $category[] = 'TV Shows';
        }

        $data = [
            'chartData' => $chartData,
            'category' => $category
        ];

        return response()->json(['data' => $data, 'status' => true]);
    }

}
