<?php
$host = "localhost";
  $user="root";
  $password="";
  $dbname = "premiere";
  $con=mysqli_connect($host, $user, $password, $dbname);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MariaDB: " . mysqli_connect_error();
    exit;
  }
  
print ("<br>");
$inpordernum = isset($_POST['inpordernum']) ? $_POST['inpordernum'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$inpmsg = '';



 
	
if (!($inpordernum )) {
  if ($visited) {	  
     $inpmsg = 'Please enter an order number value';
  }

 
  
   print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 <font color= 'red'>$inpmsg</font><br>
 Order Number: <input type="text" name="inpordernum" size="9" value="$inpordernum">
 <br/>
 <br>
 <INPUT type="submit" value="Submit">
 <INPUT type="hidden" name="visited" value="true">
 </FORM>
_HTML_;


}

//Code for Question 3 Part a

else {
										
  $querystring1 = "SELECT CustomerName
                   FROM (SELECT CustomerName, CustomerNum
				         FROM Customer) AS L
						 JOIN
                        (SELECT CustomerNum
				         FROM Orders
				         WHERE OrderNum = $inpordernum) AS R
				   ON L.CustomerNum = R.CustomerNum";
					
						      						      										 				  						 			

  $result = mysqli_query($con, $querystring1);
  if (!$result) {
    print ( "Could not successfully run query ($querystring1) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }
  
  if (mysqli_num_rows($result) == 0) {
    print ("Run: <br>
	        No customer is found for order number $inpordernum <br>");
    exit;
  }
 
   
  if ($obj = mysqli_fetch_object($result)) {
	  
  
	$custname = $obj->CustomerName;
	
	print ("Run: <br>
	        Q3 output for order number: $inpordernum <br>
			Customer name: $custname <br>");
		
	//Code for Question 3 Part b
	
    function query_two($inpordernum) {
		
		global $con;
		
		
		$querystring2 = "SELECT COUNT(OrderNum) AS NumOfItems
				         FROM OrderLine
				         WHERE OrderNum = $inpordernum";
				  
				  
		$result = mysqli_query($con, $querystring2);
        if (!$result) {
        print ( "Could not successfully run query ($querystring2) from DB: " . mysqli_error($con) . "<br>");
        exit;
        }
		
        
        if ($obj = mysqli_fetch_object($result)) {
	  
	    $numofitems = $obj->NumOfItems;
		
		print ("Number of order line items: $numofitems <br>");
	 
		
		    //Code for Question 3 Part c
			
			function query_three($inpordernum) {
				
				global $con;
			
               $querystring3 = "SELECT SUM(QuotedPrice * NumOrdered) AS TotalPrice
				                FROM OrderLine
				                WHERE OrderNum = $inpordernum";
										
			    $result = mysqli_query($con, $querystring3);
                if (!$result) {
                print ( "Could not successfully run query ($querystring3) from DB: " . mysqli_error($con) . "<br>");
                exit;
                }
 
                
                if ($obj = mysqli_fetch_object($result)) { 	
				
				$totalprice = $obj->TotalPrice;
				print ("Total bill value: $$totalprice");
				
			}
			
				
			
        }
		
		query_three($inpordernum);

	  }	
	  
	    

    }	
		
		query_two($inpordernum);
		 	
  }
  
     mysqli_close($con);
}
  

?>
