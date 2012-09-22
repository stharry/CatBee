<?php
require_once 'System.php';
//phpInfo();exit;
//var_dump($_POST);
?>
<html>
<head>
<title>CatBee Demo</title>
<body>
Hey <?php echo $_POST["fname"]; ?><br />


<?php
$imageURL  = $_POST["url"];
$imageURL = stripcslashes($imageURL);
$imgSize = getimagesize($imageURL);
$imgW = $imgSize[0] - 200; 

$imgH = $imgSize[1]-200; 
echo "<SCRIPT type='text/Javascript'>\n"; 
echo "\nif ((parseInt(navigator.appVersion)>3)) {top.resizeTo('$imgW','$imgH')}\;\n"; 
echo ">\n</SCRIPT>"; 
echo "<img src=\"$imageURL\" border='0'>\n"; 

?>
<br/>
<form action="CatBeeDemo.php" method="post">
Price Reduction:
<select name="Price">
<option value="10">10</option>
<option value="20">20</option>
</select><br />
Team members : <input type="text" name="Members"/>
<br/>
<?Php
//    $con = mysql_connect("localhost","root","tomer165");
    $con = mysql_connect();
//    mysql_select_db("test", $con);
    mysql_select_db("catbee", $con);
        $result = mysql_query("SELECT CustomerName FROM testtable;");

while($row = mysql_fetch_array($result))
  {
  echo $row['CustomerName'];
  echo "<br />";
  }

mysql_close($con);

?>
<?php
if (isset($_REQUEST['email']))
//if "email" is filled out, send email
  {
  //send email
  $email = $_REQUEST['email'] ;
  $subject = $_REQUEST['subject'] ;
  $message = $_REQUEST['message'] ;
  echo "Thank you for using our mail form";
  mail("tomer.harry@gmail.com", $subject,
  $message, "From:" .$email);
  echo "Thank you for using our mail form";
  }
else
//if "email" is not filled out, display the form
  {
  echo "<form method='post' action='CatBeeDemo.php'>
  Email: <input name='email' type='text' /><br />
  Subject: <input name='subject' type='text' /><br />
  Message:<br />
  <textarea name='message' rows='15' cols='40'>
  </textarea><br />
  <input type='submit' />
  </form>";
  }
?>

</form>
</body>
</head>
</html>