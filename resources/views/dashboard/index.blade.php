@extends("layouts.main")

@section('content')
<div class="container">
    <h4 class="mb-4">Laporan Grafik</h4>

    <div class="row">
        <!-- Polar Area Chart -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Jumlah Tindakan</h5>
                </div>
                <div class="card-body">
                    <canvas id="polarChart" class="chartjs" height="337"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Jumlah Kunjungan</h5>
                </div>
                <div class="card-body">
                    <canvas id="barChart" class="chartjs" height="337"></canvas>
                </div>
            </div>
        </div>

        <!-- Polar Area Chart -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-header header-elements">
                    <h5 class="card-title mb-0">Jumlah Wilayah</h5>
                </div>
                <div class="card-body">
                    <canvas id="polarChartWilayah" class="chartjs" height="337"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('my-scripts')
    <script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>

    <!-- Page JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const barLabels = @json($barLabels);
            const barData = @json($barData);
            const polarLabels = @json($polarLabels);
            const polarData = @json($polarData);
            const polarLabelsWilayah = @json($polarLabelsWilayah);
            const polarDataWilayah = @json($polarDataWilayah);

            // Polar Area Chart
            const polarChartEl = document.getElementById("polarChart");
            if (polarChartEl) {
                new Chart(polarChartEl, {
                    type: 'polarArea',
                    data: {
                        labels: polarLabels,
                        datasets: [{
                            label: 'Population (millions)',
                            data: polarData,
                            backgroundColor: ['#42a5f5', '#66bb6a', '#ffa726'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#333',
                                    font: {
                                        family: 'Inter'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Polar Area Chart
            const polarChartElWilayah = document.getElementById("polarChartWilayah");
            if (polarChartElWilayah) {
                new Chart(polarChartElWilayah, {
                    type: 'polarArea',
                    data: {
                        labels: polarLabelsWilayah,
                        datasets: [{
                            label: 'Population (millions)',
                            data: polarDataWilayah,
                            backgroundColor: ['#42a5f5', '#66bb6a', '#ffa726'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#333',
                                    font: {
                                        family: 'Inter'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Bar Chart
            const barChartEl = document.getElementById("barChart");
            if (barChartEl) {
                new Chart(barChartEl, {
                    type: 'bar',
                    data: {
                        labels: barLabels,
                        datasets: [{
                            label: 'Jumlah Data',
                            data: barData,
                            backgroundColor: '#42a5f5',
                            borderRadius: {
                                topLeft: 10,
                                topRight: 10
                            }
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

        });
    </script>
@endpush
