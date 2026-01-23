@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0 fw-bold">Manajemen Data LPPBJ</h5>

            <div class="d-flex gap-2">
                @if(Auth::user()->role !== 'asesor')
                    <a href="{{ route('lppbj.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Data
                    </a>
                @endif

                <a href="{{ route('lppbj.export') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
        
        <div class="card-body">
            
            <form action="{{ route('lppbj.index') }}" method="GET" class="mb-4">
                <div class="row g-2 align-items-center">
                    
                    <div class="col-auto">
                        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach([10, 15, 25, 50, 100] as $num)
                                <option value="{{ $num }}" {{ request('per_page', 15) == $num ? 'selected' : '' }}>
                                    {{ $num }} Data
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <select name="filter_kategori" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Kategori --</option>
                            <option value="Pemerintah" {{ request('filter_kategori') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                            <option value="Non-Pemerintah" {{ request('filter_kategori') == 'Non-Pemerintah' ? 'selected' : '' }}>Non-Pemerintah</option>
                        </select>
                    </div>


                    <div class="col-auto">
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru diinput</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama diinput</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                        </select>
                    </div>

                    <div class="col-auto ms-auto d-flex gap-1">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Nama..." value="{{ request('search') }}" style="width: 200px;">
                        <button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-search"></i></button>
                        
                        @if(request()->hasAny(['search', 'filter_kategori', 'filter_status', 'sort']))
                            <a href="{{ route('lppbj.index') }}" class="btn btn-outline-danger btn-sm" title="Reset Filter">
                                reset
                            </a>
                        @endif
                    </div>

                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr class="text-left">
                            <th width="5%">No</th>
                            <th>Nama LPPBJ</th>
                            <th>Kriteria</th>
                            <th>Kategori</th>
                            <th>Masa Berlaku</th>
                            <th>Status Akreditasi</th>
                            @if(Auth::user()->role !== 'asesor')
                            <th class="text-center" width="15%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $key }}</td>
                            <td>{{ $item->nama_lppbj }}</td>
                            <td>{{ $item->kriteria }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} 
                                <br><small class="text-muted">s/d</small><br>
                                {{ \Carbon\Carbon::parse($item->masa_berlaku)->format('d M Y') }}
                            </td>
                            <td>
                                @php $status = $item->status; @endphp
                                @if($status == 'Tidak Berlaku')
                                    <span class="badge bg-danger">{{ $status }}</span>
                                @elseif($status == '< 3 Bulan')
                                    <span class="badge bg-warning text-dark">{{ $status }}</span>
                                @elseif($status == '< 6 Bulan')
                                    <span class="badge bg-info text-dark">{{ $status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $status }}</span>
                                @endif
                            </td>
                            @if(Auth::user()->role !== 'asesor')
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('lppbj.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    
                                    
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('lppbj.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted p-4">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Menampilkan {{ $data->firstItem() }} sampai {{ $data->lastItem() }} dari {{ $data->total() }} data
                </div>
                
                <div>
                    {{-- PENTING: appends(request()->query()) menjaga filter tetap ada saat pindah halaman --}}
                    {{ $data->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>