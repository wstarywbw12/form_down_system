@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 d-none d-sm-block">Dashboard</h4>

                <div class="page-title-right d-flex gap-2 mb-3 mb-sm-0">
                    <!-- Search Form -->
                    <!-- FORM SEARCH + FILTER -->
                    <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2">

                        <!-- SEARCH -->
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari keterangan..."
                                value="{{ request('search') }}" style="min-width:200px;">

                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line"></i>
                            </button>

                            @if (request('search') || request('jenis_id'))
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            @endif
                        </div>

                        <!-- FILTER JENIS -->
                        <div class="form-group" style="min-width:200px;">
                            <select class="form-control js-example-basic-single" name="jenis_id"
                                onchange="this.form.submit()">

                                <option value="">All</option>

                                @foreach ($jenisList as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ request('jenis_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->jenis }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </form>



                </div>
            </div>
        </div>
    </div>

    <!-- Info Bar (Opsional) -->
    @if (request('search') || request('jenis_id'))
        <div class="row mt-2">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="ri-information-line me-1"></i>
                    Menampilkan hasil filter:
                    @if (request('search'))
                        <span class="badge bg-primary me-1">Pencarian: "{{ request('search') }}"</span>
                    @endif
                    @if (request('jenis_id'))
                        @php
                            $selectedJenis = $jenisList->firstWhere('id', request('jenis_id'));
                        @endphp
                        @if ($selectedJenis)
                            <span class="badge bg-primary">Jenis: {{ $selectedJenis->jenis }}</span>
                        @endif
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Data Cards -->
    <div class="row">
        @forelse ($data as $item)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ $item->jenis->jenis }}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $item->keterangan }}</p>

                        <div class="d-flex justify-content-between">

                            {{-- Tombol Lihat --}}
                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                class="btn btn-primary btn-label waves-effect waves-light">
                                <i class="ri-eye-line label-icon align-middle fs-16 me-2"></i>
                                Lihat
                            </a>

                            {{-- Tombol Download --}}
                            <a href="{{ route('form.download', $item->id) }}"
                                class="btn btn-secondary btn-label waves-effect waves-light">
                                <i class="ri-download-line label-icon align-middle fs-16 me-2"></i>
                                Download
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ri-inbox-line fs-1 text-muted"></i>
                        <h5 class="mt-3">Tidak ada data</h5>
                        <p class="text-muted">Tidak ada form yang ditemukan dengan kriteria pencarian Anda.</p>
                        @if (request('search') || request('jenis_id'))
                            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">
                                <i class="ri-refresh-line me-1"></i>Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @include('pages.dashboard.modal')
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                width: '100%'
            });
        });
    </script>
@endpush
