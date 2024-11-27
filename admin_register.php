<?php
include('dbconnect.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    if (empty($admin_name) || empty($admin_password)) {
        $error_message = "Bitte füllen Sie alle Felder aus.";
    } else {
        $hashedPassword = password_hash($admin_password, PASSWORD_DEFAULT);

        $sql = "SELECT admin_id FROM admins WHERE admin_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $admin_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Adminname bereits vergeben. Bitte wählen Sie einen anderen.";
        } else {
            $sql = "INSERT INTO admins (admin_name, admin_password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $admin_name, $hashedPassword);

            if ($stmt->execute()) {
                $success_message = "Registrierung erfolgreich! Sie können sich jetzt anmelden.";
                header("Location: adminlogin.php");
                exit();
            } else {
                $error_message = "Fehler bei der Registrierung. Bitte versuchen Sie es später erneut.";
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
</head>
<body>
    <h1>Registrieren</h1>

    <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
    <?php if (isset($success_message)) { echo "<p style='color: green;'>$success_message</p>"; } ?>

    <form action="admin_register.php" method="POST">
        <label for="admin_name">Benutzername:</label>
        <input type="text" id="admin_name" name="admin_name" required><br><br>
        
        <label for="admin_password">Passwort:</label>
        <input type="password" id="admin_password" name="admin_password" required><br><br>
        
        <input type="submit" value="Registrieren">
    </form>

    <p>Haben Sie bereits ein Konto? <a href="adminlogin">Hier anmelden</a></p>
</body>
</html>
