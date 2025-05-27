<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
table {
    border-collapse: collapse;
    width: 50%;
    margin: 20px 0;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
</style>
</head>
<body>

<?php
// definisikan variabel dan set ke nilai kosong
$nameErr = $emailErr = $jenis_kelaminErr = "";
$name = $email = $jenis_kelamin = $saran = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Nama wajib diisi";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Hanya boleh huruf dan spasi";
        }
    }
    
    if (empty($_POST["email"])) {
        $emailErr = "Email wajib diisi";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }
        
    if (!empty($_POST["saran"])) {
        $saran = test_input($_POST["saran"]);
    }

    if (empty($_POST["jenis_kelamin"])) {
        $jenis_kelaminErr = "Jenis kelamin wajib dipilih";
    } else {
        $jenis_kelamin = test_input($_POST["jenis_kelamin"]);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2>Form Saran</h2>
<p><span class="error">* wajib diisi</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <table>
        <tr>
            <td>Nama:</td>
            <td>
                <input type="text" name="name" value="<?php echo $name;?>">
                <span class="error">* <?php echo $nameErr;?></span>
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="email" value="<?php echo $email;?>">
                <span class="error">* <?php echo $emailErr;?></span>
            </td>
        </tr>
        <tr>
            <td>Saran:</td>
            <td>
                <textarea name="saran" rows="3" cols="40"><?php echo $saran;?></textarea>
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin:</td>
            <td>
                <input type="radio" name="jenis_kelamin" <?php if (isset($jenis_kelamin) && $jenis_kelamin=="perempuan") echo "checked";?> value="Perempuan">Perempuan
                <input type="radio" name="jenis_kelamin" <?php if (isset($jenis_kelamin) && $jenis_kelamin=="laki-laki") echo "checked";?> value="Laki-laki">Laki-laki
                <input type="radio" name="jenis_kelamin" <?php if (isset($jenis_kelamin) && $jenis_kelamin=="lainnya") echo "checked";?> value="lainnya">Lainnya  
                <span class="error">* <?php echo $jenis_kelaminErr;?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="submit" value="Submit">
            </td>
        </tr>
    </table>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Hasil Input:</h2>";
    echo "<table>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    echo "<tr><td>Nama</td><td>$name</td></tr>";
    echo "<tr><td>Email</td><td>$email</td></tr>";
    echo "<tr><td>Saran</td><td>$saran</td></tr>";
    echo "<tr><td>Jenis Kelamin</td><td>$jenis_kelamin</td></tr>";
    echo "</table>";
}
?>

</body>
</html>