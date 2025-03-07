<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $totalStats = $this->count();

        // Count how many stats have "completed" set to true
        $completedCount = $this->where('completed', true)->count();

        // Count how many stats are not completed
        $notCompletedCount = $this->where('completed', false)->count();

        // Get the fastest stat (the one with the lowest "completion_time")
        $fastestStat = $this->where('completed', true)->sortBy('completion_time')->first();
        $fastestCompletionTime = $fastestStat ? $fastestStat->completion_time : null;

        // Calculate the average "completion_time" (only for completed stats)
        $averageCompletionTime = $this->where('completed', true)->avg('completion_time');

        // Calculate the average "used_attempts"
        $averageUsedAttempts = $this->avg('used_attempts');

        return [
            'total_stats' => $totalStats,
            'completed_count' => $completedCount,
            'not_completed_count' => $notCompletedCount,
            'fastest_completion_time' => $fastestCompletionTime,
            'average_completion_time' => $averageCompletionTime,
            'average_used_attempts' => $averageUsedAttempts,
        ];
    }
}
