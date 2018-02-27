<!doctype html>
<html lang="en">

<head>
    <title>TaskList::Search</title>
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
        <div class="bodyTitle">Search</div>
        <form name="myForm" action="search.php" method="post"  >
        <input type="hidden" value="test" name="search_check" />
            <div class="center-select">
                <strong>Choose a Service: &nbsp; </strong>
                <select name="services" id="services">
            <?php
                $conn = mysqli_connect("localhost", "tasklist_user", "my*password", "myoung")
                or die("Cannot connect to database:" . mysqli_connect_error($conn));
            $query="select services_desc, services_abbr from services order by services_desc";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Invalid query: " . mysqli_error($conn));
            }
            else {
               
                while($row = mysqli_fetch_array($result)){
                    print "<option value=\"";
                    echo "{$row['services_abbr']}";
                    echo '"';
                    if (!empty($_POST['services']) && $row['services_abbr'] == $_POST['services'] ) {
                        echo ' selected = "selected" ';
                    }
                        echo "\">";
                    echo "{$row['services_desc']}";
                    print "</option>";
                }
                mysqli_free_result($result);
            }
            mysqli_close($conn);
            ?>
                </select>
            </div>
            <div class="center">
                <button class="button button1">Search</button>
            </div>
           <?php 
            if(!empty($_POST["search_check"]))
            {
$conn = mysqli_connect(
    "localhost",
    "tasklist_user",

    "my*password",
    "myoung"
)

    or die("Cannot connect to database:" .

mysqli_connect_error($conn));
$services = $_POST['services'];
    $query = mysqli_prepare(
        $conn,
        "select a.first_name, a.last_name, availability_desc
        from profile a, profile_availability b, services c, services_offered d, availability e
        where  c.services_id = d.services_id
        and d.profile_id = a.profile_id
        and e.availability_id = b.availability_id
        and b.profile_id = a.profile_id 
        and c.services_abbr= ? 
        order by last_name"
    )
        or die("Error: " . mysqli_error($conn));
        mysqli_stmt_bind_param ($query, "s", $services);
        mysqli_stmt_execute($query);
        mysqli_stmt_bind_result($query, $firstname, $lastname, $avail);
        echo '<div class="avail">';
        echo '        <h4>Results:</h4>';
        echo '        <table class="rTable">';
        echo '            <thead class="rTableHeading rTableHead">';
        echo '                <tr class="rTableRow">';
        echo ' ';
        echo '                    <td class="rTableCell">';
        echo '                        <strong>Name</strong>';
        echo '                    </td>';
        echo ' ';
        echo '                    <td class="rTableCell">';
        echo '                        <strong>Availability</strong>';
        echo '                    </td>';
        echo '                </tr>';
        echo '           </thead>';
        echo '           <tbody class="rTableBody">';
        echo ' ';                
       
        while (mysqli_stmt_fetch($query)) {
            echo '<tr class="rTableRow">';
            echo '<td class="rTableCell">' . $firstname . ' ' . $lastname . '</td>';
            echo '<td class="rTableCell">' . '<div>' . $avail . '</div>';
            echo '</tr>';
        }
        
    
    mysqli_stmt_close ($query);
    mysqli_close($conn);

 

                    echo '</tbody>';
               echo '</table>';
            echo '</div>';
        
        }
?>
        </form>
    </div>
</body>
</html>