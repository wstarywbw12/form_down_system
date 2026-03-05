@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Username</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
                        <li class="breadcrumb-item active">Username</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Username</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-dark" onclick="openAddModal()">
                            <i class="ri-add-line"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-nowrap ">
                            <thead>
                                <tr>
                                    <th width="4%" class="text-end">No.</th>
                                    <th width="17%">Username</th>
                                    <th width="20%">Email</th>
                                    <th>Role</th>
                                    <th width="13%" class="text-center"><i class="bx bx-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="4%" class="text-center">1</td>
                                    <td>Jhon</td>
                                    <td>jhon@example.com</td>
                                    <td>Admin</td>
                                    <td width="13%" class="text-end">
                                        <button class="btn btn-info btn-sm mr-1 align-middle">
                                            <i class="bx bxs-edit align-middle"></i> Ubah
                                        </button>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger  btn-delete"
                                            data-url="">
                                            <i class="bx bx-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Ubah -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="dataForm" action="" method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-content">
                    <div class="modal-header py-3 bg-light">
                        <h5 class="modal-title" id="dataModalLabel">Form Jenis</h5>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">--Pilih--</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="ri-close-line"></i> Tutup
                            </button>
                            <button type="submit" class="btn btn-dark">
                                <i class="ri-save-line"></i> Simpan
                            </button>
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
            $('#dataForm')[0].reset();
            $('#id').val('');
            $('#dataModal').modal('show');
        }

        function openEditModal(id, jenis) {
            $('#dataModalLabel').text('Ubah Jenis');
            $('#id').val(id);
            $('#jenis').val(jenis);
            $('#dataModal').modal('show');
        }
    </script>
@endpush
