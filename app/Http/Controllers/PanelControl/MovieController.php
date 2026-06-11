<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $page = $request->get('page', '');
            if (empty($query)) {
                if ($request->ajax()) {
                    return response()->json([
                        'movies' => [],
                        'total' => 0,
                        'error' => null
                    ]);
                }
            }

            $result = $this->movieService->search($query, $page);
            if ($request->ajax()) {
                return response()->json($result);
            }

            return view('controlpanel.dashboard', [
                'movies' => $result['movies'],
                'error' => $result['error'],
                'favorites' => auth()->user()->favorites->pluck('imdb_id')->toArray()
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error');
        }
    }

    public function detail(Request $request, $imdbID)
    {
        try {
            $result = $this->movieService->detail($imdbID);
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('imdb_id', $imdbID)->exists();
            return view('controlpanel.detail', [
                'movie' => $result['movie'],
                'error' => $result['error'],
                'isFavorite' => $isFavorite
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error');
        }
    }
}   