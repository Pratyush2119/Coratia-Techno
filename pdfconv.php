<?php
include('db_connection.php');

if (isset($_POST['submit'])) {
    ob_start();
    require('fpdf.php');
    $pdf = new FPDF();
    $pdf -> AddPage();
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(0,10,'User Selected Data',0,1,'C');
    $pdf->Cell(0,10,'',0,1);
    $width_cell=array(25,55,55,55);
    $pdf->SetFont('Arial','B',16);
    $pdf->SetFillColor(193,229,252);
    $pdf->Cell($width_cell[0],10,'SL No',1,0,'C',true);
    $pdf->Cell($width_cell[1],10,'A',1,0,'C',true);
    $pdf->Cell($width_cell[2],10,'B',1,0,'C',true);
    $pdf->Cell($width_cell[3],10,'C',1,1,'C',true);
    $pdf->SetFont('Arial','',14);
    $pdf->SetFillColor(235,236,236);
    $fill=false;
    $choices=$_POST['choices'];
    $count=1;
    foreach($choices as $value) {
        $sql="SELECT * FROM sampletab WHERE rid='".$value."'";
        $result=$conn->query($sql);
        $row = $result->fetch_assoc();
        $pdf->Cell($width_cell[0],10,$count,1,0,'C',$fill);
        if ($row['A']!='') {
            $pdf->Cell($width_cell[1],10,$row['A'],1,0,'C',$fill);
        }
        else {
            $pdf->Cell($width_cell[1],10,'-',1,0,'C',$fill);
        }
        if ($row['B']!='') {
            $pdf->Cell($width_cell[2],10,$row['B'],1,0,'C',$fill);
        }
        else {
            $pdf->Cell($width_cell[2],10,'-',1,0,'C',$fill);
        }
        if ($row['C']!='') {
            $pdf->Cell($width_cell[3],10,$row['C'],1,1,'C',$fill);
        }
        else {
            $pdf->Cell($width_cell[3],10,'-',1,1,'C',$fill);
        }
        $count = $count + 1;
    }
    $pdf->Output('D','userdata.pdf');
    ob_end_flush();
}
?>