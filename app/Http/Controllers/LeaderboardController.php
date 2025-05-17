<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserPoint;
use Illuminate\Support\Facades\Artisan;
class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $scope = $request->get('scope', 'daily');
        $searchId = $request->get('search');

        $dateKey = match ($scope) {
            'daily' => now()->format('Y-m-d'),
            'monthly' => now()->format('Y-m'),
            'yearly' => now()->format('Y'),
        };

        $query = UserPoint::with('user')
            ->where('scope', $scope)
            ->where('period_key', $dateKey)
            ->orderBy('rank');

        if ($searchId) {
            $query->where('user_id', $searchId);
        }

        $leaderboard = $query
        ->orderBy('rank')
        ->get();

        return view('leaderboard.index', compact('leaderboard', 'scope', 'searchId'));
    }

    public function recalculate()
    {
        Artisan::call('leaderboard:calculate');
        return to_route('leaderboard.index')->with('success', 'Leaderboard recalculated.');
    }
}
