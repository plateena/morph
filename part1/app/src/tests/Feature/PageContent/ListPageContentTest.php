<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PageContent;

class ListPageContentTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test listing page content via GET request.
     *
     * @return void
     */
    public function test_can_list_page_content_via_get_request(): void
    {
        // Create some page content using the PageContent factory
        $pageContentCount = 5;
        PageContent::factory($pageContentCount)->create();

        // Send a GET request to the API endpoint to list page content
        $response = $this->getJson(route("api.v1.page-content.index"));

        // Assert that the API returns a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response contains the expected number of page content items
        $response->assertJsonCount($pageContentCount, "page_contents");

        // Assert that the response contains the page content data
        $response->assertJsonStructure([
            "success",
            "message",
            "page_contents" => [
                "*" => [
                    "id",
                    "title",
                    "content",
                ],
            ],
        ]);
    }
}
