<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Houseguest;
use Illuminate\Support\Facades\DB;
use function Clue\StreamFilter\fun;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $season = Season::current();
        $houseguests = Houseguest::where('season_id', $season->id)->get();

        $leaderboard = Leaderboard::where('week', $season->current_week)
                                  ->where('season_id', $season->id)
                                  ->search($request->search)
                                  ->with([
                                      'user.banks',
                                      'user.vanitytags' => function ($q) use ($season) {
                                          $q->where('season_id', $season->id);
                                      }
                                  ])
                                  ->orderBy('rank')
                                  ->cacheFor(now()->addHours(24))
                                  ->paginate(100);

        return view('leaderboard', compact('houseguests', 'leaderboard', 'season'));
    }

    public function allTime()
    {
        $leaderboard = Leaderboard::with([
                                      'user.banks',
                                      'user.vanitytags' => function ($q) {
                                          $q->where('season_id', Season::current()->id);
                                      }
                                  ])
                                  ->whereSeasonEnded()
                                  ->select(DB::raw('user_id, sum(networth) as networth'))
                                  ->where('week', static function ($q) {
                                      $q->select(DB::raw('max(week)'))
                                        ->from('leaderboard')
                                        ->where('season_id', 1)
                                        ->groupBy('season_id');
                                  })->groupBy('user_id')
                                  ->orderBy('networth', 'desc')
                                  ->cacheFor(now()->addHours(24))
                                  ->get();

        return view('leaderboards.alltime', compact('leaderboard'));
    }
}
