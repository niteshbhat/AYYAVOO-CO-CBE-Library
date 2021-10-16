<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!=''){
$_SESSION['login']='';
}
if(isset($_POST['login']))
{
  //code for captach verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    } 
        else {
$email=$_POST['emailid'];
$password=md5($_POST['password']);
$sql ="SELECT EmailId,Password,StudentId,Status FROM tblstudents WHERE EmailId=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
 foreach ($results as $result) {
 $_SESSION['stdid']=$result->StudentId;
if($result->Status==1)
{
$_SESSION['login']=$_POST['emailid'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else {
echo "<script>alert('Your Account Has been blocked .Please contact admin');</script>";

}
}

} 

else{
echo "<script>alert('Invalid Details');</script>";
}
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>2021 AYYAVOO&CO CBE Library Management System </title>
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
     
<?php include('includes/header.php');?>
<br />
<br />
<br />
<div class="col-md-3"></div>
<div class="col-md-6 well">
		<h3 class="text-primary">AYYAVOO&CO CBE Library Management System</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<form class="form-inline" method="POST" action="index.php">
				<div class="input-group col-md-12">
					<br />
					<input type="text" class="form-control" placeholder="Search Book Name Here..." name="keyword" required="required" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>"/>
					<span class="input-group-btn"><br />
						<button class="btn btn-primary" name="search"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
				</form>
			<br />
			<br />
			<?php
				if(ISSET($_POST['search'])){
					$keyword = $_POST['keyword'];
			?>
			<div>
			<?php 
				$sql6 ="SELECT * FROM `tblbooks` WHERE `BookName` LIKE '%$keyword%' ORDER BY `Volume`";
				$query5 = $dbh -> prepare($sql6);
				$query5->execute();
				$results5=$query5->fetchAll(PDO::FETCH_OBJ);
				$listdcats=$query5->rowCount();
				?>

                <h3>Result : <?php echo htmlentities($listdcats);?> </h3>
                           
				<?php
					require 'config.php';
					$query = mysqli_query($conn, "SELECT * FROM `tblbooks` WHERE `BookName` LIKE '%$keyword%' ORDER BY `Volume`") or die(mysqli_error());
					while($fetch = mysqli_fetch_array($query)){
				?>
				<hr style="border-top:3px dotted #FA8072;"/>
				<div style="word-wrap:break-word;">
					<p><h4>Author Name : <?php echo $fetch['AuthorId']?> | Book Name : <?php echo $fetch['BookName']?></h4></p>
					<p><h4>Subject : <?php echo $fetch['Subject']?> | Edition : <?php echo $fetch['Edition']?> | Volume : <?php echo $fetch['Volume']?></h4></p>
					<p><h4>ShelfNo : <?php echo $fetch['ShelfNo']?></h4></p>
					<p><h4>RackNo : <?php echo $fetch['RackNo']?></h4></p>
					
				</div>
				<hr style="border-bottom:3px dotted #FA8072;"/>
				<?php
					}
				?>
			</div>
			<?php
				}
			?>
	
</div>
			
			

      <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>

</html>
