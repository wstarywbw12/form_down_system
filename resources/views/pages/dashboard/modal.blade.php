<div id="exampleModalgrid" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">

        <form action="" method="GET">

            <div class="modal-content">
                <div class="modal-header py-3 bg-light">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="condition">Jenis</label>
                                <select class="form-control js-example-basic-single" name="condition" id="condition"
                                    data-width="100%">
                                    <option value="">-- Semua Jenis --</option>
                                    <option value="Baik" {{ request('condition') == 'Baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="Rusak Ringan"
                                        {{ request('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                                    </option>
                                    <option value="Rusak Berat"
                                        {{ request('condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-danger btn-label waves-effect right waves-light"><i
                        class="ri-refresh-line label-icon align-middle fs-16 ms-2"></i> Reset</a>
                    <button type="submit" class="btn btn-dark btn-label waves-effect right waves-light"><i
                        class="ri-filter-line label-icon align-middle fs-16 ms-2"></i> Filter</button>
                </div>
            </div>

        </form>

    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi js-example-basic-single untuk semua select
            $('.js-example-basic-single').select2({
                dropdownParent: $('#exampleModalgrid'),
                placeholder: "--Pilih--",
                allowClear: false,
                width: '100%'
            });

        });
    </script>
@endpush
