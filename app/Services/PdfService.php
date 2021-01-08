<?php
/**
 * Created by Ahmed Maher Halima.
 * Email: phpcodertop@gmail.com
 * github: https://github.com/phpcodertop
 * Date: 1/8/2021
 * Time: 3:10 AM
 */

namespace App\Services;


use App\Models\Upload;
use Smalot\PdfParser\Parser;

class PdfService {

    public function isPdf($file)
    {
        if ($file->getClientOriginalExtension() != 'pdf') return false;
        return true;
    }

    public function searchFor(String $text, $file)
    {
        $parser = new Parser();
        $pdf    = $parser->parseFile($file);
        $pdfText = $pdf->getText();
        if (strpos($pdfText, $text) === false) return false;
        return true;
    }

    public function existsOrCreate($file)
    {
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $dbRecordExists = Upload::whereName($fileName)
            ->whereSize($fileSize)->first();
        if (! $dbRecordExists) { // file don't exist on db
            // upload file to uploads
            // upload thumbnail and slider images
            $file->move(public_path('uploads/pdfs'), $fileName);

            Upload::create([
                'name' => $fileName,
                'size' => $fileSize,
            ]);
            return false;
        }
        // file exists on db
        $dbRecordExists->touch(); // update only updated_at field
        return true;
    }
}
