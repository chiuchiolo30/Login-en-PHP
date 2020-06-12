<?php session_start();


# Validando que no haya una sesión activa
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
}

# Válido que el método de envío sea POST y guardo los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario    = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $password   = strtolower($_POST['password']);

     # Variables para setear los errores
     $errores = '';

    # Validar que los campos no esten vacio
    if (empty($usuario) or empty($password)) {
        $errores .= '<li>Por favor rellena todos los campos correctamente</li>';
    } else {
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
        
         # Válido que exista el usuario en la DB
         if (!$resultado) {
              # El usuario NO existe en la DB.
            $errores .= '<li>Usuario y/o contraseña incorrecta.</li>';
         } else {
             # El usuario existe en la DB, válido que la contraseña sea correcta.
             $passwordDB =  $resultado['pass'];
             if (password_verify($password, $passwordDB)) {
                 # Contraseña correcta, inicio sesión
                 $_SESSION['usuario'] = $usuario;
                 header('Location:index.php');
             } else {
                # Contraseña incorrecta 
                $errores .= '<li>Usuario y/o contraseña incorrecta.</li>';
             }
             

         }
         
    }



}
require 'views/login.view.php';
     
?>