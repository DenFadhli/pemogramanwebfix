<?php  

require 'functionings.php';

if (isset($_POST["registrasi"])) {
  if (reg($_POST) > 0) {
    echo "<script>alert('Username Berhasil Dibuat');</script>";
    header('Location:login.php');
    } 
  else {
    echo "Gagal dibuat";
    mysqli_error($conn);
    }
}




?>


<!DOCTYPE html>
<html>
<head>
<title>REGISTRASI</title>
<style>

    table {
        position: relative;
        margin: auto;
        
    }

    div {
        width: 300px;
        height: 450px;
        margin: auto;
        margin-top: 100px;
        border: solid salmon;
        border-radius: 20px;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-width: 5px;
    }

    label {font-family: arial;}

    input {
      border-radius: 10px;
      height: 30px;
      width: 252px;
      display: flex;
      flex-direction: column;
      outline: none;
    }

    input::placeholder {color: gray;}

    button {
      width: 100px;
      height: 30px;
      background-color: salmon;
      outline: none;
      border-radius: 20px;
      cursor: pointer;
      color: black;
      transition: .18s all;
    }

    .tanya {
      font-size: 12px;
      font-family: arial;
    }
    
    a {
      text-decoration: none;
    }



</style>
</head>
<body>




  <form action="" method="post"><div>
    <h3 style="text-align: center; margin-top: 50px; font-family:arial;">REGISTRASI</h3>
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <!-- <td><label for="">Username</label></td> -->
          <td><input type="text" name="email" id="email" autocomplete="off" autofocus required placeholder=" Email                (e.g:example@gmail.com)"></td>
        </tr>
        <tr>
          <!-- <td><label for="">Username</label></td> -->
          <td><input type="text" name="username" id="username" autocomplete="off" autofocus required placeholder=" Username"></td>
        </tr>
        <tr>
          <!-- <td><label for="">Password</label></td> -->
          <td><input type="password" name="password" id="password" autocomplete="off" autofocus required placeholder=" Password"></td>
        </tr>
        <tr>
          <!-- <td><label for="">Password</label></td> -->
          <td><input type="password" name="password2" id="password2" autocomplete="off" autofocus required placeholder=" Password Konfirmasi"></td>
        </tr>
        <tr><th colspan="2"><button type="submit" name="registrasi" id="registrasi">REGISTRASI
          <!-- <label for="" style="text-align: center;">Log In</label> -->
        </button></th></tr>
        <tr>
        <td></td>
        </tr>
        <tr>
        <th colspan="2" class="tanya">Sudah Punya Akun ? <a href="login.php">Login</a></th>
        </tr>
      </table></div>
  </form>


</body>
</html>