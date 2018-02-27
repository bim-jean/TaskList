<!doctype html>
<html lang="en">

<head>
    <title>TaskList::Registration Submission</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="box">
            <div class="Title">TaskList</div>
            <?php include "menu.php"; ?>
        </div>
    </header>
    <div class="box">
        <div class="bodyTitle">Registration Submission</div>
        <?php

$msg = "Thank you for registration on our web site.";


$today = date("m/d/y");


$msg = $msg . "<br/>" . $today;


if(!empty($_POST["firstname"]) && !empty($_POST["netid"]) && !empty($_POST["lastname"]) && !empty($_POST["email"])){
	
	
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $name = $firstname . " " . $lastname ;
    if (!empty($_POST['confirm'])) {
        $confirm = 1;
     }
        else
        {
            $confirm = 0;
        }
    

    
    $netid = $_POST["netid"];
	
    $email = $_POST["email"];
    
    if(!empty($_POST['services'])){

        //read all provided values as an array and join them as comma separated string 
    
        $services = implode(",", $_POST['services']);
    
        echo "<p>services: $services </p>";
    
      } else {
    
        echo "<p>No services were provided.  Please resubmit.</p>";
        die ();
    
      }

      if(!empty($_POST['times'])){

        //read all provided values as an array and join them as comma separated string 
    
        $times = implode(",", $_POST['times']);
    
        echo "<p>Times: $times </p>";
    
      } else {
    
        echo "<p>No times were provided. Please resubmit.</p>";
        die ();
    
      }
    
     //send confirmation email

  $to = $email;

  $subject = "Registration";

  $body = $msg;
  if(!empty($_POST['confirm'])){
  if (mail($to, $subject, $body)) {

    echo("<p>Confirmation email message successfully sent!</p>");

  } else {

    echo("<p>Confirmation email message delivery failed...</p>");

  }
}
	
	$msg = $name . " (" . $email . ") " . $msg;

            $conn = mysqli_connect(
                "localhost",
                "tasklist_user",

                "my*password",
                "myoung"
            )

                or die("Cannot connect to database:" .

            mysqli_connect_error($conn));
            $query = mysqli_prepare(
                $conn,
                "INSERT INTO profile (netid, first_name, last_name, email, post_date, notification) VALUES(?, ?, ?, ?, NOW(), ?)"
            )
                or die("Error: " . mysqli_error($conn));
            mysqli_stmt_bind_param ($query, "sssss", $netid, $firstname, $lastname, $email,  $confirm );
            mysqli_stmt_execute($query)
                or die("Error. Could not insert into the table."
                . mysqli_error($conn));
            $inserted_id = mysqli_insert_id($conn);

            mysqli_stmt_close($query); 

            foreach($_POST['services'] as $services) {
                $query = mysqli_prepare(
                    $conn,
                    "SELECT services_id from services where services_abbr = ?"
                )
                    or die("Error: " . mysqli_error($conn));
                mysqli_stmt_bind_param ($query, "s", $services);
                mysqli_stmt_execute($query);
                mysqli_stmt_store_result($query);
                mysqli_stmt_bind_result($query, $id);
                while (mysqli_stmt_fetch($query)) {
                    $services_id=$id;
                }
                mysqli_stmt_close ($query);

                
                $query = mysqli_prepare(
                    $conn,
                    "INSERT INTO services_offered (profile_id, services_id) VALUES(?,?)"
                )
                    or die("Error: " . mysqli_error($conn));
                
                
                mysqli_stmt_bind_param ($query, "ii",  $inserted_id, $services_id);
                mysqli_stmt_execute($query)
                    or die("Error. Could not insert into the table."
                    . mysqli_error($conn));
                mysqli_stmt_close($query);
            }

            foreach($_POST['times'] as $times) {
                $query = mysqli_prepare(
                    $conn,
                    "SELECT availability_id from availability where availability_abbr = ?"
                )
                    or die("Error: " . mysqli_error($conn));
                mysqli_stmt_bind_param ($query, "s", $times);
                mysqli_stmt_execute($query);
                mysqli_stmt_store_result($query);
                mysqli_stmt_bind_result($query, $aid);
                while (mysqli_stmt_fetch($query)) {
                    $availability_id=$aid;
                }
                mysqli_stmt_close ($query);
                
                $query = mysqli_prepare(
                    $conn,
                    "INSERT INTO profile_availability (profile_id, availability_id) VALUES(?,?)"
                )
                    or die("Error: " . mysqli_error($conn));
                
                
                mysqli_stmt_bind_param ($query, "ii",  $inserted_id, $availability_id);
                mysqli_stmt_execute($query)
                    or die("Error. Could not insert into the table."
                    . mysqli_error($conn));
                mysqli_stmt_close($query);
            }
            


}
else {
	
	
	$msg = "Name, Netid, and email are required fields";
	
	
}




echo $msg;
mysqli_close($conn);
//display message

?>
    </div>
</body>

</html>