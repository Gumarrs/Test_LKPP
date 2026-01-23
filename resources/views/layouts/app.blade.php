<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* --- STYLING SIDEBAR --- */
        .sidebar {
            min-height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        /* --- STYLING KONTEN --- */
        .main-content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Logic Toggle Sidebar */
        body.sb-hidden .sidebar { margin-left: -280px; }
        body.sb-hidden .main-content { margin-left: 0; width: 100%; }

        /* --- STYLING MENU SIDEBAR --- */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .sidebar .nav-link:hover {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            background-color: #fff !important;
            color: #0d6efd !important;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 768px) {
            .sidebar { margin-left: -280px; }
            .main-content { margin-left: 0; width: 100%; }
            body.sb-hidden .sidebar { margin-left: 0; }
        }
    </style>
</head>
<body class=""> 
    
    <div id="app">
        
        <nav class="sidebar p-3 d-flex flex-column" id="sidebar">
            <a href="{{ route('home') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="bi bi-shield-check fs-2 me-2"></i>
                <span class="fs-5 fw-bold">Sistem LPPBJ</span>
            </a>
            <hr class="text-white opacity-50">
            
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('lppbj.index') }}" class="nav-link {{ request()->is('lppbj*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Data LPPBJ
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Manajemen Akun
                    </a>
                </li>
                @endif
            </ul>

        <div class="mt-auto pt-4 pb-3 border-top border-white border-opacity-25 text-center">
            <div class="bg-white p-2 rounded-circle d-inline-flex justify-content-center align-items-center shadow-sm mb-3" style="width: 80px; height: 80px;">
                <img src="{{ asset('assets/images/Logo_LKPP.png') }}" 
                    alt="Logo LKPP" 
                    class="img-fluid" 
                    style="max-height: 100%; max-width: 100%; object-fit: contain;">
            </div>
                    
            <div class="text-white small lh-sm">
                <div class="fw-bold text-uppercase" style="letter-spacing: 1px;">Lembaga Kebijakan</div>
                <div class="opacity-75" style="font-size: 0.75rem;">Pengadaan Barang/Jasa</div>
            </div>
        </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </nav>


        <main class="main-content">
            
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4 px-3 py-2">
                <div class="d-flex align-items-center w-100">
                    
                    <button class="btn btn-light me-3 border" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <span class="fw-bold text-dark fs-5 d-none d-md-block">
                        @if(request()->is('home')) Dashboard
                        @elseif(request()->is('lppbj*')) Data LPPBJ
                        @elseif(request()->is('users*')) Manajemen Akun
                        @elseif(request()->is('profile*')) Profile Pengguna
                        @else Sistem Akreditasi
                        @endif
                    </span>

                    <div class="ms-auto"></div>

                    <div class="d-flex align-items-center gap-3">
                        
                        <div class="d-none d-md-flex align-items-center text-muted small border-end pe-3">
                            <i class="bi bi-calendar3 me-2"></i>
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                        </div>

                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="text-end me-2 d-none d-md-block">
                                    <div class="fw-bold small">{{ Auth::user()->name ?? 'User' }}</div>
                                    <div class="text-muted" style="font-size: 10px; text-transform: uppercase;">
                                        {{ Auth::user()->role ?? 'Guest' }}
                                    </div>
                                </div>
                                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="dropdownUser1">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2"></i> Profile Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger d-flex align-items-center" href="#" onclick="event.preventDefault(); logoutConfirm();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sign out
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </nav>

            @yield('content')
        </main>
    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Logout Logic
        function logoutConfirm() {
            Swal.fire({
                title: 'Keluar?',
                text: "Sesi Anda akan berakhir.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('logout-form').submit();
            })
        }

        // Sidebar Toggle Logic
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.querySelector('#sidebarToggle');
            if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                document.body.classList.add('sb-hidden');
            }
            sidebarToggle.addEventListener('click', function (event) {
                event.preventDefault();
                document.body.classList.toggle('sb-hidden');
                localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-hidden'));
            });
        });
    </script>
</body>
</html>