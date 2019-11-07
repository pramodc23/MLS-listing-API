<?php



echo $random=check_order_no();
echo "<br>";
function check_order_no(){
	$conn = mysqli_connect("localhost","root","","vmwebhun_topsworkwear_new");
	$order_id=rand('1','25');
	echo $order_id."count  <br>";
	$qry=mysqli_query($conn,"SELECT id FROM orders where id =".$order_id."");

	if(mysqli_num_rows($qry) ==1 ){
		check_order_no();
	}else{
		return $order_id;
	}


}


?>