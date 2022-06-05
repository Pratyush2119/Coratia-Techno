<?php
require 'vendor/autoload.php';
include('db_connection.php');

if($_FILES["fileupl"]["name"]!='') {
    $allowExt=array('xls','csv','xlsx');
    $fileArr=explode(".",$_FILES["fileupl"]["name"]);
    $fileExt=end($fileArr);
    $sourcefile=$_FILES["fileupl"]["tmp_name"];
    if(in_array($fileExt,$allowExt)) {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($sourcefile);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach($data as $row) {
            if ($row[0]!='' || $row[1]!='' || $row[2]!='') {
                $sql="INSERT INTO sampletab (A,B,C) VALUES ('$row[0]','$row[1]','$row[2]')";
                $conn->query($sql);
            }
        }
        $msg = "<div class='col-12 p-2' style='background-color: rgb(217, 228, 217);color: green;margin-top:-5px;border-radius:2px;boder:1px solid green;'>Data Uploaded Successfully.</div>";
    }
    else {
        $msg = "<div class='col-12 p-2' style='background-color: rgb(250, 201, 201);color: red;margin-top:-5px;border-radius:2px;boder:1px solid red;'>Only files with extension '.xls', '.xlsx' and '.csv' are allowed.</div>";
    }
}
else {
    $msg = "<div class='col-12 p-2' style='background-color: rgb(250, 201, 201);color: red;margin-top:-5px;border-radius:2px;boder:1px solid red;'>Please Select File.</div>";
}

echo $msg;
?>