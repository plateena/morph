<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\Tag;

class PageContentController extends Controller
{
    public function index(Request $request)
    {
    }

    public function find(PageContent $pageContent)
    {
    }

    public function create(Request $request)
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
    public function update(Request $request, PageContent $pageContent)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id', // Ensure all tag IDs exist in the tags table
            // Add more validation rules as needed
        ]);

        // Update the page content with the validated data
        $pageContent->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            // Add more fields to update as needed
        ]);

        // Update tags associated with the page content
        if (isset($validatedData['tags'])) {
            $pageContent->tags()->sync($validatedData['tags']);
        }

        // Optionally, you can return a response indicating success
        return response()->json([
            'success' => true,
            'message' => 'Page content updated successfully',
            'page_content' => $pageContent,
        ], 200);
    }

    public function remove(PageContent $pageContent)
    {
    }
}
