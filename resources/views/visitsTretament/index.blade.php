@extends("layouts.main")

@section("content")
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Kelola /</span> Tindakan</h4>
        <!-- Column Search -->
        <div class="card">
            <div class="d-flex justify-content-between me-3 align-items-center">
                <h5 class="card-header">Daftar Tindakan</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Nama</th>
                        <th>Jenis Kunjungan</th>
                        <th>Waktu</th>
                        <th>Tindakan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Column Search -->
    </div>
    @include('visitsTretament.modal')
@endsection
@push("my-scripts")
    <script src="{{asset('javascripts/visitsTreatment/global.js')}}"></script>
@endpush
