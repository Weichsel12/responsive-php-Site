<?php
include('dbconnect.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $postal_code = $_POST['postal_code'];

    // Validierung der Eingaben
    if (empty($username) || empty($password) || empty($confirm_password) || empty($address) || empty($postal_code)) {
        $error_message = "Bitte füllen Sie alle Felder aus.";
    } elseif (!preg_match("/^\d{4}$/", $postal_code)) {
        $error_message = "Die Postleitzahl muss genau 4 Ziffern enthalten.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Die Passwörter stimmen nicht überein.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Benutzername bereits vergeben. Bitte wählen Sie einen anderen.";
        } else {
            $sql = "INSERT INTO users (username, password, address, postal_code) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $hashedPassword, $address, $postal_code);

            if ($stmt->execute()) {
                $success_message = "Registrierung erfolgreich! Sie können sich jetzt anmelden.";
                header("Location: index.php");
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

    <form action="register.php" method="post">
        <label for="username">Benutzername:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Passwort bestätigen:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        
        <label for="address">Adresse:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="postal_code">Postleitzahl:</label>
        <input type="text" id="postal_code" name="postal_code" required><br><br>

        <input type="submit" value="Registrieren">
    </form>

    <p>Haben Sie bereits ein Konto? <a href="index.php">Hier anmelden</a></p>
</body>
</html>
