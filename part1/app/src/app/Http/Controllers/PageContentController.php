<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\Tag;

class PageContentController extends Controller
{
    /**
     * Display a listing of the page content.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        // Retrieve all page content items or filter by title if provided
        $query = PageContent::query();

        if ($request->has("title")) {
            $query->where("title", "like", "%" . $request->title . "%");
        }

        $pageContents = $query->get();

        // Optionally, you can return a JSON response with the page content data
        return response()->json(
            [
                "success" => true,
                "message" => "Page content retrieved successfully",
                "page_contents" => $pageContents,
            ],
            200
        );
    }

    /**
     * Display the specified page content.
     *
     * @param  \App\Models\PageContent  $pageContent
     * @return \Illuminate\Http\Response
     */
    public function show(PageContent $pageContent): JsonResponse
    {
        // Eager load the 'tags' relation
        $pageContent->load('tags');

        // Optionally, you can return a JSON response with the page content data
        return response()->json([
            'success' => true,
            'message' => 'Page content retrieved successfully',
            'page_content' => $pageContent,
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string",
            "tags" => "required|array",
            "tags.*" => "exists:tags,id", // Ensure all tag IDs exist in the tags table
        ]);

        // Create a new PageContent instance with the validated data
        $pageContent = PageContent::create([
            "title" => $validatedData["title"],
            "content" => $validatedData["content"],
        ]);

        // Attach tags to the page content
        $pageContent->tags()->attach($validatedData["tags"]);

        // Optionally, you can return a response indicating success
        return response()->json(
            [
                "success" => true,
                "message" => "Page content created successfully",
                "page_content" => $pageContent,
            ],
            201
        );
    }

    /**
     * Update the specified page content in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PageContent  $pageContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageContent $pageContent): JsonResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string",
            "tags" => "nullable|array",
            "tags.*" => "exists:tags,id", // Ensure all tag IDs exist in the tags table
        ]);

        // Update the page content with the validated data
        $pageContent->update([
            "title" => $validatedData["title"],
            "content" => $validatedData["content"],
            // Add more fields to update as needed
        ]);

        // Update tags associated with the page content
        if (isset($validatedData["tags"])) {
            $pageContent->tags()->sync($validatedData["tags"]);
        }

        // Optionally, you can return a response indicating success
        return response()->json(
            [
                "success" => true,
                "message" => "Page content updated successfully",
                "page_content" => $pageContent,
            ],
            200
        );
    }

    public function remove(PageContent $pageContent)
    {
    }
}
