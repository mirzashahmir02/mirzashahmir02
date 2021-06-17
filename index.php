<?php
 include 'config.php';

if(isset($_POST['submit'])){

 date_default_timezone_set("Asia/karachi");
 $emp_name =  $_POST['ename'];
 $curr_date = date("Y-m-d");
 $curr_time = date("H:i:s");
 $remarks = "came early";
 $remarks1 = "came late";
 $remarks2 = "leave late";
 $remarks3 = "leave early";

 $query = "select * from employees where emp_name = '$emp_name'";
 $result1 = mysqli_query($link , $query);
 if(mysqli_num_rows($result1) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                
                // Retrieve individual field value

                $empl_name = $row['emp_name'];
                $in = $row['shiftin'];
                $out = $row['shiftout']; 

                
if($curr_time < "15:17:00"){
if($in >= $curr_time){
 $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
 '$remarks')";
} 

else{
    $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
   '$remarks1')";
}   
}                
 

else if($curr_time > "15:17:30"){
if($out < $curr_time){
 $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
 '$remarks2')";
} 

else{
    $sql = "Insert into attendance(emp_name , Date, time , remarks) values('$emp_name', '$curr_date', '$curr_time', 
   '$remarks3')";
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
        <h1> ATTENDANCE </h1>
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
                    </tr>
                </thead>
                    <tbody id="tableData">
                        <?php
                        $sql = "select emp_name, Date, min(time) AS 'timein', max(time) AS 'timeout' , MIN(remarks) AS 'arrived' , MAX(remarks) AS 'leaved' FROM 
                                attendance GROUP BY emp_name order by id desc";

                        $result = mysqli_query($link , $sql);
                        if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_array($result)) {
                                $name = $row['emp_name'];
                                $Date = $row['Date'];
                                $timein = $row['timein'];
                                $timeout = $row['timeout'];
                                $arrived = $row['arrived'];
                                $leaved = $row['leaved'];
                                ?>
                                <tr>
                                    <td> <?php echo $name ?> </td>
                                    <td> <?php echo $Date ?> </td>
                                    <td class="arrive"> <?php echo $timein ?> </td>
                                    <td class="depart"> <?php echo $timeout ?> </td>
                                    <td class="arrive atime"> <?php echo $arrived ?> </td>
                                    <td class="depart dtime"> <?php echo $leaved ?> </td>
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