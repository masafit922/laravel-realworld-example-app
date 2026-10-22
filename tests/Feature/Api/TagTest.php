<?php

namespace Tests\Feature\Api;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    #[Test]
    public function it_returns_an_array_of_tags()
    {
        $tags = \App\Tag::factory()->count(5)->create();

        $response = $this->getJson('/api/tags');

        $response->assertStatus(200)
            ->assertJson([
                'tags' => $tags->pluck('name')->toArray()
            ]);
    }

    #[Test]
    public function it_returns_an_empty_array_of_tags_when_there_are_none_in_database()
    {
        $response = $this->getJson('/api/tags');

        $response->assertStatus(200)
            ->assertJson([
                'tags' => []
            ]);

        $this->assertEmpty($response->json()['tags'], 'Expected empty tags array');
    }
}
