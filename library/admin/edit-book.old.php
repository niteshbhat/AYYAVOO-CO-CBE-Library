<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['update']))
{
$bookname=$_POST['BookName'];
$Subject=$_POST['Subject'];
$category=$_POST['CatId'];
$Edition=$_POST['Edition'];
$Volume=$_POST['Volume'];
$author=$_POST['AuthorId'];
$isbn=$_POST['ISBNNumber'];
$price=$_POST['BookPrice'];
$year=$_POST['year'];
$ShelfNo=$_POST['ShelfNo'];
$RackNo=$_POST['RackNo'];
$bookid=intval($_GET['bookid']);
$sql="update tblbooks set BookName=:bookname,Subject=:Subject,CatId=:category,Edition=:Edition,Volume=:Volume,AuthorId=:author,ISBNNumber=:isbn,BookPrice=:price,year=:year,ShelfNo=:ShelfNo,RackNo=:RackNo where id=:bookid";
$query = $dbh->prepare($sql);
$query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
$query->bindParam(':Subject',$Subject,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':Edition',$Edition,PDO::PARAM_STR);
$query->bindParam(':Volume',$Volume,PDO::PARAM_STR);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
$query->bindParam(':Price',$price,PDO::PARAM_STR);
$query->bindParam(':year',$year,PDO::PARAM_STR);
$query->bindParam(':ShelfNo',$ShelfNo,PDO::PARAM_STR);
$query->bindParam(':RackNo',$RackNo,PDO::PARAM_STR);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
$_SESSION['msg']="Book info updated successfully";
header('location:manage-books.php');


}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>2021 AYYAVOO&CO CBE Library Management System | Edit Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Book</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$bookid=intval($_GET['bookid']);
$sql = "SELECT * FROM tblbooks where id=:bookid";
$query = $dbh -> prepare($sql);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  

<div class="form-group">
<label>Book Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookname" value="<?php echo htmlentities($result->BookName);?>" required />
</div>

<div class="form-group">
<label> Subject<span style="color:red;">*</span></label>
<select class="form-control" name="category" >
<option value="<?php echo htmlentities($result->id);?>"> <?php echo htmlentities($catname=$result->Subject);?></option>
<?php 
$status=1;
$sql1 = "SELECT * from  tblcategory where Status=:status";
$query1 = $dbh -> prepare($sql1);
$query1-> bindParam(':status',$status, PDO::PARAM_STR);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($resultss as $row)
{           
if($catname==$row->Subject)
{
continue;
}
else
{
    ?>  
<option value="<?php echo htmlentities($row->id);?>"><?php echo htmlentities($row->Subject);?></option>
 <?php }}} ?> 
</select>
</div>

<div class="form-group">
<label> Sub-Category<span style="color:red;">*</span></label>
<select class="form-control" name="category">
<option value="<?php echo htmlentities($result->id);?>"> <?php echo htmlentities($catname=$result->CategoryName);?></option>
<?php 
$status=1;
$sql1 = "SELECT * from  tblcategory where Status=:status";
$query1 = $dbh -> prepare($sql1);
$query1-> bindParam(':status',$status, PDO::PARAM_STR);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($resultss as $row)
{           
if($catname==$row->CatId)
{
continue;
}
else
{
    ?>  
<option value="<?php echo htmlentities($row->id);?>"><?php echo htmlentities($row->CategoryName);?></option>
 <?php }}} ?> 
</select>
</div>

<div class="form-group">
<label>Edition<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="Edition" value="<?php echo htmlentities($result->Edition);?>" required />
</div>

<div class="form-group">
<label>Volume<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="Volume" value="<?php echo htmlentities($result->Volume);?>" required />
</div>
<div class="form-group">
<label> Publication<span style="color:red;">*</span></label>
<select class="form-control" name="author" >
<option value="<?php echo htmlentities($result->cid);?>"> <?php echo htmlentities($athrname=$result->AuthorName);?></option>
<?php 

$sql2 = "SELECT * from  tblauthors ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);
if($query2->rowCount() > 0)
{
foreach($result2 as $ret)
{           
if($athrname==$ret->AuthorId)
{
continue;
} else{

    ?>  
<option value="<?php echo htmlentities($ret->cid);?>"><?php echo htmlentities($ret->AuthorId);?></option>
 <?php }}} ?> 
</select>
</div>

<div class="form-group">
<label>Book Unique Number<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="isbn" value="<?php echo htmlentities($result->ISBNNumber);?>"  required="required" />
<p class="help-block">Unique Number of a book</p>
</div>

<div class="form-group">
<label>Year<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="year" value="<?php echo htmlentities($result->year);?>" required />
</div>

<div class="form-group">
<label>Shelf No<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="ShelfNo" value="<?php echo htmlentities($result->ShelfNo);?>" required />
</div>

<div class="form-group">
<label>Rack No<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="RackNo" value="<?php echo htmlentities($result->RackNo);?>" required />
</div>

 <div class="form-group">
 <label>Price in INR<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="BookPrice" value="<?php echo htmlentities($result->BookPrice);?>"   required="required" />
 </div>
 <?php }} ?>
<button type="submit" name="update" class="btn btn-info">Update </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
