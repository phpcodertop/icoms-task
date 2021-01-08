<?php

namespace App\Http\Controllers;

use App\Services\PdfService;
use Illuminate\Http\Request;

class PdfTaskController extends Controller
{
    public $pdfService;

    public function __construct(PdfService $service)
    {
        $this->pdfService = $service;
    }

    public function process(Request $request)
    {
        $file = $request->file('file');
        if (! $this->pdfService->isPdf($file))
        {
            return response()->json(['error' => 'File must be a pdf.'], 422);
        }

        if (! $this->pdfService->searchFor('Proposal', $file))
        {
            return response()->json(['error' => 'File must contain Proposal Word.'], 422);
        }

        if ($this->pdfService->existsOrCreate($file))
        {
            return response()->json(['message' => 'File updated successfully.'], 200);
        }
        return response()->json(['message' => 'File created successfully.'], 201);
    }
}
