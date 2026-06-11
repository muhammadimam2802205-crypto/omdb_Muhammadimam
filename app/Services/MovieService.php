<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;

class MovieService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('omdb.base_url')
        ]);
        $this->apiKey = config('omdb.api_key');
    }

    public function search($query, $page = 1)
    {
        try {
            $response = $this->client->get('', [
                'query' => [
                    'apikey' => $this->apiKey,
                    's'      => $query,
                    'page'   => $page,
                    'type'   => 'movie',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            if (($data['Response'] ?? 'False') === 'False') {
                return [
                    'movies' => [],
                    'total'  => 0,
                    'error'  => $data['Error'] ?? 'No results found.',
                ];
            }

            return [
                'movies' => $data['Search'] ?? [],
                'total'  => (int) ($data['totalResults'] ?? 0),
                'error'  => null,
            ];
        } catch (GuzzleException $e) {
            Log::error('OMDB API request failed', [
                'query'   => $query,
                'page'    => $page,
                'message' => $e->getMessage(),
            ]);

            return [
                'movies' => [],
                'total'  => 0,
                'error'  => 'Failed to connect to movie service.',
            ];
        }
    }

    public function detail($imdbID)
    {
        try {
            $response = $this->client->get('', [
                'http_errors' => false,
                'query' => [
                    'apikey' => $this->apiKey,
                    'i'      => $imdbID,
                    'plot'   => 'full',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (($data['Response'] ?? 'False') === 'False') {
                return [
                    'movie' => null,
                    'error' => $data['Error'] ?? 'Movie not found.',
                ];
            }

            return [
                'movie' => $data,
                'error' => null,
            ];
        } catch (GuzzleException $e) {
            Log::error('OMDB API request failed', [
                'imdbID'  => $imdbID,
                'message' => $e->getMessage(),
            ]);

            return [
                'movie' => null,
                'error' => 'Failed to connect to movie service.',
            ];
        }
    }

    public function getUserFavorites(): array
    {
        $imdbIds = Favorite::where('user_id', Auth::id())
            ->pluck('imdb_id')
            ->toArray();

        if (empty($imdbIds)) {
            return [];
        }

        $movies = [];

        foreach ($imdbIds as $imdbId) {
            $result = $this->detail($imdbId);

            if ($result['error'] || !$result['movie']) {
                Log::warning('Failed to fetch favorite movie detail', [
                    'imdb_id' => $imdbId,
                    'error'   => $result['error'],
                ]);
                continue;
            }

            $movies[] = $result['movie'];
        }

        return $movies;
    }
}