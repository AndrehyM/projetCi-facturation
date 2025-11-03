<?php
use Dompdf\Dompdf;

class Pdf {
    public function create($html, $filename = 'document') {
        require_once(APPPATH . 'third_party/dompdf/autoload.inc.php');
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename . '.pdf', array("Attachment" => true));
    }
}
