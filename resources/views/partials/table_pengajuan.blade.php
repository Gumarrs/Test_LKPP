                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="table-dark small">
                                <tr>
                                    <th>No</th>
                                    <th>Instansi</th>
                                    <th>Kategori Instansi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tableData as $key => $item)
                                <tr>
                                    <td>{{ $tableData->firstItem() + $key }}</td>
                                    <td>{{ $item->nama_lppbj }}</td>
                                    <td>{{ $item->kriteria }}</td>
                                    <!-- <td>{{ \Carbon\Carbon::parse($item->masa_berlaku)->format('d-m-Y') }}</td> -->
                                    <td>
                                        @if($item->status == 'Tidak Berlaku')
                                            <span class="badge bg-danger">Tidak Berlaku</span>
                                        @elseif($item->status == '< 3 Bulan')
                                            <span class="badge bg-warning text-dark">< 3 Bulan</span>
                                        @elseif($item->status == '< 6 Bulan')
                                            <span class="badge bg-info text-dark">< 6 Bulan</span>
                                        @else
                                            <span class="badge bg-success">Berlaku</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">{{ $tableData->links() }}</div>
                </div>