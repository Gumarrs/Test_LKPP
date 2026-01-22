@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Data LPPBJ</div>

                <div class="card-body">
                    <form action="{{ route('lppbj.store') }}" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label">Nama LPPBJ</label>
                            <input type="text" name="nama_lppbj" class="form-control @error('nama_lppbj') is-invalid @enderror" value="{{ old('nama_lppbj') }}">
                            @error('nama_lppbj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kriteria</label>
                            <select name="kriteria" class="form-select @error('kriteria') is-invalid @enderror">
                                <option value="">-- Pilih Kriteria --</option>
                                <option value="Pemerintah" {{ old('kriteria') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                <option value="Non-Pemerintah" {{ old('kriteria') == 'Non-Pemerintah' ? 'selected' : '' }}>Non-Pemerintah</option>
                            </select>
                            @error('kriteria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="A" {{ old('kategori') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('kategori') == 'B' ? 'selected' : '' }}>B</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai Akreditasi</label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Habis Berlaku</label>
                            <input type="date" name="masa_berlaku" class="form-control @error('masa_berlaku') is-invalid @enderror" value="{{ old('masa_berlaku') }}">
                            @error('masa_berlaku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lppbj.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection