<?php
    require "../mpdf/mpdf.php";
    
    header("Content-Type: application/pdf"); 
    header("Content-Description: inline; filename.pdf");
    
    $content = json_decode($_POST["content"])->content;
    
    $mpdf=new mPDF();
    $mpdf->WriteHTML($content);
    $mpdf->Output();
    exit;
?>