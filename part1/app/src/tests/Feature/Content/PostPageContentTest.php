<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PageContent;
use App\Models\Tag;

class PostPageContentTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test posting a page content via POST request.
     *
     * @return void
     */
    public function test_can_post_page_content_via_post_request(): void
    {
        // Create tags using the Tags factory
        $tags = Tag::factory()->count(10)->create();

        // Select a few tags to add to the page content data
        $selectedTags = $tags->random(3)->pluck("id");

        // Create a page content with selected tags using the PageContent factory
        $pageContent = PageContent::factory()->make();
        $pageContentData = [
            "title" => $pageContent->title,
            "content" => $pageContent->content,
            "tags" => $selectedTags,
        ];

        // Send a POST request to the API endpoint to add the page content
        $response = $this->postJson(
            route("api.v1.page-content.create"),
            $pageContentData
        );

        // Assert that the API returns a 201 (Created) status code
        $response->assertStatus(201);

        // Assert that the response contains the created page content data
        $response->assertJson([
            "success" => true,
            "message" => "Page content created successfully",
        ]);

        // Assert that the page content is created in the database
        $this->assertDatabaseHas("page_contents", [
            "title" => $pageContent->title,
            "content" => $pageContent->content,
        ]);

        // Assert that the selected tags are attached to the page content in the database
        $createdPageContent = PageContent::where(
            "title",
            $pageContent->title
        )->first();
        $this->assertEquals(
            $selectedTags->toArray(),
            $createdPageContent->tags->pluck("id")->toArray()
        );
    }
}
