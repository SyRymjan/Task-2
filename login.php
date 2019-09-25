<?php
if(isset($_POST['login']))
{
    require('config.php');
    $username = $_POST['username']; 
    $password=  $_POST['password'];
    
    
    $sql = "SELECT * FROM users WHERE username  = ?  or password= ?;";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        // header("Location : main.php?error=sqlerror");
        // exit();
        echo "sql error";
    }
    else 
    {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result))
        {
                
            $pwdCheck = false; 
            $userCheck = false;
            if($username == $row['username'])
            {
            $userCheck = true; 
            }
            
            if($password == $row['password'])
            {
            $pwdCheck = true; 
            }
            
                if($pwdCheck == false || $userCheck == false )
                {
                    // header("Location : main.php?error=wrongpass");
                    // exit();
                    echo "wrong password or wrong user";
                }
                else if ($pwdCheck == true )
                {
                     session_start();
                     $_SESSION['userId'] = $row['id'];
                    //  header("Location : main.php?login=success");
                    //  exit();
                    echo "Success log in";
                }
                else
                {
                    // header("Location : main.php?error=wrongpass");
                    // exit();
                    echo "wrong password";
                }
        }
        else
        {
            // header("Location : main.php?error=nouser");
            // exit();
            echo "No such user";
        }
    }
}
else
{
    // header("Location : main.php");
    // exit();
}
?>