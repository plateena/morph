<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\Tag;

class PageContentController extends Controller
{
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
}
