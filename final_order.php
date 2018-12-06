<?php session_start();
include "cart.html";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dba";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

$cust_id= $_SESSION['cust_id'];
$num=$_SESSION['num'];

$stmt = $conn->prepare("SELECT invoice_id,cust_id,num FROM dba.invoice where cust_id='$cust_id' and num='$num'"); 
$stmt->execute();

$row = $stmt->fetch();
$invoice_id=$row['invoice_id'];
echo "<h1 style='text-align:center;margin-top:50px;font-size:50px;'>ORDER</h1><h3 style='text-align:center;margin-top:50px;font-size:30px;'>PAYMENT CASH ON DELIVERY</h3>";
  
echo "<br/><h1 style='font-size:30px;text-align:center'> Delivery Address<br/><br/>".$_SESSION['recipient_name']."<br/>".$_SESSION['house_no'].", ".$_SESSION['area'].", ".$_SESSION['landmark'].", ".$_SESSION['city'].", ".$_SESSION['state'].", ".$_SESSION['pincode'].".</h1><br/><br/><br/>";


$stmt = $conn->prepare("SELECT Distinct * FROM dba.final_invoice_prod,product where invoice_id='$invoice_id' AND product.pro_id=final_invoice_prod.pro_id"); 
    $stmt->execute();
while(  $row = $stmt->fetch()){
$_SESSION['pro_id']= $row['pro_id'];
echo "<div style='margin-left:170px;margin-top:100px;' ><a href='#'><img src='".$row['image_name']."'width='300px' height='400px' style='margin-top:'160px;'></a></div><br/>";
echo "<br/><div style='text-align:center;'><p style='margin-top:-390px;margin-left:450px;'>".$row['pro_name']."<br/><br/>".$row['pro_desc']."<br/><br/>".$row['pro_price']."<br/><br/>".$row['stock']."<br/><br/>".$row['quantity'];
echo "</p><form action='delete_final_order.php' method='post'><input type='hidden' name='pro_id' value='".$row['pro_id']."'><input type='submit' name='delete' value='Delete' style='margin-left:900px;padding: 10px 32px;margin-top:100px'></form><div style='margin-top:-40px;'>";
echo "<form  method='post' action='wishlist_final_order.php'><input type='submit' name='wishlist' value='Wishlist' style='margin-left:30px;padding: 10px 32px;'></form></div><div style='overflow:auto;margin-top:100px'></div></div>"; 
}

echo "<a href='#' > <form action='thankyou.php' method='post'><input type='submit' name='order' value='ORDER' style='padding: 10px 35px;margin-left:600px;font-size:25px;margin-top:50px;'></form></a><div style='margin-top:130px;'></div>";
}
catch(PDOException $e) {
//header("Location:final_order.php");exit();
}
$conn = null;



include "footer.html";
?>
