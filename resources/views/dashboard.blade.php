@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 d-none d-sm-block">Dashboard</h4>

                <div class="page-title-right d-flex gap-2 mb-3 mb-sm-0">
                    <!-- Search Form -->
                    <form action="{{ route('dashboard') }}" method="GET" class="d-flex">
                        @if(request('jenis_id'))
                            <input type="hidden" name="jenis_id" value="{{ request('jenis_id') }}">
                        @endif
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Cari keterangan..." 
                                   value="{{ request('search') }}"
                                   style="min-width: 200px;">
                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line"></i>
                            </button>
                            @if(request('search') || request('jenis_id'))
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Filter Button -->
                    <button type="button" class="btn btn-dark btn-label waves-effect right waves-light" data-bs-toggle="modal"
                        data-bs-target="#exampleModalgrid">
                        <i class="ri-filter-line label-icon align-middle fs-16 ms-2"></i>
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Bar (Opsional) -->
    @if(request('search') || request('jenis_id'))
    <div class="row mt-2">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="ri-information-line me-1"></i>
                Menampilkan hasil filter:
                @if(request('search'))
                    <span class="badge bg-primary me-1">Pencarian: "{{ request('search') }}"</span>
                @endif
                @if(request('jenis_id'))
                    @php
                        $selectedJenis = $jenisList->firstWhere('id', request('jenis_id'));
                    @endphp
                    @if($selectedJenis)
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">{{ $item->jenis->jenis }}</h4>
                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank" title="Print"><i class="btn btn-sm btn-soft-primary fs-20 las la-print" data-bs-toggle="tooltip" data-bs-placement="top"></i></a>
                        </div>
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
                        @if(request('search') || request('jenis_id'))
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