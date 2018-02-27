<!doctype html>
<html lang="en">

<head>
    <title>TaskList::Registration</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
        function validate_services(form) {
            var serv = document.getElementsByName("services[]");
            var checkCount = 0;
            for(i=0; i < serv.length; i++) {
                if(serv[i].checked) {
                    checkCount++;
                }
            }   
            if (checkCount < 1) { 
                alert('You must select at lease ONE service.');
                return false; 
            }
            return true;
        }
        

        function validate_times(form) {
            var time = document.getElementsByName("times[]");
            var checkCount = 0;
            for(i=0; i < time.length; i++) {
                if(time[i].checked) {
                    checkCount++;
                }
            }   
            if (checkCount < 1) { 
                alert('You must select at lease ONE time slot available.');
                return false; 
            }
            return true;
        }

        function validate(form) {
            if (validate_services(form) == false || validate_times(form) == false ) {
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <header>
        <div class="box">
            <div class="Title">TaskList</div>
            <?php include "menu.php"; ?>
        </div>
    </header>
    <div class="box">
        <div class="bodyTitle">Registration</div>
        <form name="myForm" action="registration_submit.php" onsubmit="return validate(this);" method="post"  >
            <div class="name">
                <div>Netid:</div>
                <div>
                    <input type="text" name="netid" required>
                </div>

                <div>
                    <div>First name:</div>
                    <div>
                        <input type="text" name="firstname" required >
                    </div>
                    <div> Last name:</div>
                    <div>
                        <input type="text" name="lastname" required >
                    </div>
                </div>
                <div>
                    <div>Email:</div>
                    <div>
                        <input type="email" name="email" required >
                    </div>
                </div>
            </div>
            <div class="services">
                <h4>
                    Services Offered:
                </h4>
                <div class="service-col s4">    
            <?php
            $conn = mysqli_connect("localhost", "tasklist_user", "my*password", "myoung")
                or die("Cannot connect to database:" . mysqli_connect_error($conn));
            $query="select services_desc, services_abbr from services";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Invalid query: " . mysqli_error($conn));
            }
            else {
                $rowcounter=0;
                while($row = mysqli_fetch_array($result)){
                    if (($rowcounter % 3) == 0 ) {
                      print "</div>";
                      print "<div class=\"service-col s4\">" ;
                    }
                    print "<label class=\"checkcontainer\">";
                    echo "{$row['services_desc']}";
                    print "<input type=\"checkbox\" name=\"services[]\" id=\"services[]\" value=\"";
                    echo "{$row['services_abbr']}" . "\">"; 
                    print "<span class=\"checkmark\"></span>";
                    print "</label>";
                    $rowcounter++;
                }
                mysqli_free_result($result);
            }
            mysqli_close($conn);
            ?>
            </div>
            
        </div>



            <div class="avail">

                <h4>Availability:</h4>
                <table class="availTable">
                    <thead>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <strong>Monday</strong>
                            </td>

                            <td>
                                <strong>Tuesday</strong>
                            </td>

                            <td>
                                <strong>Wednesday</strong>
                            </td>

                            <td>
                                <strong>Thursday</strong>
                            </td>

                            <td>
                                <strong>Friday</strong>
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>8am-12pm</td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="M8">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="T8">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="W8">
                            </td>

                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="Th8">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="F8">
                            </td>
                        </tr>
                        <tr>
                            <td>1pm-5pm</td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="M1">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="T1">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="W1">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="Th1">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="F1">
                            </td>
                        </tr>
                        <tr>
                            <td>6pm-10pm</td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="M6">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="T6">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="W6">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="Th6">
                            </td>
                            <td>
                                <input type="checkbox" name="times[]" id="times[]" value="F6">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="service-col">
                    <p>&nbsp;</p>
                    <label class="checkcontainer">Receive Email Confirmation?
                        <input type="checkbox" name="confirm" id="confirm">
                        <span class="checkmark"></span>
                    </label>

                    <button class="button button1">Submit</button>
                </div>
            </div>




        </form>
    </div>
</body>

</html>