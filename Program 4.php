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
$inprepnum = isset($_POST['inprepnum']) ? $_POST['inprepnum'] : '';
$visited = isset($_POST['visited']) ? $_POST['visited'] : '';
$inpmsg = '';


 
	
if (!($inprepnum )) {
  if ($visited) {	  
     $inpmsg = 'Please enter a rep number value';
  }

 
  
   print <<<_HTML_
 <FORM method="POST" action="{$_SERVER['PHP_SELF']}">
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 <font color= 'red'>$inpmsg</font><br>
 Rep Number: <input type="text" name="inprepnum" size="9" value="$inprepnum">
 <br/>
 <br>
 <INPUT type="submit" value="Submit">
 <INPUT type="hidden" name="visited" value="true">
 </FORM>
_HTML_;


}


//Code for Question 4 part a

else {
						
  $querystring1 = "SELECT FirstName, LastName
				  FROM Rep
				  WHERE RepNum = $inprepnum";
						
						      						      										 				  						 			

  $result = mysqli_query($con, $querystring1);
  if (!$result) {
    print ( "Could not successfully run query ($querystring1) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }
  
  if (mysqli_num_rows($result) == 0) {
    print ("Run: <br>
	        No rep is found for rep number $inprepnum <br>");
    exit;
  }
 
   
  if ($obj = mysqli_fetch_object($result)) {
	  

	$firstname = $obj->FirstName;
	$lastname = $obj->LastName;
	
	print ("Run: <br>
	        Q4 output for rep number: $inprepnum <br>
			Rep's name: $firstname $lastname <br>");
		
	//Code for Question 4 part b
	
    function query_two($inprepnum) {
		
		global $con;
		
		
		$querystring2 = "SELECT CustomerName, CustomerNum
				         FROM Customer
				         WHERE RepNum = $inprepnum";
				  
				  
		$result = mysqli_query($con, $querystring2);
        if (!$result) {
        print ( "Could not successfully run query ($querystring2) from DB: " . mysqli_error($con) . "<br>");
        exit;
        }	
		     
		    //Code for Question 4 part c
		
			function query_three($custnum) {
				
				global $con;
			
               $querystring3 = "SELECT SUM(QuotedPrice * NumOrdered) AS TotalPrice
							    FROM (SELECT OrderNum
								      FROM Orders
									  WHERE CustomerNum = $custnum) AS L
									  JOIN
									 (SELECT OrderNum, QuotedPrice, NumOrdered
                                      FROM OrderLine) AS R
							    ON L.OrderNum = R.OrderNum";
							
                               	
										
			    $result = mysqli_query($con, $querystring3);
                if (!$result) {
                print ( "Could not successfully run query ($querystring3) from DB: " . mysqli_error($con) . "<br>");
                exit;
                }
 
                
                if ($obj = mysqli_fetch_object($result)) { 	
				
			    $priceholder = $obj->TotalPrice;
				
				
				RETURN $priceholder;
				
							
			}	
			
          }
		print ("Customers: <br>");
		$totalprice = 0;
        while ($obj = mysqli_fetch_object($result)) {
	  
	      $custname = $obj->CustomerName;
		  $custnum = $obj->CustomerNum;
		
		  $totalprice += query_three($custnum);
       
		
		  print ("&nbsp &nbsp &nbsp &nbsp $custname <br>");
      
	  }	
	  
	    print ("Total revenue: $$totalprice");
	     
		
	     
	    

    }	
		
		query_two($inprepnum);
		
 	
  }
       mysqli_close($con);
}     

  

?>
