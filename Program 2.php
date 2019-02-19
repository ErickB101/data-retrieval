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

						
  $querystring = "SELECT LeftCust, RightCust
                  FROM (SELECT c1.CustomerName AS LeftCust, c1.RepNum AS LeftRep, c1.CustomerNum AS LeftNum
				        FROM Customer c1) AS L
				        JOIN
					   (SELECT c2.CustomerName AS RightCust, c2.RepNum AS RightRep, c2.CustomerNum AS RightNum
					    FROM Customer c2) AS R
				  ON L.LeftRep = R.RightRep
				  WHERE L.LeftNum < R.RightNum
				  ORDER BY LeftCust, RightCust";
						      						      										 				  						 			

  $result = mysqli_query($con, $querystring);
  if (!$result) {
    print ( "Could not successfully run query ($querystring) from DB: " . mysqli_error($con) . "<br>");
    exit;
  }
  

print("Output: <br>");
  while ($rows = mysqli_fetch_object($result)) {
  
		
	  print $rows->LeftCust." - ".$rows->RightCust;
	  print "<br>";
	}
  
  mysqli_close($con);


?>