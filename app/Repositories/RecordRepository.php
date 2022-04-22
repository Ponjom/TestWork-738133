<?php

namespace App\Repositories;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordRepository
{
    public function getRecords(Request $request)
    {
        $recordsQueryBuilder = Record::with('tags');
        if ($request->q) {
            $query = $request->q;
            $recordsQueryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder
                    ->orWhere('name', 'like' , '%'. $query . '%' )
                    ->orWhereHas('tags', function($q) use ($query) {
                        $q->where('name', 'like' , '%'. $query . '%' );
                        $q->Orwhere('description', 'like' , '%'. $query . '%' );
                    });
            });
        }
        $records = $recordsQueryBuilder->get();
        return $records;
    }

    public function storeRecord(Request $request)
    {
        $record = Record::create($request->validated());
        if ($tags = $request->tags) {
            foreach ($tags as $tag) {
                $record->tags()->attach($tag);
            }
        }
        return $record;
    }

    public function updateRecord(Request $request, $record)
    {
        $record = Record::with('tags')->findOrFail($record);
        $record->fill($request->validated());
        $record->save();
        if ($tags = $request->tags) {
            foreach ($tags as $tag) {
                $record->tags->where('id', $tag['id'])->first()->pivot->update(
                    [
                        'description' => $tag['description'],
                    ]);
            }
        }
        return $record;
    }
}
