<?php

namespace Tests\Feature\PageContent;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PageContent;
use App\Models\Tag;

class DeletePageContentTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test deleting a page content item along with associated tags.
     *
     * @return void
     */
    public function test_can_delete_page_content_with_associated_tags(): void
    {
        // Create a page content item with associated tags using factories
        $pageContent = PageContent::factory()->create();
        $tags = Tag::factory()->count(3)->create();
        $pageContent->tags()->attach($tags);

        // Send a DELETE request to the API endpoint to delete the page content item
        $response = $this->deleteJson(
            route("api.v1.page-content.destroy", $pageContent->id)
        );

        // Assert that the API returns a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the page content item is deleted from the database
        $this->assertDatabaseMissing("page_contents", [
            "id" => $pageContent->id,
        ]);

        // Assert that the associated tags are detached from the page content
        foreach ($tags as $tag) {
            $this->assertDatabaseMissing("page_content_tag", [
                "page_content_id" => $pageContent->id,
                "tag_id" => $tag->id,
            ]);
        }
    }
}
