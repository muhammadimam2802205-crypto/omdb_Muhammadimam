<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = $this->movieService->getUserFavorites();

        return view('controlpanel.Fav', [
            'movies' => $movies,
        ]);
    }

    // // GET /favorites/list
    // public function list()
    // {
    //     $favorites = Favorite::where('user_id', Auth::id())
    //         ->pluck('imdb_id') // ambil hanya kolom imdb_id → array
    //         ->toArray();

    //     return response()->json([
    //         'success'   => true,
    //         'favorites' => $favorites,
    //     ]);
    // }

    // // POST /favorites/add
    public function add(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string',
        ]);

        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'imdb_id' => $request->imdb_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Movie added to favorites',
        ]);
    }

    // DELETE /favorites/{imdbId}
    public function destroy($imdbId)
    {
        Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $imdbId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Movie removed from favorites',
        ]);
    }
}