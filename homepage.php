<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('dbconnect.php');

// Benutzer-ID aus der Session holen
$user_id = $_SESSION['user_id'];

$query = "SELECT immos_immo_id FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bereich = $row['immos_immo_id'];

    // Weiterleitung zur jeweiligen Seite basierend auf dem gespeicherten Wert
    if ($bereich == '1') {
        header("Location: haus.php");
        exit();
    } elseif ($bereich == '2') {
        header("Location: wohnung.php");
        exit();
    } elseif ($bereich == '3') {
        header("Location: grund.php");
        exit();
    }
}

// Speichern des ausgewählten Werts, wenn das Formular abgeschickt wird
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $immos = $_POST['immos'];
    
   
    $query = "UPDATE users SET immos_immo_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $immos, $user_id);
    
    if ($stmt->execute()) {
        // Umleitung zur ausgewählten Seite nach Speicherung
        if ($immos == '1') {
            header("Location: haus.php");
            exit();
        } elseif ($immos == '2') {
            header("Location: wohnung.php");
            exit();
        } elseif ($immos == '3') {
            header("Location: grund.php");
            exit();
        }
    } else {
        echo "Fehler beim Speichern.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <form action="homepage.php" method="post">
    <label for="immos">Wählen Sie die Immobilienart die Sie interresiert:</label>
        <select name="immos" id="dog-names">>
            <option value="1">Haus</option>
            <option value="2">Wohnung</option>
            <option value="3">Grund</option>
        </select>
        <input type="submit">
    </form>
</body>
</html>