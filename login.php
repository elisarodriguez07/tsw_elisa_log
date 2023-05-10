<?php
    require_once "config.php"; 
    require_once "session.php";
    require_once "logs.php";

    $error='';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $email = trim($_POST['email']); 
        $password = trim($_POST['password']);
        if(empty($email)){
            $error .= '<p class="error">Por favor ingrese su Correo!</p>';
            write_login_log($email, true, "Email vacio");
        }
        
        if(empty($password)){
            $error .= '<p class="error">Por favor ingrese su contraseña!</p>';
            write_login_log($email, true, "Password vacio");
        }
        if(empty($error)){
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bindParam(1, $email); 
            $stmt->execute();
            $row = $stmt->fetch();

            if($row){
                if(password_verify($password, $row['password'])){
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['user'] = $row;
                    write_login_log($email, false, "");
                    
                    header("Location: welcome.php");
                    exit;
                }else{
                    $error .= '<p class="error">La contraseña no es válida!</p>';
                    write_login_log($email, true, "Contraseña inválida");
                }
            }else{
                $error .= '<p class="error">No se encontro usuario asociado al correo!</p>';
                write_login_log($email, true, "Usuario no encontrado");
            }
        }
    }

    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $id_secret = "6LfZ_9IlAAAAAHn5zA_n1SA4nWnIaVVYWAvbo56z";
        $response = $_POST['g-recaptcha-response'];
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$id_secret}&response={$response}");
        $captcha_success=json_decode($verify);
        if ($captcha_success->success==false) {
            $error .= '<p class="error">Captcha no válido</p>';
            write_login_log($email, true, "Captcha invalido");
        }
    }
?>
<!DOCTYPE html>
<html lang = "es">

<head>
    <title>Sing in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


  
    <link rel="stylesheet" href="style.css">


</head>

<body>
    <div class="login">

        <h1 class="text-center">¡Hola otra vez!</h1>
        
        <form class="needs-validation" method="post" action="">
            <div class="form-group was-validated">
                <label class="form-label" for="email">Correo Electrónico</label>
                <input class="form-control" type="email" id="email" required name="email">
                <div class="invalid-feedback">
                    Por favor ingresa tu correo electrónico
                </div>
            </div>
            <div class="form-group was-validated">
                <label class="form-label" for="password">Contraseña</label>
                <input class="form-control" type="password" id="password" required name="password">
                <div class="invalid-feedback">
                    Por favor ingresa tu contraseña
                    <?php echo $error; ?>
                </div>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" id="check">
                <label class="form-check-label" for="check">Recuérdame</label>
                <div class="g-recaptcha" data-sitekey="6LfZ_9IlAAAAAC4QIgUNs_jhUuFGBZQqyYOrilMZ"></div>
            </div>
            <input class="btn btn-success w-100" type="submit" name="submit" value="SIGN IN">
            <a href="register.php">¿Aún no tienes una cuenta? Crea una aquí</a>
        </form>

    </div>
</body>

</html>

