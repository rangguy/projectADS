<?php
session_start();
session_destroy();
?> 
    <script>
        alert("Berhasil logout");
        document.location = "../index.php";
    </script>
<?php
?>