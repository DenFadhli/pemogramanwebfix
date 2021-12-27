<?php  

$conn = mysqli_connect("localhost", "root", "", "myweb");
$query = "SELECT * FROM ponsel";

function query($query){
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function upload() {

    $namafile = $_FILES['pict']['name'];
    $error = $_FILES['pict']['error'];
    $ukuranfile = $_FILES['pict']['size'];
    $tmpfile = $_FILES['pict']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('Masukan Gambar Terlebih Dahulu');
            </script>";
        return false;
    }

    if ($ukuranfile > 3000000) {
        echo "<script>
                alert('Ukuran Gambar Terlalu Besar. Pastikan Gambar Kurang Dari 3Mb');
            </script>";
        return false;
    }

    $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = pathinfo($namafile, PATHINFO_EXTENSION);

    if ( !in_array($ekstensigambar, $ekstensigambarvalid) ) {
        echo "<script>
                alert('Ukuran Gambar Terlalu Besar. Pastikan Gambar Kurang Dari 3Mb');
            </script>";
        return false;
    }

    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;

    move_uploaded_file($tmpfile, 'img/' . $namafilebaru);
    return $namafilebaru;

}


function tambah($data) {
    global $conn;

    $product_name = htmlspecialchars(($data["product_name"]));
    $product_by = htmlspecialchars(($data["product_by"]));
    $device = htmlspecialchars(($data["device"]));
    $type = htmlspecialchars(($data["type"]));
    $price = htmlspecialchars(($data["price"]));

    $pict = upload();
    if (!$pict) {
        return false;
    }

    $query = "INSERT INTO ponsel VALUES 
    ('', '$product_name', '$product_by', '$device', 
    '$type', '$price', '$pict')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus() {
    global $conn;

    $id = $_GET["id"];

    if (empty(trim($id))) {
        echo "<scrpit>
        alert('Pilih Data Yang Ingin Dihapus Terlebih Dahulu');
        </scrpit>";
        return false;
    }
    $query = mysqli_query($conn, "DELETE FROM ponsel WHERE id='$id'");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $product_name = htmlspecialchars(($data["product_name"]));
    $product_by = htmlspecialchars(($data["product_by"]));
    $device = htmlspecialchars(($data["device"]));
    $type = htmlspecialchars(($data["type"]));
    $price = htmlspecialchars(($data["price"]));
    $oldpict = htmlspecialchars($data["oldpict"]);

    if($_FILES['pict']['error'] === 4) {
        $pict = $oldpict;
        return false;
    } 
    elseif($_FILES['pict']['size'] > 3000000) {
        $pict = $oldpict;
        return false;
    } else {
        $pict = upload();
    }

    $query = "UPDATE ponsel SET 
    product_name = '$product_name', 
    product_by = '$product_by', 
    device = '$device', 
    type = '$type', 
    price = '$price', 
    pict = '$pict' 
    WHERE id = $id 
    ";
    mysqli_query($conn , $query);
    return mysqli_affected_rows($conn);

}

function reg() {
    global $conn;

    $email = htmlspecialchars(strtolower(stripslashes($_POST["email"])));
    $username = htmlspecialchars(strtolower(stripslashes($_POST["username"])));
    $password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["password"]));
    $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["password2"]));


    if (empty(trim($username))) {
        echo "<scrpit>
        alert('Username Tidak Boleh Kosong');
        </scrpit>";
        return false;
    }

    if (empty(trim($email))) {
        echo "<scrpit>
        alert('Email Tidak Boleh Kosong');
        </scrpit>";
        return false;
    }

    $emailvalid = ['gmail.com', 'yahoo.com'];
    $namaemail = explode('@', $email);
    $namaemail = strtolower(end($namaemail));
    
    if ( !in_array($namaemail, $emailvalid)  ) {
        echo "<script>
                alert('Format Email Yang Anda Masukan Salah');
            </script>";
        return false;
    }

    $resultemail = mysqli_query($conn, "SELECT email FROM usersregist WHERE email = '$email'");
    if ( mysqli_fetch_assoc($resultemail) ) {
        echo "<script>
                alert('Gagal Membuat Akun. Email Telah Digunakan. Silahkan Ganti Email Lain');
            </script>";
        return false;
    }

    $result = mysqli_query($conn, "SELECT username FROM usersregist 
    WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('Gagal Membuat Akun. Username / Email Telah Tersedia.');
            document.location.href = 'registrasi.php';
            </script>";
        return false;
    }

    $min = 8;
    if (strlen($password) > $min) {
        echo "<script>
            alert('Password Tidak Boleh Lebih Dari 8 Karakter.');
            </script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>
                alert('Password Konfirmasi Salah');
            </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO usersregist VALUES 
    ('', '$email', '$username', '$password')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function cari($keyword) {

    // $jumlahdataperhalaman = 3;
    // $halamanaktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
    // $awaldata = ($jumlahdataperhalaman * $halamanaktif) - $jumlahdataperhalaman;

    // if (empty(trim($_POST["keyword"]))) {
    //     $query = "SELECT * FROM ponsel LIMIT $awaldata, $jumlahdataperhalaman";
    // }




    // if (!empty(trim($_POST["keyword"]))) {
    //     $query = "SELECT * FROM ponsel 
    //     WHERE 
    //     product_name LIKE '%$keyword%' OR 
    //     product_by LIKE '%$keyword%' OR 
    //     device LIKE '%$keyword%' OR 
    //     type LIKE '%$keyword%' OR 
    //     price LIKE '%$keyword%'";
    // }
    // $keyword = htmlspecialchars($_POST["keyword"]);

    // // $jumlahdataperhalamancari = 3;
    // // $jumlahhdatacari = count(cari($_POST["keyword"]));
    // // $jumlahhalamancari = ceil($jumlahhdatacari / $jumlahdataperhalamancari);
    // $halamanaktifcari = (isset($_GET["page"])) ? $_GET["page"] : 1;
    // $awaldatacari = (3 * $halamanaktifcari) - 3;
        
    // // $phones = cari($_POST["keyword"]);
    // // $keyword = $_POST["keyword"];
    // $query = mysqli_query($conn, "SELECT * FROM ponsel 
    // WHERE 
    // product_name LIKE '%$keyword%' OR 
    // product_by LIKE '%$keyword%' OR 
    // device LIKE '%$keyword%' OR 
    // type LIKE '%$keyword%' OR 
    // price LIKE '%$keyword%' LIMIT $awaldatacari, 3");

// hal 1 0-2
// hal 2 3-5
// hal 3 6-8



    $keyword = htmlspecialchars($_GET["keyword"]);

    $query = "SELECT * FROM ponsel 
        WHERE 
        product_name LIKE '%$keyword%' OR 
        product_by LIKE '%$keyword%' OR 
        device LIKE '%$keyword%' OR 
        type LIKE '%$keyword%' OR 
        price LIKE '%$keyword%'";

    return query($query);
}

function biodata($data) {
    global $conn;

    $nama = htmlspecialchars(($data["nama"]));
    $alamat = htmlspecialchars(($data["alamat"]));
    $kota = htmlspecialchars(($data["kota"]));
    $no_hp = htmlspecialchars(($data["no_hp"]));

    $query = "INSERT INTO konsumen VALUES 
    ('', '$nama', '$alamat', '$kota', 
    '$no_hp')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function pembelian() {
    global $conn;

    $nama_pembeli = $_SESSION["nama_pembeli"];
    $alamat_pembeli = $_SESSION["alamat_pembeli"];
    $tanggal_pemesanan = $_SESSION["tanggal_pemesanan"];
    $no_hp = $_SESSION["no_hp"];
    $product_name = $_SESSION["product_name"];
    $product_by = $_SESSION["product_by"];
    $device = $_SESSION["device"];
    $type = $_SESSION["type"];
    $price = $_SESSION["price"];
    $quantity = $_SESSION["quantity"];
    $resi = $_SESSION["resi"];
    $jumlah_bayar = $_SESSION["jumlah_bayar"];


    $query = "INSERT INTO produk_terjual VALUES 
    ('', '$nama_pembeli', '$alamat_pembeli', '$tanggal_pemesanan', 
    '$no_hp', '$product_name', '$product_by', '$device', '$type', '$price', 
    '$quantity', '$resi', '$jumlah_bayar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}




?>