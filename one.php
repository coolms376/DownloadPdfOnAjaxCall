<?php
    require("vendor/autoload.php");
    $pdfString= $_REQUEST['data'];
    $location = __DIR__;
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('CCSU');
    $pdf->SetTitle('BCA Result - V Semester');
    $pdf->SetSubject('Result');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $pdf->AddPage();
    $pdf->writeHTML($pdfString,true, false, true, false, '');
    $dir = addslashes(__DIR__);
    $file = $dir."\\example_048.pdf";
    $pdf->Output($file, 'FD');
?>  