<?php
    require_once 'config.php';

    //Comprobamos si existe el CODE (código de autorización) que es donde se encuentra el token
    if (isset($_GET['code'])) {
        //Cogemos el token del código de acceso
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

        //Si no hay ningún error lo guardamos en el objeto y en una sesión.
        if (!isset($token['error'])) {
            $google_client->setAccessToken($token['access_token']);
            $_SESSION['access_token'] = $token['access_token'];
            
            //Generamos una instancia del siguiente servicio para acceder a los daros del usuario autenticado
            $google_service = new Google\Service\Oauth2($google_client);
            //Obtenemos los datos del usuario autenticado
            $data = $google_service->userinfo->get();


            //Guardamos los datos
            if (!empty($data['given_name'])) {
                $_SESSION['user_first_name'] = $data['given_name'];
            }

            if (!empty($data['family_name'])) {
                $_SESSION['user_last_name'] = $data['family_name'];
            }
    
            if (!empty($data['email'])) {
                $_SESSION['user_email_address'] = $data['email'];
            }
    
            if (!empty($data['gender'])) {
                $_SESSION['user_gender'] = $data['gender'];
            }
    
            if (!empty($data['picture'])) {
                $_SESSION['user_image'] = $data['picture'];
            }
        }
    }

    //En caso de no tenenr ek token de accesso en la sesión nos genera el enlace que nos redirige a iniciar sesión con google.
    if (!isset($_SESSION['access_token'])) {
        $login_button = '<a href="' . $google_client->createAuthUrl() . '" style=" background: #dd4b39; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 200px;">Login With Google</a>';
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login con Google con PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container">
        <br>
        <h2 style="text-align: center;"> Inicio de sesión</h2>
        <br>
        <div>
            <div class="col-lg-4 offset-4">
                <div class="card">
                    <?php
                    if ($login_button == '') {
                        echo '<div class="card-header">Welcome User</div><div class="card-body">';
                        echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
                        echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
                        echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
                        echo '<h3><a href="logout.php">Logout</h3></div>';
                    } else {
                        echo '<div align="center">' . $login_button . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>