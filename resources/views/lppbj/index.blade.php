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
            
            <form action="{{ route('lppbj.index') }}" method="GET" class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-bold">Tampilkan</span>
                        <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            @foreach([10, 15, 25, 50, 75, 100] as $num)
                                <option value="{{ $num }}" {{ request('per_page', 15) == $num ? 'selected' : '' }}>
                                    {{ $num }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama LPPBJ..." value="{{ request('search') }}">
                        <button class="btn btn-secondary" type="submit">Cari</button>
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
                                    
                                    @if(Auth::user()->role == 'admin')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('lppbj.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
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
                    {{ $data->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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