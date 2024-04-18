<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PageContent;
use App\Models\Tag;

class FindPageContentTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test finding a page content by its ID via GET request.
     *
     * @return void
     */
    public function test_can_find_page_content_by_id_via_get_request(): void
    {
        // Create a page content with associated tags using factories
        $pageContent = PageContent::factory()->create();
        $tags = Tag::factory()->count(3)->create();
        $pageContent->tags()->attach($tags);

        // Send a GET request to the API endpoint to find the page content by ID
        $response = $this->getJson(route('api.v1.page-content.show', $pageContent->id));

        // Assert that the API returns a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response contains the page content data
        $response->assertJson([
            'success' => true,
            'message' => 'Page content retrieved successfully',
            'page_content' => [
                'title' => $pageContent->title,
                'content' => $pageContent->content,
                'tags' => $tags->toArray(),
            ],
        ]);
    }
}
