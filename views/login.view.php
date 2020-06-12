<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0 minimun-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Estilos CSS -->
    <script src="https://kit.fontawesome.com/99b6b523e7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="views/css/style.css">
    <title>Iniciar Sesión</title>
</head>

<body>
    <div class="contenedor">
        <h1 class="titulo">iniciar Sesión</h1>
        <hr class="border">

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login">
            <div class="form-group">
                <i class="icono izquierda fas fa-user"></i><input type="text" name="usuario" class="usuario" placeholder="Usuario">
            </div>
            
            <div class="form-group">
                <i class="icono izquierda fas fa-lock"></i><input type="password" name="password" class="password_btn" placeholder="Contraseña"> <i class="icono submit_btn fas fa-arrow-right" onclick="login.submit()"></i>
            </div>
            <?php if(!empty($errores)): ?>
                <div class="error">
                    <ul>
                        <?php echo $errores ?>
                    </ul>
                </div>
           <?php endif; ?>
        </form>
        <p class="texto-registrate">
            ¿ Aun no tienes cuenta ?
            <a href="registrate.php">
                Registrate
            </a>
        </p>

       
    </div>
</body>

</html>