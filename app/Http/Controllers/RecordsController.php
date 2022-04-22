<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordCreateRequest;
use App\Http\Requests\RecordUpdateRequest;
use App\Models\Record;
use App\Repositories\RecordRepository;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    private $recordRepository;

    public function __construct(RecordRepository $recordRepository)
    {
        $this->recordRepository = $recordRepository;
    }

    public function index(Request $request)
    {
        $records = $this->recordRepository->getRecords($request);
        return response()->json([
            'data' => $records,
        ]);
    }

    public function store(RecordCreateRequest $request)
    {
        $record = $this->recordRepository->storeRecord($request);
        return $record;
    }

    public function show($record)
    {
        $record = Record::find($record);
        if ($record) {
            return $record;
        }
        return response()->json([
            'type' => 'Error',
            'Message' => 'Record not found!',
        ], 404);
    }

    public function update(RecordUpdateRequest $request, $record)
    {
        $record = $this->recordRepository->updateRecord($request, $record);
        return $record;
    }

    public function destroy($record)
    {
        $record = Record::find($record);
        if ($record) {
            $record->delete();
            return response()->json([
                'type' => 'Success',
                'Message' => 'Record successfully deleted!',
            ]);
        }
        return response()->json([
            'type' => 'Error',
            'Message' => 'Record not found!',
        ], 404);
    }
}
