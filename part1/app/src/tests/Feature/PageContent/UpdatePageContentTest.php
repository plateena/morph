<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PageContent;
use App\Models\Tag;

class UpdatePageContentTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test editing a page content via PUT request.
     *
     * @return void
     */
    public function test_can_edit_page_content_via_put_request(): void
    {
        // Create a page content using the PageContent factory
        $pageContent = PageContent::factory()->create();

        // Create some tags associated with the page content
        $tags = Tag::factory()->count(3)->create();
        $pageContent->tags()->attach($tags);

        // Define the updated page content data
        $updatedData = [
            "title" => "Updated Title",
            "content" => "Updated Content",
            "tags" => $tags->pluck("id")->toArray(), // Pass the same tags as before
        ];

        // Send a PUT request to the API endpoint to update the page content
        $response = $this->putJson(
            route("api.v1.page-content.update", $pageContent->id),
            $updatedData
        );

        // Assert that the API returns a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response contains the updated page content data
        $response->assertJson([
            "success" => true,
            "message" => "Page content updated successfully",
            "page_content" => [
                "title" => $updatedData["title"],
                "content" => $updatedData["content"],
            ],
        ]);

        // Assert that the page content is updated in the database
        $this->assertDatabaseHas("page_contents", [
            "id" => $pageContent->id,
            "title" => $updatedData["title"],
            "content" => $updatedData["content"],
        ]);

        // Assert that the tags associated with the page content are updated correctly
        $this->assertEquals(
            $tags->pluck("id")->sort()->toArray(), // Sort for consistent comparison
            $pageContent->fresh()->tags->pluck("id")->sort()->toArray()
        );
    }
}
