<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagRepository
{
    public function getTags(Request $request)
    {
        $tagsQueryBuilder = Tag::with('records');
        if ($request->q) {
            $query = $request->q;
            $tagsQueryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder
                    ->orWhere('name', 'like' , '%'. $query . '%' )
                    ->orWhereHas('records', function($q) use ($query) {
                        $q->where('name', 'like' , '%'. $query . '%' );
                        $q->Orwhere('description', 'like' , '%'. $query . '%' );
                    });
            });
        }
        $tags = $tagsQueryBuilder->get();
        return $tags;
    }

    public function storeTag(Request $request)
    {
        $tag = Tag::create($request->validated());
        if ($records = $request->records) {
            foreach ($records as $record) {
                $tag->tags()->attach($record);
            }
        }
        return $tag;
    }

    public function updateTag(Request $request, $tag)
    {
        $tag = Tag::with('records')->findOrFail($tag);
        $tag->fill($request->validated());
        $tag->save();
        if ($records = $request->records) {
            foreach ($records as $record) {
                $tag->records->where('id', $record['id'])->first()->pivot->update(
                    [
                        'description' => $record['description'],
                    ]);
            }
        }
        return $tag;
    }
}
