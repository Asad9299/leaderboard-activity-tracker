<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use App\Models\UserPoint;

class CalculateLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to calculate the leaderboard.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (['daily', 'monthly', 'yearly'] as $scope) {
            $format = [
                'daily' => 'Y-m-d',
                'monthly' => 'Y-m',
                'yearly' => 'Y',
            ][$scope];

            $periodKey = now()->format($format);

            $activities = Activity::select('user_id')
                ->selectRaw('SUM(points) as total')
                ->whereDate('performed_at', 'like', "{$periodKey}%")
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->get();

            $ranked = [];
            $rank = 1;
            $prevPoints = null;

            foreach ($activities as $index => $activity) {
                if ($activity->total !== $prevPoints) {
                    $rank = $index + 1;
                }

                $ranked[] = [
                    'user_id' => $activity->user_id,
                    'total_points' => $activity->total,
                    'rank' => $rank,
                    'scope' => $scope,
                    'period_key' => $periodKey,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $prevPoints = $activity->total;
            }

            UserPoint::where('scope', $scope)->where('period_key', $periodKey)->delete();
            UserPoint::insert($ranked);
        }

        $this->info('Leaderboard recalculated.');
    }

}
