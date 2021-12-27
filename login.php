<?php  

require 'functionings.php';

session_start();



// $hello = mysqli_query($conn, "SELECT username FROM usersregist");
// $_SESSION["hellousername"] = $hello;




if (isset($_SESSION["login"])) {
    header("Location:halamanadmin.php");
    exit;
}

if (isset($_POST["login"])) {
    global $conn;
    
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);


    if (empty(trim($username))) {
        echo "<scrpit>
        alert('Username Tidak Boleh Kosong');
        </scrpit>";
        return false;
    }

    if (empty(trim($password))) {
        echo "<scrpit>
        alert('Password Tidak Boleh Kosong');
        </scrpit>";
        return false;
    }
    
    $result = mysqli_query($conn, 
        "SELECT * FROM 
        usersregist WHERE 
        username = '$username' OR email = '$email'");
    
    $admin = mysqli_query($conn, 
        "SELECT * FROM 
        admin WHERE 
        username = '$username' OR email = '$email'");
    
    // if (mysqli_num_rows($admin) === 1) {
    //     $row = mysqli_fetch_assoc($admin);
    //     if (password_verify($password, $row["password"])) {
    //         $_SESSION["login"] = true;
    //         setcookie('name', $row["username"]);
    //         echo "<script>
    //             alert('Login Berhasil');
    //                 </script>";
    //             header("Location:halamanadminn.php");
    //             exit;
    //     }
    // } 
    
    if (mysqli_num_rows($admin) === 1) {
        $row = mysqli_fetch_assoc($admin);
        if ($password == $row["password"]) {
            $_SESSION["login"] = true;
            setcookie('name', $row["username"]);
            echo "<script>
                alert('Login Berhasil');
                    </script>";
                header("Location:halamanadminnnn.php");
                exit;
        }
    } 


    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            setcookie('name', $row["username"]);
            echo "<script>
                alert('Login Berhasil');
                    </script>";
                header("Location:halamanpembeli.php");
                exit;
        }
    } 

    $error = true;
}






?>





<!DOCTYPE html>
<html>
<head>
<title>LOGIN</title>
<link rel="icon" href="img/favicon.ico" type="img/x-icon">
<style>

    table {
      position: relative;
      margin: auto;
    }

    .wrongpass {
      position: relative;
      margin-left: center;
      margin-top: 510px;

    }

    /* div {
        width: 300px;
        height: 310px;
        margin: auto;
        margin-top: 100px;
        border: solid salmon;
        border-radius: 20px;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-width: 5px;
    } */

    label {font-family: arial;}

    input {
      border-radius: 10px;
      height: 30px;
      width: 252px;
      display: flex;
      flex-direction: column;
      outline: none;
      border: none;
    }

    input::placeholder {color: gray;}

    button {
      width: 120px;
      height: 35px;
      background-color: #59595D;
      outline: none;
      border-radius: 10px;
      cursor: pointer;
      color: black;
      transition: .18s all;
      border: none;
      color: whitesmoke;
    }

    .inginregist {
      display: block;
    }

    .container {
        width: 300px;
        height: 320px;
        margin: auto;
        /* display: flex;
        justify-content: center;
        align-items: center; */
        /* margin-top: 100px; */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 10px;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-width: 5px;
        background-color: #151517;
        box-shadow: 10px 10px 10px #151520;
    }

    .input {
      position: relative;
      width: 100%;
      height: 150%;
      margin-bottom: .7rem;
    }

    .input input {
      width: 252px;
      height: 30px;
      padding-top: .8rem;
      padding-left: 10px;
      outline: none;
      border: 1px solid #8c8c8c;
      border-radius: 15px;
      transition: .2s;
    }

    .input label {
      position: absolute;
      top: 30%;
      left: 10px;
      font-size: 14px;
      color: #8c8c8c;
      transition: .2s;
    }

    .input input:focus ~ label,
    .input input:valid ~ label {
      top: 10%;
      font-size: 12px;
      color: #8c8c8c;
    }

    .input input:focus {
      border-width: 2px;
      border-color: #0A66C3;
    }

    label {font-family: arial;}

    /* input {
      border-radius: 10px;
      height: 30px;
      width: 252px;
      display: flex;
      flex-direction: column;
      outline: none;
    } */

    

    input::placeholder {color: gray;}

    /* button {
      width: 100px;
      height: 30px;
      background-color: salmon;
      outline: none;
      border-radius: 20px;
      cursor: pointer;
      color: black;
      transition: .18s all;
    } */

    .inginregist {
      display: block;
    }

    body {
      background-color: #232627;
    }



</style>
</head>
<body>
  
  <div class="container">
  <form action="" method="post">
    <h3 style="text-align: center; margin-top: 50px; font-family:arial; color: #fff;">LOGIN</h3>
      <table border="0" cellpadding="10" cellspacing="0">
        
        <tr>
          <!-- <td><label for="">Username</label></td> -->
          <td>
            <div class="input">
              <input type="text" name="username" id="username" autocomplete="off" required>
              <label for="username">Username or Email</label>
          </div>
          </td>        
        </tr>
        
        
        <tr>
          <!-- <td><label for="">Password</label></td> -->
          <td>
            <div class="input">
              <input type="password" name="password" id="password" autocomplete="off" required>
              <label for="password">Password</label>
            </div>
          </td>
        </tr>
        
        <tr><th colspan="2"><button type="submit" name="login" id="registrasi">LOGIN
          <!-- <label for="" style="text-align: center;">Log In</label> -->
        </button></th></tr>
        </tr>
        <tr>
        <td></td>
        </tr>
        <tr>
        <td><label class="inginregist" style="text-align: center; font-size: 12px; font-family: arial; color: white;">Belum Punya Akun ? <a style="font-family: arial; font-size: 12px; color: white" href="registrasi.php">  Buat Akun</a></label></td>
        </tr>
      </table>
  </form>
  </div>
  <?php if (isset($error)) : ?>
  <table border="0" cellpadding="2" cellspacing="0" class="wrongpass">
    <tr>
      <td colspan="2">
        
          <p style="color: red; font-style: italic; text-align: center; font-family: arial;">Incorret Username, Email or Password</p>
      </td>
    </tr>
    <tr>
      <td>
        <label class="inginregist" style="text-align: center; font-size: 12px; font-family: arial; color: white">Ingin Buat Akun ?</label>
      </td>
      <td>
        <button type="button" style="font-family: arial; color: white; background-color: #151517; border:  0.5px whitesmoke solid;" onclick="window.location.href='registrasi.php'">Buat Akun</button>
      </td>
    </tr>
  </table>
  <?php endif; ?>
  
  

</body>
</html>
