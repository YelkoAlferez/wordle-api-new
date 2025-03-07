<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserStatsResource;
use App\Models\User;
use App\Models\UserStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Log;

class UserStatController extends Controller
{
    public function index(){
       
    }

    public function show(User $user){

    }

    public function create(Request $request){
        try{
            $dataInput = $request->all();
            $dataInput['user_id'] = auth()->user()->id;
            
            UserStat::create($dataInput);

            return response()->json(["retCode" => 200]);
        }catch(Throwable $e){
            Log::debug($e->getLine());
        }
    }

    public function delete(User $user){
        
    }

    public function stats(){
            $user = Auth::user();
            
            $stats = UserStat::where("user_id", $user->id)->get();
        
            $totalStats = $stats->count();
        
            $completedCount = $stats->where('completed', 1)->count();
        
            $notCompletedCount = $stats->where('completed', 0)->count();
        
            $fastestStat = $stats->where('completed', 1)->sortBy('completion_time')->first();
            $fastestCompletionTime = $fastestStat ? $fastestStat->completion_time : null;
        

            $averageCompletionTime = $this->calculateAverageCompletionTime($stats);
        
            $minUsedAttempts = $stats->min('used_attempts');
        
            return response()->json(["retCode" => 200,
                'stats' => [
                'totalStats' => $totalStats,
                'completedCount' => $completedCount,
                'notCompletedCount' => $notCompletedCount,
                'fastestCompletionTime' => $fastestCompletionTime,
                'averageCompletionTime' => $averageCompletionTime,
                'minUsedAttempts' => $minUsedAttempts,
                ]
            ]);

        }


        private function calculateAverageCompletionTime($stats)
        {
            $totalSeconds = $stats->where('completed', 1)->map(function ($stat) {
                $timeParts = explode(':', $stat->completion_time);

                if (count($timeParts) === 3) {
                    $hours = (int) $timeParts[0];
                    $minutes = (int) $timeParts[1];
                    $seconds = (int) $timeParts[2];

                    return ($hours * 3600) + ($minutes * 60) + $seconds;
                }

                return 0;
            });

            $averageSeconds = $totalSeconds->avg();

            $hours = floor($averageSeconds / 3600);
            $minutes = floor(($averageSeconds % 3600) / 60);
            $seconds = $averageSeconds % 60;

            return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        }

        
}
