@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Starter</h4>

                <div class="page-title-right">
                    <!-- Buttons with Label Right -->
                    <button type="button" class="btn btn-dark btn-label waves-effect right waves-light" data-bs-toggle="modal" data-bs-target="#exampleModalgrid"><i
                            class="ri-filter-line label-icon align-middle fs-16 ms-2"></i> Filter</button>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        @for ($i = 0; $i < 8; $i++)
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Triase</h4>
                    </div>
                    <div class="card-body">
                        <p>Send a link to apply on mobile device. Appropriately communicate one-to-one technology.</p>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary btn-label waves-effect waves-light"><i
                                    class="ri-eye-line label-icon align-middle fs-16 me-2"></i> Lihat</button>
                            <button type="button" class="btn btn-secondary btn-label waves-effect waves-light"><i
                                    class="ri-download-line label-icon align-middle fs-16 me-2"></i> Download</button>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    @include('pages.dashboard.modal')
@endsection
