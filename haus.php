<?php
session_start();
include('dbconnect.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM haus";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Häuser</title>
</head>
<body>
    <h1>Liste aller Häuser</h1>
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Adresse</th>
                <th>Download</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['bezeichnung']; ?></td>
                    <td><?php echo $row['adresse']; ?></td>
                    <td><a href="<?php echo $row['pfad']; ?>" Download>Download PDF</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Keine Häuser gefunden.</p>
    <?php endif; ?>
</body>
</html>
