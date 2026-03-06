@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Daftar Form</h5>
            <button class="btn btn-dark" onclick="openAddModal()">Tambah Data</button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Jenis</th>
                            <th>Keterangan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->jenis->jenis }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank">
                                        <span class="btn btn-info btn-sm"><i class="ri-file-line"></i>
                                            Lihat File</span>
                                    </a>
                                    <button class="btn btn-info btn-sm"
                                        onclick="openEditModal(
                                '{{ $item->id }}',
                                '{{ $item->jenis_id }}',
                                '{{ $item->keterangan }}'
                            )">Ubah</button>

                                    <form action="{{ route('forms.destroy', $item->id) }}" method="POST"
                                        style="display:inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="dataModal">
        <div class="modal-dialog">
            <form id="dataForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="methodField" name="_method">

                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="modalTitle">Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Jenis</label>
                            <select class="form-select" id="jenis_id" name="jenis_id" required>
                                <option value="">--Pilih--</option>
                                @foreach ($jenis as $j)
                                    <option value="{{ $j->id }}">{{ $j->jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>

                        <div class="mb-3">
                            <label>File</label>
                            <input type="file" class="form-control" name="file">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah file</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-dark">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openAddModal() {
            $('#modalTitle').text('Tambah Form');
            $('#dataForm').attr('action', "{{ route('forms.store') }}");
            $('#methodField').val('');
            $('#dataForm')[0].reset();
            $('#dataModal').modal('show');
        }

        function openEditModal(id, jenis_id, keterangan) {
            $('#modalTitle').text('Ubah Form');
            $('#dataForm').attr('action', '/forms/' + id);
            $('#methodField').val('PUT');
            $('#jenis_id').val(jenis_id);
            $('#keterangan').val(keterangan);
            $('#dataModal').modal('show');
        }
    </script>
@endpush
