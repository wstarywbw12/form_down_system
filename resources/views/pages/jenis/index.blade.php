@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Jenis</h4>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Jenis</h5>
                    <button class="btn btn-dark" onclick="openAddModal()">
                        <i class="ri-add-line"></i> Tambah Data
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Jenis</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->jenis }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm"
                                                onclick="openEditModal('{{ $item->id }}','{{ $item->jenis }}')">
                                                Ubah
                                            </button>

                                            <form action="{{ route('jenis.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin hapus data?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($data->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">Data tidak tersedia</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="dataForm" method="POST">
                @csrf
                <input type="hidden" id="methodField" name="_method">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="dataModalLabel">Form Jenis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" required>
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
            $('#dataModalLabel').text('Tambah Jenis');
            $('#dataForm').attr('action', "{{ route('jenis.store') }}");
            $('#methodField').val('');
            $('#jenis').val('');
            $('#dataModal').modal('show');
        }

        function openEditModal(id, jenis) {
            $('#dataModalLabel').text('Ubah Jenis');
            $('#dataForm').attr('action', '/jenis/' + id);
            $('#methodField').val('PUT');
            $('#jenis').val(jenis);
            $('#dataModal').modal('show');
        }
    </script>
@endpush
