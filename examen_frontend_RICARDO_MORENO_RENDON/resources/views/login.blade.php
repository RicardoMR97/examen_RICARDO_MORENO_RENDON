<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Asegúrate de tener el CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container py-3">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="card col-sm-8">
                <div class="card-header">
                    <h2>Iniciar sesión</h2>
                </div>
                <div class="card-body">
                    <!-- Formulario de inicio de sesión -->
                    <form id="loginForm">
                        <div class="form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div><br>
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </form>

                    <!-- Mostrar errores o mensajes -->
                    <div id="errorMessage" class="alert alert-danger mt-2" style="display:none;"></div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            $.ajax({
                type: "POST",
                url: 'http://localhost/examen_backend_RICARDO_MORENO_RENDON/login',
                data:{
                    email: email,
                    password: password
                },
                success: function(response, textStatus, jqXHR) {
                    if (response.error) {
                        document.getElementById('errorMessage').style.display = 'block';
                        document.getElementById('errorMessage').innerText = data.error;
                    } else {
                        // Redirigir al listado de usuarios tras el inicio de sesión exitoso
                        window.location.href = 'http://localhost/examen_frontend_RICARDO_MORENO_RENDON/users';
                    }

                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                if (jqXHR.status === 205) {
                    alertify.warning("El documento ya ha sido cambiado de estatus.");
                }else
                    alertify.error("El cambio de estatus no pudo realizarse correctamente.");
                }
            });
        });
    </script>
</body>
</html>
