<?php
include 'database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';


    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $message = 'Todos los campos son obligatorios.';
    } else {

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password_hash) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $first_name, $last_name, $email, $password_hash);


        if ($stmt->execute()) {
            $message = 'Usuario creado exitosamente.';
        } else {
            $message = 'Error al registrar el usuario.';
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Registro de Usuario</title>

</head>


<body>

    <?php
    include 'partials/header.php';
    ?>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>


    <main>
        <h1>Por favor, Registrese</h1>
        <form method="post" action="signup.php">
            <input type="text" name="first_name" required placeholder="Nombre">
            <input type="text" name="last_name" required placeholder="Apellido">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Contraseña">
            <input type="submit" value="Registrar">
        </form>
    </main>

    <?php include 'partials/footer.php'; ?>
</body>

</html>