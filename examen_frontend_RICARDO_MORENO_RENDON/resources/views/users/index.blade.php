<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <title>Listado de Usuarios</title>
    <!-- Añade tus estilos CSS aquí -->
</head>
<body>
    <div class="container py-3">
        <div class="row">
            <h1>Listado de usuarios</h1>

            <table id="tablaUsuarios" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Fecha Nacimiento</th>
                        <th>Edad</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalEditUsuario" tabindex="-1" aria-labelledby="modalEditUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="http://localhost/examen_backend_RICARDO_MORENO_RENDON/updateUsuario" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="_token" id="_token">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ejemplo: 1234567890" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://kit.fontawesome.com/2aefcee4ff.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let csrf_token;
        $(document).ready(function() {
            listaUsuarios();
 

        });

        function listaUsuarios() {
            var tablaUsuarios = $('#tablaUsuarios').DataTable();
            tablaUsuarios.clear().draw();
            
            $.ajax({
                url: "http://localhost/examen_backend_RICARDO_MORENO_RENDON/getUsuarios",  // La URL correcta de la consulta
                type: 'GET',
                success: function(response) {
                    csrf_token = response.csrf_token;
                    $('#tablaUsuarios').DataTable({
                        destroy: true,
                        pageLength: 10,
                        processing: true,
                        stateSave: false,
                        orderCellsTop: true,
                        fixedHeader: false,
                        // BOTONES DE EXCEL Y PDF 
                        dom: 'Bfrtpi',
                        data: response.data,
                        columns: [{
                                data: null,
                                render: function(data, type, row) {
                                    var botones = '';
                                    botones += '<a href="#" class="mx-1 btn-modificar" title="Editar usuario"><i class="fa-solid fa-pen-to-square"></i></a>';
                                    botones += '<a href="#" class="mx-1 btn-eliminar" title="Eliminar usuario"><i class="fa-solid fa-trash"></i></a>';
                                
                                    return botones;
                                }
                            },
                            {
                                data: "Name"
                            },
                            {
                                data: "Email"
                            },
                            {
                                data: "Direccion"
                            },
                            {
                                data: "Telefono"
                            },
                            {
                                data: "FechaNacimiento"
                            },{
                                data: null,
                                render: function(data, type, row) {
                                    return calculaEdad(data.FechaNacimiento);
                                }
                            }
                        ],

                        // Columnas de la tabla
                        columnDefs: [{
                                "width": "10%",
                                targets: [0]
                            },
                            {
                                "width": "15%",
                                targets: [1]
                            },
                            {
                                "width": "15%",
                                targets: [2]
                            },
                            {
                                "width": "15%",
                                targets: [3]
                            },
                            {
                                className: 'text-center',
                                targets: [0, 1, 2, 3, 4]
                            }
                        ],
                        fixedColumns: true,
                        autoWidth: true,
                        order: [
                            [1, "asc"]
                        ]
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function calculaEdad(fechaNacimiento) {
            let fechaActual = new Date();
            fechaNacimiento = new Date(fechaNacimiento);

            let edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
            let mes = fechaActual.getMonth() - fechaNacimiento.getMonth();
            
            if (mes < 0 || (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }
            
            return edad;
        }

        $('#tablaUsuarios').on('click', 'tbody tr td .btn-eliminar', function() {
            let dataTable = $('#tablaUsuarios').DataTable();
            let infoRow = dataTable.row(this.closest('tr')).data();
            Swal.fire({
                title: 'Eliminar usuario?',
                text: "¿Esta seguro(a) que desea eliminar el siguiente usuario?",
                icon: 'question',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando usuario...',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: true,
                        onOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Configura globalmente el token CSRF para todas las solicitudes AJAX
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrf_token
                        }
                    });

                    // Ahora tu solicitud AJAX
                    $.ajax({
                        url: "http://localhost/examen_backend_RICARDO_MORENO_RENDON/deleteUsuario",
                        data: {
                            id: infoRow.id // solo pasas el ID en los datos
                        },
                        type: 'POST',
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message,
                                showCancelButton: false,
                                confirmButtonText: 'Aceptar',
                            }).then(async (result) => {
                                listaUsuarios();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: '¡ERROR!',
                                text: xhr.responseText, // Cambié response.message por xhr.responseText, ya que en error no tienes el objeto de respuesta
                                showCancelButton: false,
                                confirmButtonText: 'Aceptar',
                            });
                        }
                    });
                }
            });
        });

        $('#tablaUsuarios').on('click', 'tbody tr td .btn-modificar', function (event) {
            let dataTable = $('#tablaUsuarios').DataTable();
            let infoRow = dataTable.row(this.closest('tr')).data();

            // Llenar los campos del formulario en el modal con los valores
            $('#id').val(infoRow.id);
            $('#_token').val(csrf_token);
            $('#nombre').val(infoRow.Name);
            $('#email').val(infoRow.Email);
            $('#direccion').val(infoRow.Direccion);
            $('#telefono').val(infoRow.Telefono);
            $('#fecha_nacimiento').val(infoRow.FechaNacimiento);
            $('#modalEditUsuario').modal("show");
        });

    </script>
</body>
</html>

