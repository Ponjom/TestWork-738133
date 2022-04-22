<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request)
    {
        $tags = $this->tagRepository->getTags($request);
        return response()->json([
            'data' => $tags,
        ]);
    }

    public function store(TagCreateRequest $request)
    {
        $tag = $this->tagRepository->storeTag($request);
        return $tag;
    }

    public function show($tag)
    {
        $tag = Tag::with('records')->find($tag);
        if ($tag) {
            return $tag;
        }
        return response()->json([
            'type' => 'Error',
            'Message' => 'Tag not found!',
        ], 404);
    }

    public function update(TagUpdateRequest $request, $tag)
    {
        $tag = $this->tagRepository->updateTag($request, $tag);
        return $tag;
    }

    public function destroy($tag)
    {
        $tag = Tag::find($tag);
        if ($tag) {
            $tag->delete();
            return response()->json([
                'type' => 'Success',
                'Message' => 'Tag successfully deleted!',
            ]);
        }
        return response()->json([
            'type' => 'Error',
            'Message' => 'Tag not found!',
        ], 404);
    }
}
