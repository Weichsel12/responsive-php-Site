<?php
session_start();
include('dbconnect.php');

$error_message = ''; // Initialisieren einer Fehlermeldung

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Benutzer suchen
    $sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Benutzer-ID in der Session speichern
        $_SESSION['user_id'] = $user_id;


        header("Location: homepage.php");
        exit();
    } else {
        $error_message = "Ungültiger Benutzername oder Passwort.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!-- Ausgabe der Fehlermeldung -->
<?php if (!empty($error_message)): ?>
<p><?php echo $error_message; ?></p>
<?php endif; ?>
