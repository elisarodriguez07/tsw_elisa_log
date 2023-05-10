<?php
    // inicio de sesión
    session_start();

    // revisamos si el usuario no está conectado, si es así se redirecciona al inicio de sesión
    if (empty($_SESSION["userid"])) {
        header("Location: login.php");
        exit;
    }

    require_once "config.php"; 

    // buscamos los datos del usuario por su ID
    $stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION["userid"]]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // si no encontramos al usuario, lo redireccionamos al inicio de sesión
    if (!$user) {
        header("Location: login.php");
        exit;
    }

    /*if (isset($_SESSION["userid"])) {
        header("location: login.php");
        exit;
    }*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Interfaz</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
        <!-- Custom CSS -->
        <link rel="stylesheet" href="interfaz.css" />

        <style type="text/css">
            h1{
                color: white;
            }
        </style>

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <h1>Hola, <strong><?php echo $user['name']; ?></strong>.<br> Bienvenido a tu sitio</h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="#">Home</a>
                        <a class="nav-link" href="#">Features</a>
                        <a class="nav-link" href="#">Pricing</a>
                        <a href="cerrarSesion.php" class="nav-link" role="button" aria-pressed="true">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container my-3">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 py-4 bg-white">
                    <h2>Formulario de Lenguajes</h2>
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Lenguaje</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Lenguaje" autofocus />
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" placeholder="Descripción del lenguaje" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="programadores" class="form-label">Número de Programadores</label>
                            <input type="number" class="form-control" id="programadores" />
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success">Guardar</button>
                            <button class="btn btn-secondary">Limpiar</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 py-4 bg-white">
                    <h2>Listado de lenguajes</h2>
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th class="centrado">#</th>
                                <th class="centrado">Lenguaje</th>
                                <th class="centrado">Cantidad de programadores</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="centrado">1</td>
                                <td class="centrado">JavaScript</td>
                                <td class="centrado">21</td>
                            </tr>
                            <tr>
                                <td class="centrado">2</td>
                                <td class="centrado">Python</td>
                                <td class="centrado">110</td>
                            </tr>
                            <tr>
                                <td class="centrado">3</td>
                                <td class="centrado">C#</td>
                                <td class="centrado">45</td>
                            </tr>
                            <tr>
                                <td class="centrado">4</td>
                                <td class="centrado">Ruby</td>
                                <td class="centrado">31</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>