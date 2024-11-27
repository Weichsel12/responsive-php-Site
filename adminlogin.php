<?php
session_start();
include('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    // Achte auf die richtige Spaltenbezeichnung (z. B. admin_name)
    $sql = "SELECT admin_id, admin_password FROM admins WHERE admin_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($admin_password, $hashed_password)) {
        $_SESSION['admin_id'] = $admin_id;
        header("Location: adminhome.php");
        exit();
    } else {
        $error_message = "Ungültiger Benutzername oder Passwort.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminLogin</title>
</head>
<body>
    <h1>Herzlich willkommen</h1>
    <!-- Formular für den Login -->
    <form action="adminlogin.php" method="post">
        <input type="text" placeholder="adminname" id="admin_name" name="admin_name" required>
        <input type="password" placeholder="password" id="admin_password" name="admin_password" required>
        <input type="submit" name="adminlogin" value="Anmelden">
        <br />
    </form>

    <!-- Formular für die Registrierung -->
    <form action="admin_register.php" method="post">
        <p>Sie haben noch keinen Account?<br>Dann einfach Registrieren.</p>
        <input type="submit" name="register" value="Registrieren">
    </form>

    <!-- Anzeige der Fehlermeldung, falls vorhanden -->
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
</body>
</html>

