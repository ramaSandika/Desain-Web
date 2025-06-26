<?php
$servername = "komtol";
$username = "root";
$password = "";
$dbname = "mahasiswa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $nim = $_GET['delete'];
    $delete_sql = "DELETE FROM datadiri WHERE NIM = '$nim'";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus');</script>";
        echo "<script>window.location.href='".$_SERVER['PHP_SELF']."';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    
    $update_sql = "UPDATE datadiri SET Nama='$nama', Jeniskelamin='$jeniskelamin' WHERE NIM='$nim'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Data berhasil diupdate');</script>";
        echo "<script>window.location.href='".$_SERVER['PHP_SELF']."';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Query to select data
$sql = "SELECT * FROM datadiri WHERE Jeniskelamin = 'l'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 0 2px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .add-btn {
            display: inline-block;
            margin: 20px;
            padding: 10px 15px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Data Mahasiswa Laki-laki</h2>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table cellpadding='10' cellspacing='0'>";
        echo "<tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
              </tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["NIM"] . "</td>";
            echo "<td>" . $row["Nama"] . "</td>";
            echo "<td>" . $row["Jeniskelamin"] . "</td>";
            echo "<td>
                    <button onclick=\"openModal('".$row["NIM"]."','".$row["Nama"]."','".$row["Jeniskelamin"]."')\" class='action-btn edit-btn'>Edit</button>
                    <a href='?delete=".$row["NIM"]."' class='action-btn delete-btn' 
                       onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data yang ditemukan";
    }
    ?>
    
    <!-- Modal for Edit Form -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Edit Data Mahasiswa</h3>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="update" value="1">
                <input type="hidden" id="modal-nim" name="nim">
                
                <label for="nama">Nama:</label>
                <input type="text" id="modal-nama" name="nama" required>
                
                <label for="jeniskelamin">Jenis Kelamin:</label>
                <select id="modal-jeniskelamin" name="jeniskelamin" required>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                </select>
                
                <input type="submit" value="Simpan Perubahan">
            </form>
        </div>
    </div>
    
    <script>
        // Get the modal
        var modal = document.getElementById("editModal");
        
        // Function to open the modal with data
        function openModal(nim, nama, jeniskelamin) {
            document.getElementById("modal-nim").value = nim;
            document.getElementById("modal-nama").value = nama;
            document.getElementById("modal-jeniskelamin").value = jeniskelamin;
            modal.style.display = "block";
        }
        
        // Function to close the modal
        function closeModal() {
            modal.style.display = "none";
        }
        
        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>
