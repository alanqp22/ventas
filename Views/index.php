<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SVFE</title>
    <link href="<?= base_url ?>Assets/css/styles.css" rel="stylesheet" />
    <script src="<?= base_url ?>Assets/js/fontawesome.all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Iniciar sesión</h3>
                                </div>
                                <div class="card-body">
                                    <form id="frmLogin">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="nick" name="nick" type="text" placeholder="Nombre de Usuario" />
                                            <label for="nick"><i class="fas fa-user"></i> Usuario</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="clave" name="clave" type="password" placeholder="Contraseña" />
                                            <label for="clave"> <i class="fas fa-key"></i> Contraseña</label>
                                        </div>
                                        <div id="alert" class="alert alert-danger d-none" role="alert">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                                            <button onclick="frmLogin(event);" class="btn btn-primary" type="submit">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; www.alden.web.app <?= date('Y') ?></div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url ?>Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url ?>Assets/js/scripts.js"></script>
    <script>
        const base_url = "<?= base_url ?>";
    </script>
    <script src="<?= base_url ?>Assets/js/funciones.js"></script>

</body>

</html>