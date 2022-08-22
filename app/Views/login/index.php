<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory | Log in</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css?v=3.2.0">

    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2/sweetalert2.min.css') ?>">
    <script src="<?= base_url('plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">Silahkan<b>Login</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?= form_open('login/cekUser', ['class' => 'formlogin']); ?>
                <?= csrf_field(); ?>
                <label for="username">Username</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Isi Username Anda" name="username" id="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorUsername"></div>
                </div>
                <label for="password">Password</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Isi Password Anda" name="password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorPassword"></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-block btnlogin">Login</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>

        <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="<?= base_url() ?>/dist/js/adminlte.min.js?v=3.2.0"></script>

        <script>
            $(document).ready(function() {
                $('.formlogin').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        beforeSend: function() {
                            $('.btnlogin').prop('disabled', true);
                            $('.btnlogin').html('<i class="fas fa-spinner fa-spin"></i>');
                        },
                        complete: function() {
                            $('.btnlogin').html('Login');
                            $('.btnlogin').prop('disabled', false);
                        },
                        success: function(response) {
                            if (response.error) {
                                if (response.error.username) {
                                    $('#username').addClass('is-invalid');
                                    $('.errorUsername').html(response.error.username);
                                } else {
                                    $('#username').removeClass('is-invalid');
                                    $('.errorUsername').html('');
                                }
                                if (response.error.password) {
                                    $('#password').addClass('is-invalid');
                                    $('.errorPassword').html(response.error.password);
                                } else {
                                    $('#password').removeClass('is-invalid');
                                    $('.errorPassword').html('');
                                }
                            }
                            if (response.sukses) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Login Berhasil !'
                                }).then(result => {
                                    if (result.isConfirmed) {
                                        window.location = response.sukses.link;
                                    }
                                });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                    return false;
                });
            });
        </script>
</body>

</html>