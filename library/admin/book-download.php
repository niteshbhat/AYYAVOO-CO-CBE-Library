<?php
//include database configuration file
session_start();
error_reporting(0);
include('includes/config.php');

//get records from database
$query = "SELECT * from  tblbooks";
$query1 = $dbh -> prepare($query);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);

if($query1->rowCount() > 0)
{
    $delimiter = ",";
    $filename = "users_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('id', 'BookName', 'Subject', 'CatId', 'Edition', 'Volume','AuthorId','ISBNNumber','BookPrice','year','ShelfNo','RackNo');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    foreach($resultss as $row){
         $lineData = array($row->id,$row->BookName,$row->Subject,$row->CatId,$row->Edition,$row->Volume,$row->AuthorId,$row->ISBNNumber,$row->BookPrice,$row->year,$row->ShelfNo,$row->RackNo);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>