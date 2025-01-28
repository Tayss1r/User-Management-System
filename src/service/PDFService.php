<?php

namespace App\service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    private $domPDF;

    public function __construct()
    {
        $this->domPDF = new Dompdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPDF->setOptions($pdfOptions);
    }

    public function showPDFFile($html)
    {
        $this->domPDF->loadHtml($html);
        $this->domPDF->render();
        $this->domPDF->stream('details.pdf', [
            'Attachement' =>false
        ]);
    }

    public function generateBinaryPDF($html)
    {
        $this->domPDF->loadHtml($html);
        $this->domPDF->render();
        $this->domPDF->output();
    }
}