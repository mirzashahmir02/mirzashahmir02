<?php
 include 'config.php';

if(isset($_POST['submit'])){

 date_default_timezone_set("Asia/karachi");
 $emp_name =  $_POST['ename'];
 $curr_date = date("Y-m-d");
 $curr_time = date("H:i:s");
 $remarks = "came early";
 $remarks1 = "came early";
 $remarks2 = "came late";
 $remarks3 = "leave late";
 $remarks4 = "leave early";

 $query = "select * from employees where emp_name = '$emp_name'";
 $result1 = mysqli_query($link , $query);
 if(mysqli_num_rows($result1) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                
                // Retrieve individual field value

                $empl_name = $row['emp_name'];
                $in = $row['shiftin'];
                $out = $row['shiftout']; 

                
if($curr_time < "10:55:30"){
if($in > $curr_time){
 $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
 '$remarks')";
}

else if($in == $curr_time){
    $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
   '$remarks1')";
} 

else if($in < $curr_time){
    $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
   '$remarks2')";
}   
}                
 

else if($curr_time > "10:56:00"){
if($out < $curr_time){
 $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
 '$remarks3')";
} 

else if($out > $curr_time){
    $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
   '$remarks4')";
}   
}                


}
 $result = mysqli_query($link , $sql);
 if ($result) {
    header("location: index.php");

 }


}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo_container">
        <img src="img/ifbotix-white.png" alt="">
    </div>
    <div class="attendance_container">
        <p id="head"> ATTENDANCE </p>
        <div class="attendance_header">
            
            <p id="timep"> <span> Time: </span><span id="time">10:00:00</span>  </p>
            <label for="ename"> EMPLOYEE NAME </label>
            <br>
            <form action="index.php" method="post">
                <input type="text" id="ename" name="ename">
                
                <input id="submit" type="submit" name="submit" value="SUBMIT">
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Arrived</th>
                        <th>Leaved</th>
                        <th>Working Time</th>
                        <th>Over Time</th>
                    </tr>
                </thead>
                    <tbody id="tableData">
                        <?php
                        $sql = "SELECT attendance.emp_name, attendance.Date, 
                        MIN(time) AS 'timein', MAX(time) AS 'timeout',
                        MIN(remarks) AS 'arrived', MAX(remarks) AS 'leaved', SUBTIME(MAX(time), MIN(time)) as 'workingtime' , SUBTIME(SUBTIME(MAX(time), MIN(time)), SUBTIME(shiftout, shiftin)) AS 'overtime'
                            FROM employees, attendance
                            WHERE employees.emp_name =
                            attendance.emp_name GROUP BY emp_name, Date ORDER BY attendance.id DESC";

                        $result = mysqli_query($link , $sql);
                        if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_array($result)) {
                                $name = $row['emp_name'];
                                $Date = $row['Date'];
                                $timein = $row['timein'];
                                $timeout = $row['timeout'];
                                $arrived = $row['arrived'];
                                $leaved = $row['leaved'];
                                $workingtime = $row['workingtime'];
                                $overtime = $row['overtime'];
                                ?>
                                <tr>
                                    <td> <?php echo $name ?> </td>
                                    <td> <?php echo $Date ?> </td>
                                    <td class="arrive"> <?php echo $timein ?> </td>
                                    <td class="depart"> <?php echo $timeout ?> </td>
                                    <td class="arrive atime"> <?php echo $arrived ?> </td>
                                    <td class="depart dtime"> <?php echo $leaved ?> </td>
                                    <td> <?php echo $workingtime ?> </td>
                                    <td> <?php echo $overtime ?> </td>
                                </tr>
                                <?php  
                            }
                        }
?>

                         
                    </tbody>
                </table>
            

        </div>
    </div>
</body>
</html>