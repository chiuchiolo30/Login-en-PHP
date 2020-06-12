<?php session_start();

# Validando que no haya una sesión activa
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
# Válido que el método de envío sea POST y guardo los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario    = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $password   = strtolower($_POST['password']);
    $password2  = strtolower($_POST['password2']);

    # Variables para setear los errores
    $errores = '';

    # Validar que los campos no esten vacio
    if (empty($usuario) or empty($password) or empty($password2) ) {
        $errores .= '<li>Por favor rellena todos los campos correctamente</li>';
    } else {
    # Validar que el usuario no exista en la base de datos
        # Conecto a la DB
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=login_practica','root','');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        # preparamos la consulta
        $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');

        # ejecutamos la consulta
        $statement->execute(array(
            ':usuario' => $usuario
        ));
        # Guarda el resultado de la consulta, si regresa false, el usuario no existe y lo podemos registrar, al contrario, no.
        $resultado = $statement->fetch();

        if (!$resultado) {
            # El usuario no existe en la DB, lo puedo registrar.
            # Válido que las contraseñas sean iguales
            if ($password != $password2) {
                $errores .= '<li>Las contraseñas no son iguales.</li>';
            } else {
                # hashing del password
                $password = password_hash($password, PASSWORD_ARGON2I);

                # preparo la consulta, REGISTRO DE USUARIO
                $statement = $conexion->prepare('INSERT INTO usuarios(id, usuario, pass) VALUES(null, :usuario, :pass)');

                # Ejecutamos la consulta
                $statement->execute(array(
                    ':usuario' => $usuario,
                    ':pass'    => $password
                ));
                # Redirigimos al login
               header('Location: login.php');

            }
        } else {
            # El usuario ya existe en la DB.
            $errores .= '<li>El nombre de usuario ya existe</li>';
        }
        
    }
}
 require 'views/registrate.view.php';
    
?>