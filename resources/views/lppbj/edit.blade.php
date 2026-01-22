@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Data LPPBJ</div>

                <div class="card-body">
                    <form action="{{ route('lppbj.update', $lppbj->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Nama LPPBJ</label>
                            <input type="text" name="nama_lppbj" class="form-control @error('nama_lppbj') is-invalid @enderror" 
                                value="{{ old('nama_lppbj', $lppbj->nama_lppbj) }}">
                            @error('nama_lppbj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kriteria</label>
                            <select name="kriteria" class="form-select @error('kriteria') is-invalid @enderror">
                                <option value="">-- Pilih Kriteria --</option>
                                <option value="Pemerintah" {{ old('kriteria', $lppbj->kriteria) == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                <option value="Non-Pemerintah" {{ old('kriteria', $lppbj->kriteria) == 'Non-Pemerintah' ? 'selected' : '' }}>Non-Pemerintah</option>
                            </select>
                            @error('kriteria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="A" {{ old('kategori', $lppbj->kategori) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('kategori', $lppbj->kategori) == 'B' ? 'selected' : '' }}>B</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai Akreditasi</label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                value="{{ old('tanggal_mulai', $lppbj->tanggal_mulai ? $lppbj->tanggal_mulai->format('Y-m-d') : '') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Habis Berlaku</label>
                            <input type="date" name="masa_berlaku" class="form-control @error('masa_berlaku') is-invalid @enderror" 
                                value="{{ old('masa_berlaku', $lppbj->masa_berlaku->format('Y-m-d')) }}">
                            @error('masa_berlaku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lppbj.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Update Data</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection