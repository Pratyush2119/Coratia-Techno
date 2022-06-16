<?php
include("db_connection.php");
require 'vendor/autoload.php';

if (isset($_POST["login"])) {
    $uname = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$uname' AND pass='$pass'";
    $result=$conn->query($sql);
    $rcnt=mysqli_num_rows($result);
    if ($rcnt>0) {
        session_start();
        $_SESSION['username']=$uname;
        header("Location: dashboard.php");
    }
    else {
        header("Location: index.html");
    }
}
else if (isset($_POST["newproj"])) {
    $pname = $_POST['pname'];
    $creater = $_POST['creater'];
    $sql = "INSERT INTO projects (pname,creater) VALUES ('$pname','$creater')";
    $conn->query($sql);
    header("location: article.php");
}
else if (isset($_POST["delete"])) {
    $choices=$_POST['choices'];
    foreach($choices as $value) {
        $sql="DELETE FROM projects WHERE pid='".$value."'";
        $conn->query($sql);
    }
    header("Location: dashboard.php");
}
else if (isset($_POST["saveArticle"])) {
    $uname = $_GET['uname'];
    $data = array();
    $list = explode(";",$_POST["list"]);
    foreach ($list as $key) {
        if (array_key_exists($key,$_POST)) {
            $data[$key]=$_POST[$key];
        }
        if (array_key_exists($key,$_FILES)) {
            $fileExt=array('xls','csv','xlsx');
            $imgExt=array('png','jpg','jpeg');
            $arr=explode(".",$_FILES[$key]["name"]);
            $Ext=end($arr);
            if (in_array($Ext, $imgExt)) {
                $img_dir="uploads/images/";
                $imgfile=$_FILES[$key]["name"];
                $imgloc=$_FILES[$key]["tmp_name"];
                $imgstore=$img_dir.$imgfile;
                move_uploaded_file($imgloc,$imgstore);
                $data[$key]=$imgstore;
            }
            if (in_array($Ext, $fileExt)) {
                $file_dir="uploads/files/";
                $file=$_FILES[$key]["name"];
                $fileloc=$_FILES[$key]["tmp_name"];
                $filestore=$file_dir.$file;
                move_uploaded_file($fileloc,$filestore);
                $data[$key]=$filestore;
            }
        }
    }
    $jsondata = json_encode($data, JSON_PRETTY_PRINT);
    $sql = "UPDATE projects SET data='$jsondata' WHERE creater='$uname'";
    $conn->query($sql);
    header("Location: dashboard.php");
}
else if (isset($_GET['proj'])) {
    error_reporting(E_ERROR | E_PARSE);
    $proj=$_GET['proj'];
    $sql="SELECT * FROM projects WHERE pname='$proj'";
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $data=json_decode($row['data'],true);
    ob_start();
    require('fpdf.php');
    $pdf = new FPDF();
    $pdf -> AddPage();
    foreach ($data as $k=>$v) {
        if ($k == 'title') {
            $pdf->SetFont('Arial','B',20);
            $pdf->Cell(0,10,$v,0,1,'C');
        }
        else if ($k == 'subtitle') {
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(0,10,$v,0,1,'C');
            $pdf->Cell(0,10,'',0,1);
        }
        else if (str_contains($k,'headingid')) {
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(10,10,$v,0,0,'L');
        }
        else if (str_contains($k,'heading')) {
            $pdf->Cell(0,10,$v,0,1,'L');
        }
        else if (str_contains($k, 'sec') && str_contains($k,'para')) {
            $pdf->SetFont('Arial','',12);
            $pdf->Write(5,$v);
            $pdf->Cell(0,10,'',0,1);
        }
        else if (str_contains($k, 'sec') && str_contains($k,'img')) {
            $pdf->Cell(0,100, $pdf->Image($v, $pdf->GetX(), $pdf->GetY(),180,100), 0, 1, 'C', false );
            $pdf->Cell(0,5,'',0,1);
        }
        else if (str_contains($k, 'sec') && str_contains($k,'file')) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($v);
            $worksheet = $spreadsheet->getActiveSheet()->toArray();
            $rcnt=count($worksheet[0]);
            foreach($worksheet as $row) {
                $arr = array_count_values($row);
                if (!empty($arr)) {
                    $count=1;
                    foreach($row as $k=>$v) {
                        if($count!=$rcnt) {
                            if ($v == '') {
                                $pdf->Cell((($pdf->GetPageWidth())/$rcnt)-($rcnt*2),10,'-',1,0,'C');
                                $count = $count + 1;
                            }
                            else {
                                $pdf->Cell((($pdf->GetPageWidth())/$rcnt)-($rcnt*2),10,$v,1,0,'C');
                                $count = $count + 1;
                            }
                        }
                        else {
                            if ($v == '') {
                                $pdf->Cell((($pdf->GetPageWidth())/$rcnt)-($rcnt*2),10,'-',1,1,'C');
                            }
                            else {
                                $pdf->Cell((($pdf->GetPageWidth())/$rcnt)-($rcnt*2),10,$v,1,1,'C');
                            }
                        }
                    }
                }
            }
            $pdf->Cell(0,5,'',0,1);
        }
    }
    $pdf->Output('D','userdata.pdf');
    ob_end_flush();
}
else {
    session_start();
    session_unset();
    session_destroy();
    header("location: index.html");
}
?>