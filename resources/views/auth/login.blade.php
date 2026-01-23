<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Akreditasi LPPBJ') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #fff;
            overflow-x: hidden;
        }

        /* --- BAGIAN KANAN (CAROUSEL) --- */
        .bg-accent-gradient {
            background: linear-gradient(160deg, #0d6efd 0%, #063ba8 100%);
            position: relative;
            overflow: hidden;
        }

        .bg-pattern-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.6; z-index: 1;
        }

        .carousel-container { position: relative; z-index: 2; height: 100%; width: 100%; }
        .carousel-item { height: 100vh; }
        
        .carousel-content-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-bottom: 50px;
        }

        .carousel-img {
            max-height: 250px; width: auto; object-fit: contain; margin-bottom: 30px;
            filter: drop-shadow(0 15px 25px rgba(0,0,0,0.25));
            animation: floatImage 6s ease-in-out infinite;
        }

        @keyframes floatImage {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .carousel-indicators { bottom: 30px; }
        .carousel-indicators [data-bs-target] {
            width: 10px; height: 10px; border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4); border: none; margin: 0 6px;
            transition: all 0.3s ease;
        }
        .carousel-indicators .active { background-color: #fff; width: 30px; border-radius: 5px; }


        /* --- BAGIAN KIRI (FORM) --- */
        .form-control-large {
            height: 50px; padding-left: 45px; border-radius: 8px;
            background-color: #f8f9fa; border: 1px solid #e9ecef;
            transition: all 0.3s;
        }
        .form-control-large:focus {
            background-color: #fff; border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .input-icon-wrapper { position: relative; }
        .input-icon-wrapper i.icon {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: #6c757d; z-index: 10;
        }

        /* TOMBOL MATA (SHOW PASSWORD) */
        .password-toggle-btn {
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #6c757d; z-index: 10;
            background: none; border: none; padding: 0;
        }
        .password-toggle-btn:hover { color: #0d6efd; }

        .btn-webapp {
            background: #0d6efd; color: white; font-weight: bold; letter-spacing: 1px;
            border-radius: 8px; transition: 0.3s;
        }
        .btn-webapp:hover {
            background: #0b5ed7; transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .hover-link { color: #6c757d; transition: 0.3s; }
        .hover-link:hover { color: #0d6efd; }
    </style>
</head>
<body>

    <div class="row g-0 vh-100">
        
        <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center bg-white order-2 order-lg-1 position-relative">
            <div class="w-100 p-4 p-md-5" style="max-width: 500px;">
                
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/Logo_LKPP.png') }}" alt="Logo" width="150" class="mb-3">
                    <h3 class="fw-bold text-dark mb-1">Sistem Akreditasi LPPBJ</h3>
                    <p class="text-muted small">Lembaga Kebijakan Pengadaan Barang/Jasa</p>
                </div>

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <div class="input-icon-wrapper">
                            <i class="icon fas fa-user"></i>
                            <input type="email" class="form-control form-control-large @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                        </div>
                        @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <div class="input-icon-wrapper position-relative">
                            <i class="icon fas fa-key"></i>
                            
                            <input type="password" id="passwordInput" 
                                   class="form-control form-control-large @error('password') is-invalid @enderror" 
                                   name="password" placeholder="Kata Sandi" required style="padding-right: 40px;">
                            
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="captcha-box border rounded overflow-hidden flex-shrink-0" style="height: 50px; min-width: 120px;">
                                {!! captcha_img('flat') !!}
                            </div>
                            
                            <button type="button" class="btn btn-light border" style="height: 50px; width: 50px;" 
                                    onclick="refreshCaptcha()" title="Ganti Kode" data-bs-toggle="tooltip">
                                <i class="fas fa-sync-alt text-primary"></i>
                            </button>

                            <input type="text" name="captcha" class="form-control form-control-large text-center m-0" 
                                   placeholder="Kode?" required style="letter-spacing: 2px; font-weight: bold;">
                        </div>
                        @error('captcha') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-webapp py-3 shadow">MASUK SISTEM</button>
                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <a href="#" onclick="alertBuatAkun(event)" class="text-decoration-none small fw-bold hover-link">
                            <i class="fas fa-user-plus me-1"></i> Buat Akun
                        </a>
                        <span class="text-muted opacity-25">|</span>
                        <a href="#" onclick="alertBantuan(event)" class="text-decoration-none small fw-bold hover-link">
                            <i class="fas fa-question-circle me-1"></i> Bantuan
                        </a>
                    </div>
                </form>
            </div>
            <div class="mt-auto pb-3 text-muted small d-lg-none">&copy; {{ date('Y') }} Sistem LPPBJ</div>
        </div>

        <div class="col-lg-6 bg-accent-gradient d-none d-lg-block order-1 order-lg-2 text-white">
            <div class="bg-pattern-overlay"></div>

            <div class="carousel-container">
                <div id="loginCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                    
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="2"></button>
                    </div>

                    <div class="carousel-inner h-100">
                        <div class="carousel-item active">
                            <div class="carousel-content-wrapper px-5 text-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1688/1688394.png" class="carousel-img" alt="Management">
                                <h3 class="fw-bold mb-3">Manajemen Data Terpusat</h3>
                                <p class="opacity-75 lead fs-6 w-75">Platform terintegrasi untuk pengelolaan data akreditasi LPPBJ di seluruh Indonesia.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-content-wrapper px-5 text-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" class="carousel-img" alt="Analysis">
                                <h3 class="fw-bold mb-3">Monitoring Real-time</h3>
                                <p class="opacity-75 lead fs-6 w-75">Pantau perkembangan status akreditasi dan masa berlaku sertifikasi secara langsung.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-content-wrapper px-5 text-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1584/1584892.png" class="carousel-img" alt="Security">
                                <h3 class="fw-bold mb-3">Keamanan Terjamin</h3>
                                <p class="opacity-75 lead fs-6 w-75">Infrastruktur keamanan tinggi untuk menjaga kerahasiaan dan integritas data instansi Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="position-absolute bottom-0 w-100 text-center pb-3 small opacity-50 z-2">
                &copy; {{ date('Y') }} Lembaga Kebijakan Pengadaan Barang/Jasa
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Init Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Script Show/Hide Password
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Script Refresh Captcha
        function refreshCaptcha() {
            $('.fa-sync-alt').addClass('fa-spin');
            $.ajax({
                type: 'GET', url: "{{ route('refresh.captcha') }}",
                success: function (data) {
                    $('.captcha-box').html(data.captcha);
                    $('.fa-sync-alt').removeClass('fa-spin');
                },
                error: function() { $('.fa-sync-alt').removeClass('fa-spin'); }
            });
        }

        function alertBuatAkun(e) {
            e.preventDefault();
            Swal.fire({ icon: 'info', title: 'Registrasi Akun', text: 'Silahkan hubungi Admin IT LPPBJ.', confirmButtonColor: '#0d6efd' });
        }
        function alertBantuan(e) {
            e.preventDefault();
            Swal.fire({ icon: 'question', title: 'Butuh Bantuan?', text: 'Hubungi Customer Service kami.', confirmButtonColor: '#0d6efd' });
        }
    </script>
</body>
</html>