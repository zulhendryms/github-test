<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function repos()
    {
        $page = request('page', 1);
        $perPage = request('per_page', 30);

        $response = Http::withHeaders([
            'Authorization' => 'token ' . env('GITHUB_TOKEN'), // works as well
            // 'Authorization' => 'bearer ' . env('GITHUB_TOKEN'),
            'Accept'        => 'application/vnd.github+json',
        ])->get('https://api.github.com/user/repos', [
            'page'     => $page,
            'per_page' => $perPage,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to fetch GitHub repos'
            ], $response->status());
        }

        $repos = collect($response->json())->map(function ($repo) {
            return [
                'id'               => $repo['id'],
                'name'             => $repo['name'],
                'url'              => $repo['html_url'],
                'owner_avatar_url' => $repo['owner']['avatar_url'] ?? null,
                'created_at'       => \Carbon\Carbon::parse($repo['created_at'])->format('d-m-Y H:i:s'),
            ];
        });

        return response()->json($repos);
        // teest github push
    }
}
