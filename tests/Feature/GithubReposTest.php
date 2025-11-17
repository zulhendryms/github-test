<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GithubReposTest extends TestCase
{
    public function test_github_repos_endpoint()
    {
        Http::fake([
            'https://api.github.com/user/repos*' => Http::response([
                [
                    'id' => 1,
                    'name' => 'test-repo',
                    'html_url' => 'https://github.com/me/test-repo',
                    'owner' => ['avatar_url' => 'https://avatar.com/me.png'],
                    'created_at' => '2025-11-14T03:42:07Z'
                ]
            ], 200),
        ]);

        $response = $this->get('/api/github/repos');

        $response->assertStatus(200)
                 ->assertJson([
                     [
                         'id' => 1,
                         'name' => 'test-repo',
                         'url' => 'https://github.com/me/test-repo',
                         'owner_avatar_url' => 'https://avatar.com/me.png',
                         'created_at' => '14-11-2025 03:42:07'
                     ]
                 ]);
    }
}
