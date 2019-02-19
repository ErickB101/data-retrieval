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
$inpcustnum = isset($_POST['inpcustnum']) ? $_POST['inpcustnum'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$inpmsg = '';


 
	
if (!($inpcustnum )) {
  if ($visited) {	  
     $inpmsg = 'Please enter a customer number value';
  }

 
  
   print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 <font color= 'red'>$inpmsg</font><br>
 Customer Number: <input type="text" name="inpcustnum" size="9" value="$inpcustnum">
 <br/>
 <br>
 <INPUT type="submit" value="Submit">
 <INPUT type="hidden" name="visited" value="true">
 </FORM>
_HTML_;


}


//Code for Question 1 Part a

else {
						
  $querystring1 = "SELECT CustomerName, RepNum, CustomerNum
				  FROM Customer
				  WHERE CustomerNum = $inpcustnum";
						
						      						      										 				  						 			

  $result = mysqli_query($con, $querystring1);
  if (!$result) {
    print ( "Could not successfully run query ($querystring1) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }
  
  if (mysqli_num_rows($result) == 0) {
    print ("Run: <br>
	        No Customer found for customer number $inpcustnum <br>");
    exit;
  }
 
  if ($obj = mysqli_fetch_object($result)) {
	  
	$custname = $obj->CustomerName;
	$repnum = $obj->RepNum;
	$custnum = $obj->CustomerNum;
	
	
	print ("Run: <br>
	        Q1 output for customer number: $inpcustnum <br>
	        Customer name: $custname <br>");
		
	//Code for Question 1 part b
	
    function query_two($repnum, $custnum) {
		
		global $con;
		
		
		$querystring2 = "SELECT FirstName, LastName
				         FROM Rep
				         WHERE RepNum = $repnum";
				  
				  
		$result = mysqli_query($con, $querystring2);
        if (!$result) {
        print ( "Could not successfully run query ($querystring2) from DB: " . mysqli_error($con) . "<br>");
        exit;
        }
 
        
        if ($obj = mysqli_fetch_object($result)) {
	  
	    $firstname = $obj->FirstName;
	    $lastname = $obj->LastName;
	
	
	        print ("Rep's Name: $firstname $lastname<br>");
		
		    //Code for Question 1 part c
		
			function query_three($custnum) {
				
				global $con;
			
               $querystring3 = "SELECT Distinct COUNT(OrderNum) AS NumberOfOrders
							    FROM Orders
								WHERE CustomerNum = $custnum";
										
			    $result = mysqli_query($con, $querystring3);
                if (!$result) {
                print ( "Could not successfully run query ($querystring3) from DB: " . mysqli_error($con) . "<br>");
                exit;
                }
  
 
               
                if ($obj = mysqli_fetch_object($result)) { 	
				
				$numberoforders = $obj->NumberOfOrders;
				print ("Total number of orders: $numberoforders <br>");	
			}
			
			
			
        }

		query_three($custnum);
		
	  }	
	  
	    

    }	

		
		
		query_two($repnum, $custnum);
		
		 
		
  }
  
     mysqli_close($con);
}
  
  
  
  
 


?>