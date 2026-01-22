@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body bg-light rounded">
            <p class="mb-1">Selamat datang, <strong>{{ Auth::user()->name }}!</strong></p>
            <p class="mb-1 text-muted">Statistik di samping menggambarkan komposisi kategori LPPBJ saat ini.</p>
            <ul class="mb-1 ps-3 small text-muted">
                <li>Gunakan menu <strong>Data LPPBJ</strong> untuk mengelola data.</li>
                <li>Data yang ditampilkan di sini adalah <strong>Real-Time</strong>.</li>
            </ul>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h6 class="text-uppercase opacity-75">Total LPPBJ</h6>
                    <h2 class="display-4 fw-bold mb-0">{{ $total }}</h2>
                    <span class="small">Unit Terdaftar</span>
                    <hr class="my-2 border-white opacity-50">
                    <div class="d-flex justify-content-between small">
                        <span>Total Instansi:</span>
                    </div>
                    <div class="d-flex justify-content-between small fw-bold">
                        <span>Pemerintahan: {{ $pemerintah }}</span>
                        <span>Non: {{ $nonPemerintah }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h6 class="text-uppercase opacity-75">Kategori Unggul</h6>
                    <h2 class="display-4 fw-bold mb-0">{{ $kategoriA }}</h2>
                    <span class="small">LPPBJ Kategori A</span>

                    <hr class="my-2 border-white opacity-50">

                    <div class="small">
                        {{ round(($kategoriA / $total) * 100, 1) }}% dari total LPPBJ
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h6 class="text-uppercase opacity-75">Perhatian Segera</h6>
                    <h2 class="display-4 fw-bold mb-0">{{ $expiredSoon }}</h2>
                    <span class="small">LPPBJ akan habis masa berlaku (< 3 Bulan)</span>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-center mb-4">Lembaga Pelatihan PBJ (LPPBJ) Dan Pelaksana Ujian PBJ</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="akreditasi-tab" data-bs-toggle="tab" data-bs-target="#akreditasi" type="button" role="tab">Berdasarkan Akreditasi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="pengajuan-tab" data-bs-toggle="tab" data-bs-target="#pengajuan" type="button" role="tab">Berdasarkan Proses Pengajuan</button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                
                <div class="tab-pane fade show active" id="akreditasi" role="tabpanel">
                    
                    <h5 class="fw-bold text-primary mb-3 mt-3 text-center">Total LPPBJ: {{ $total }}</h5>

                    <div class="row mb-5">
                        <div class="col-md-6 text-center">
                            <h6>Komposisi Instansi</h6>
                            <div style="max-height: 300px; display: flex; justify-content: center;">
                                <canvas id="chartInstansi"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h6>Status Akreditasi (Kategori)</h6>
                            <div style="max-height: 300px; display: flex; justify-content: center;">
                                <canvas id="chartAkreditasi"></canvas>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2 small fw-bold text-muted">Tampilkan</span>
                            <select id="perPageAkreditasi" class="form-select form-select-sm" style="width: auto;">
                                @foreach([10,15,25,50,100] as $num)
                                    <option value="{{ $num }}" {{ $perPage == $num ? 'selected' : '' }}>{{ $num }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="searchAkreditasi" class="form-control" placeholder="Cari data..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div id="tableContainerAkreditasi">
                        @include('partials.table_akreditasi')
                    </div>
                </div>

                <div class="tab-pane fade" id="pengajuan" role="tabpanel">
                    
                    <h5 class="fw-bold text-success mb-3 mt-3 text-center">Total Pengajuan: {{ $total }}</h5>
                    
                    <div class="row mb-5">
                         <div class="col-md-6 text-center">
                            <h6>Kategori Instansi</h6>
                            <div style="max-height: 300px; display: flex; justify-content: center;">
                                <canvas id="chartPengajuanInstansi"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h6>Status Pengajuan (Masa Berlaku)</h6>
                            <div style="max-height: 300px; display: flex; justify-content: center;">
                                <canvas id="chartPengajuanStatus"></canvas>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2 small fw-bold text-muted">Tampilkan</span>
                            <select id="perPagePengajuan" class="form-select form-select-sm" style="width: auto;">
                                @foreach([10,15,25,50,100] as $num)
                                    <option value="{{ $num }}" {{ $perPage == $num ? 'selected' : '' }}>{{ $num }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="searchPengajuan" class="form-control" placeholder="Cari data..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div id="tableContainerPengajuan">
                         @include('partials.table_pengajuan')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ==========================================
    // 1. KONFIGURASI CHART.JS
    // ==========================================
    const dataPemerintah = {{ $pemerintah }};
    const dataNon = {{ $nonPemerintah }};
    const dataKatA = {{ $kategoriA }};
    const dataKatB = {{ $kategoriB }};
    const sBerlaku = {{ $statBerlaku }};
    const sKurang3 = {{ $statKurang3Bulan }};
    const sKurang6 = {{ $statKurang6Bulan }};
    const sExpired = {{ $statTidakBerlaku }};

    // Chart Instansi (Tab 1)
    new Chart(document.getElementById('chartInstansi').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Pemerintah', 'Non-Pemerintah'],
            datasets: [{ data: [dataPemerintah, dataNon], backgroundColor: ['#0d6efd', '#6c757d'], borderWidth: 1 }]
        }
    });

    // Chart Akreditasi A/B (Tab 1)
    new Chart(document.getElementById('chartAkreditasi').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Akreditasi A', 'Akreditasi B'],
            datasets: [{ data: [dataKatA, dataKatB], backgroundColor: ['#198754', '#0dcaf0'], borderWidth: 1 }]
        }
    });

    // Chart Instansi (Tab 2)
    new Chart(document.getElementById('chartPengajuanInstansi').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Pemerintah', 'Non-Pemerintah'],
            datasets: [{ data: [dataPemerintah, dataNon], backgroundColor: ['#0d6efd', '#6c757d'], borderWidth: 1 }]
        }
    });

    // Chart Status Berlaku (Tab 2)
    new Chart(document.getElementById('chartPengajuanStatus').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Berlaku', '< 3 Bulan', '< 6 Bulan', 'Tidak Berlaku'],
            datasets: [{ data: [sBerlaku, sKurang3, sKurang6, sExpired], backgroundColor: ['#198754', '#ffc107', '#0dcaf0', '#dc3545'], borderWidth: 1 }]
        }
    });

    // ==========================================
    // 2. LOGIKA AJAX (SEARCH & PAGINATION)
    // ==========================================
    $(document).ready(function() {
        
        // Fungsi Generic untuk ambil data tabel via AJAX
        function fetchTable(tab, perPage, search, containerId) {
            $.ajax({
                url: "{{ route('home') }}",
                type: "GET",
                data: {
                    tab: tab,
                    per_page: perPage,
                    search: search
                },
                beforeSend: function() {
                    $(containerId).css('opacity', '0.5'); // Efek loading
                },
                success: function(response) {
                    $(containerId).html(response);
                    $(containerId).css('opacity', '1');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    alert('Gagal memuat data. Silakan reload.');
                }
            });
        }

        let searchTimer;

        // --- LISTENER TAB 1: AKREDITASI ---
        $('#perPageAkreditasi, #searchAkreditasi').on('change keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                let perPage = $('#perPageAkreditasi').val();
                let search = $('#searchAkreditasi').val();
                fetchTable('akreditasi', perPage, search, '#tableContainerAkreditasi');
            }, 500); // Delay 500ms agar tidak spam request saat ngetik
        });

        // Handle Klik Pagination Tab 1
        $(document).on('click', '#tableContainerAkreditasi .pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href'); // Ambil URL dari link pagination
            $('#tableContainerAkreditasi').css('opacity', '0.5');
            $.get(url, function(data) {
                $('#tableContainerAkreditasi').html(data);
                $('#tableContainerAkreditasi').css('opacity', '1');
            });
        });


        // --- LISTENER TAB 2: PENGAJUAN ---
        $('#perPagePengajuan, #searchPengajuan').on('change keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                let perPage = $('#perPagePengajuan').val();
                let search = $('#searchPengajuan').val();
                fetchTable('pengajuan', perPage, search, '#tableContainerPengajuan');
            }, 500);
        });

        // Handle Klik Pagination Tab 2
        $(document).on('click', '#tableContainerPengajuan .pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $('#tableContainerPengajuan').css('opacity', '0.5');
            $.get(url, function(data) {
                $('#tableContainerPengajuan').html(data);
                $('#tableContainerPengajuan').css('opacity', '1');
            });
        });

    });
</script>
@endsection