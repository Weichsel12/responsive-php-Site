<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Herzlich willkommen</h1>
<form action="login.php" method="post">
    <input type="text" placeholder="username" id="username" name="username">
    <input type="password" placeholder="password" id="password" name="password">
    <input type="submit" name="login" value="Anmelden">
    <br />
</form>
<form action="register.php" method="post">
    <p>Sie haben noch keinen Account?
        <br />
        Dann einfach Registrieren.
    </p>
    <input type="submit" name="register" value="Registrieren">
</form>
    
</body>
</html>