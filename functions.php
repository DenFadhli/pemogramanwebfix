<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "myweb");

function query($query) {
    global $conn;
    $query = "SELECT * FROM ponsel";
    $result = mysqli_query($conn, $query);

    //ngambil data satu-satu dari tabel mahasiswa terus masukin ke wadah
    //yang berupa array assoc
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data) {
    setcookie("keyword", "", time() - 3600);
    global $conn;
    
    
    $nim = htmlspecialchars( $data["nim"] );
    $nama = htmlspecialchars( $data["nama"] );
    $email = htmlspecialchars( $data["email"] );
    $jurusan = htmlspecialchars( $data["jurusan"] );
    
    //upload gambar
    $gambar = upload();
    if( !$gambar ) {
        return false;
    }

    $query = "INSERT INTO mahasiswa
    VALUES
    ('','$nama', '$nim', '$email', '$jurusan', '$gambar')
    
    ";

    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus($id) {
    setcookie("keyword", "", time() - 3600);
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    setcookie("keyword", "", time() - 3600);
    global $conn;
    
    $id = $data["id"];
    $nim = htmlspecialchars( $data["nim"] );
    $nama = htmlspecialchars( $data["nama"] );
    $email = htmlspecialchars( $data["email"] );
    $jurusan = htmlspecialchars( $data["jurusan"] );
    
    $gambarLama = htmlspecialchars( $data["gambarLama"] );

    //cek apakah user pilih gambar baru atau tidak

    if($_FILES["gambar"]["error"] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }
    

    $query = "UPDATE mahasiswa SET
        nama = '$nama',
        nim = '$nim',
        email = '$email',
        jurusan = '$jurusan',
        gambar = '$gambar'

        WHERE id = $id
    ";

    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);

}

function cari($keyword) {
    
    setcookie("keyword", $_GET["keyword"]);
    $query = "SELECT * FROM ponsel
                WHERE
            product_name LIKE '%$keyword%' OR
            product_by LIKE '%$keyword%' OR
            device LIKE '%$keyword%' OR 
            type LIKE '%$keyword%' OR
            price LIKE '%$keyword%'
            
    ";
    return query($query);
}



function upload() {
    setcookie("keyword", "", time() - 3600);

    $namaFile = $_FILES["gambar"]["name"];
    $ukuranFile = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmpName = $_FILES["gambar"]["tmp_name"];

    //Cek apakah tidak ada gambar yg diupload
    if( $error === 4 ) {
        echo "
            <script>
                alert('Pilih gambar terlebih dahulu');
            </script>
        ";
        return false;
    }


    //Yang boleh diupload hanya gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "
            <script>
                alert('Yang Anda upload bukan gambar!');
            </script>
        ";
    }

    //cek ukuran gambar jika terlalu besar
    if( $ukuranFile > 200000 ) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar!');
            </script>
        ";
    }

    //Lolos pengecekan, gambar siap diupload

    //generate nama gambar baru
    $namaGambarBaru = uniqid();
    $namaGambarBaru .= '.' . $ekstensiGambar;


    move_uploaded_file($tmpName, 'img/' . $namaGambarBaru);
    return $namaGambarBaru;
}

function registrasi($data) {
    setcookie("keyword", "", time() - 3600);

    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
        echo "
            <script>
                alert('Username yang dipilih sudah terdaftar.');
            </script>
        ";
        return false;
    }


    //cek konfirmasi password
    if( $password !== $password2 ) {
        echo "
            <script>
                alert('Konfirmasi password tidak sesuai.');
            </script>
        ";
        return false;
    }

    //Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}



?>