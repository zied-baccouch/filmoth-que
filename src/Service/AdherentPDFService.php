<?php


namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class AdherentPDFService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new Dompdf();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $this->domPdf->setOptions($pdfOptions);
    }

    public function generatePDF($html, $filename)
{
    $this->domPdf->loadHtml($html);
    $this->domPdf->render();
    $output = $this->domPdf->output();
    $pdfFilePath = 'pdf/'.$filename;
    file_put_contents($pdfFilePath, $output);
    
    return $pdfFilePath; // Retourne le chemin complet du fichier PDF
}
}