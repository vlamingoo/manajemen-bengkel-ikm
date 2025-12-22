<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Manajemen Bengkel</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        .register-page {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .register-box {
            width: 400px;
        }
        .register-logo {
            font-size: 35px;
            font-weight: 300;
            margin-bottom: 25px;
        }
        .register-logo b {
            font-weight: 700;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .input-group-text {
            border-radius: 25px 0 0 25px;
        }
        .form-control {
            border-radius: 0 25px 25px 0;
            border-left: none;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
        }
    </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <b>Manajemen</b> Bengkel
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">
                <i class="fas fa-user-plus text-primary"></i> 
                Daftar Akun Baru
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-group mb-3">
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nama Lengkap"
                           value="{{ old('name') }}"
                           required 
                           autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email"
                           value="{{ old('email') }}"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <input type="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="input-group mb-3">
                    <input type="password" 
                           name="password_confirmation" 
                           class="form-control" 
                           placeholder="Konfirmasi Password"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <p class="mb-0 text-center">
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login di sini
                </a>
            </p>
        </div>
    </div>

    <div class="text-center mt-3">
        <small class="text-white">
            <i class="fas fa-copyright"></i> {{ date('Y') }} Manajemen Bengkel. All rights reserved.
        </small>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>