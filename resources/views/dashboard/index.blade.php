@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">Grafik Monitoring Kapasitas</h3>
                </div>
                <div class="card-body">
                    <canvas id="sampahChart" height="300" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Real-time Data Tabel Monitoring</h3>
                    <button onclick="deleteDataAll(`{{ route('sensordata.delete_all') }}`)"
                        class="btn btn-danger float-right">Delete All Data</button>
                </div>
                <div class="card-body">
                    <table id="sampahTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Data Waktu</th>
                                <th>Kapasitas Logam</th>
                                <th>Kapasitas Organik</th>
                                <th>Kapasitas Anorganik</th>
                                <th>Tinggi Logam</th>
                                <th>Tinggi Organik</th>
                                <th>Tinggi Anorganik</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includes.datatable')

@push('scripts_vendor')
    <script src="{{ asset('AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('adminlte') }}/plugins/chart.js/Chart.min.js"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#sampahTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('api.sampah.data') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'data_waktu',
                        name: 'data_waktu'
                    },
                    {
                        data: 'kapasitas_logam',
                        name: 'kapasitas_logam'
                    },
                    {
                        data: 'kapasitas_organik',
                        name: 'kapasitas_organik'
                    },
                    {
                        data: 'kapasitas_anorganik',
                        name: 'kapasitas_anorganik'
                    },
                    {
                        data: 'tinggi_logam',
                        name: 'tinggi_logam'
                    },
                    {
                        data: 'tinggi_organik',
                        name: 'tinggi_organik'
                    },
                    {
                        data: 'tinggi_anorganik',
                        name: 'tinggi_anorganik'
                    }
                ]
            });

            setInterval(function() {
                table.ajax.reload(null, false); // reload datatable tanpa mereset paging
            }, 2000);
        });
    </script>
    <script>
        function fetchData() {
            $.ajax({
                url: '{{ route('api.monitoring.fetchDataAll') }}',
                method: 'GET',
                success: function(response) {
                    console.log('Fetched data:', response);
                    updateChart(response); // Panggil fungsi updateChart dengan data yang diambil
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        function updateChart(data) {
            var chartCanvas = document.getElementById('sampahChart').getContext('2d');
            var chartData = {
                labels: data.logam.listTanggal,
                datasets: [{
                        label: 'Logam',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 0.8)',
                        data: data.logam.listKapasitas,
                        barThickness: 10 // atau Anda dapat menggunakan fungsi calculateBarThickness jika diperlukan
                    },
                    {
                        label: 'Organik',
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 0.8)',
                        data: data.organik.listKapasitas,
                        barThickness: 10
                    },
                    {
                        label: 'Anorganik',
                        backgroundColor: 'rgba(201, 203, 207, 0.5)',
                        borderColor: 'rgba(201, 203, 207, 0.8)',
                        data: data.anorganik.listKapasitas,
                        barThickness: 10
                    }
                ]
            };
            var chartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        min: 0
                    }
                },
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            // Tambahkan kapasitas di bagian bawah title
                            if (context.dataset.kapasitas) {
                                label += '\nKapasitas: ' + context.dataset.kapasitas;
                            }
                            return label;
                        },
                        align: 'end',
                        anchor: 'end',
                        color: '#000',
                        font: {
                            size: 12
                        }
                    }
                }
            };

            // Menghancurkan chart lama jika ada
            if (window.sampahChartInstance) {
                window.sampahChartInstance.destroy();
            }

            // Membuat objek Chart.js baru
            window.sampahChartInstance = new Chart(chartCanvas, {
                type: 'line',
                data: chartData,
                options: chartOptions
            });
        }

        // Panggil fungsi fetchData setiap 2 detik menggunakan setInterval
        setInterval(fetchData, 2000); // Setiap 2000 milidetik (2 detik)

        function deleteDataAll(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apa kamu yakin?',
                text: 'data yang sudah di hapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: 'Iya, hapus!',
                cancelButtonText: 'Membatalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    table.ajax.reload();
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            }).then(() => {
                                table.ajax.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
