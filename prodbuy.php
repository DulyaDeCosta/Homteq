<?php

    include("db.php");
    
    include ("detectlogin.php");
    
    $pagename = "A smart buy for a smart home"; // create and populate variable called $pagename
    
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
    
    echo "<title>".$pagename."</title>";
    
    echo "<body>";

    include ("headfile.html");
    echo"<br>";
    echo "<h4>".$pagename."</h4>";

    //retrieve the product id passed from the previous page using the GET method and the $_GET superglobal variable
    //applied to the query string prod_id
    //store the value in a local variable called $proId

    $prodId = $_GET['prod_id'];
    //display the value of the product id, for debugging purposes
    echo "<p>Selected product Id: ".$prodId."</p>";
    
// Modify the SQL query to retrieve specific product details based on the provided product ID
$SQL = "SELECT prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity FROM Product WHERE prodId = $prodId";
// Run SQL query for connected DB or exit and display error message
$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
echo "<table style='border: 0px'>";
// Fetch the product details
while ($arrayp = mysqli_fetch_array($exeSQL)) {
    echo "<tr>";
    echo "<td style='border: 0px'>";
    // Display the large image of the selected product
    echo "<img src=images/".$arrayp['prodPicNameLarge']." height=400 width=370>";
    echo "</td>";
    
    echo "<td style='border: 0px; vertical-align: top;'>";
    echo "<p><h3>".$arrayp['prodName']."</h3>"; // Display product name
    echo "<br>";
    echo '<p style="text-align: justify;">' . $arrayp['prodDescripLong'] . '</p>'; // Display long description
    echo "<br>";
    echo "<p><b>Price: $".$arrayp['prodPrice']."</b></p>"; // Display product price
    echo "<br>";
    // Display the number of items left in stock
    echo "<p><b>Left in Stock: ".$arrayp['prodQuantity']." items</b></p>";
    
    echo "<br>";
    echo "<br>";
    
    echo "<p>Number to be purchased: ";
    //create form made of one text field and one button for user to enter quantity
    //the value entered in the form will be posted to the basket.php to be processed
    echo "<form action=basket.php method=post>";
    echo "<select name=p_quantity>";
        for ($i=1; $i<=$arrayp['prodQuantity']; $i++)
        {
        echo "<option value=".$i.">".$i."</option>";
        }
        echo "</select>";
        
        echo "<input type=submit name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
    
    //pass the product id to the next page basket.php as a hidden value
    echo "<input type=hidden name=h_prodid value=".$prodId.">";
    echo "</form>";
    echo "</p>";
    echo "</td>";
    
    echo "</tr>";
}

echo "</table>";



    include ("footfile.html");
    echo "</body>";

?>
