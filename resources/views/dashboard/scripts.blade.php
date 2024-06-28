

@push('scripts')
    {{--  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  --}}
    {{--  <script>
        // Fungsi untuk mengambil data dari server setiap 2 detik
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

        // Fungsi untuk memperbarui chart dengan data baru
        function updateChart(data) {
            var chartCanvas = document.getElementById('sampahChart').getContext('2d');
            var chartData = {
                labels: data.logam.listTanggal, // Asumsikan semua tanggal sama untuk ketiga jenis sampah
                datasets: [{
                        label: 'Logam',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Merah
                        borderColor: 'rgba(255, 99, 132, 0.8)',
                        data: data.logam.listSensor
                    },
                    {
                        label: 'Organik',
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Hijau
                        borderColor: 'rgba(75, 192, 192, 0.8)',
                        data: data.organik.listSensor
                    },
                    {
                        label: 'Anorganik',
                        backgroundColor: 'rgba(201, 203, 207, 0.5)', // Abu-abu
                        borderColor: 'rgba(201, 203, 207, 0.8)',
                        data: data.anorganik.listSensor
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
                        beginAtZero: true
                    }
                }
            };

            // Menghancurkan chart lama jika ada
            if (window.sampahChartInstance) {
                window.sampahChartInstance.destroy();
            }

            // Membuat objek Chart.js baru
            window.sampahChartInstance = new Chart(chartCanvas, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        }

        // Panggil fungsi fetchData setiap 2 detik menggunakan setInterval
        setInterval(fetchData, 2000); // Setiap 2000 milidetik (2 detik)
    </script>  --}}

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

        function updateChart1(data) {
            var chartCanvas = document.getElementById('sampahChart').getContext('2d');
            var chartData = {
                labels: data.logam.listTanggal, // Asumsikan semua tanggal sama untuk ketiga jenis sampah
                datasets: [{
                        label: 'Logam',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Merah
                        borderColor: 'rgba(255, 99, 132, 0.8)',
                        data: data.logam.listSensor,
                        kapasitas: data.logam.listKapasitas // Menambahkan data kapasitas untuk Logam
                    },
                    {
                        label: 'Organik',
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Hijau
                        borderColor: 'rgba(75, 192, 192, 0.8)',
                        data: data.organik.listSensor,
                        kapasitas: data.organik.listKapasitas // Menambahkan data kapasitas untuk Organik
                    },
                    {
                        label: 'Anorganik',
                        backgroundColor: 'rgba(201, 203, 207, 0.5)', // Abu-abu
                        borderColor: 'rgba(201, 203, 207, 0.8)',
                        data: data.anorganik.listSensor,
                        kapasitas: data.anorganik.listKapasitas // Menambahkan data kapasitas untuk Anorganik
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
                        beginAtZero: true
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            // Tambahkan kapasitas
                            if (context.dataset.kapasitas) {
                                label += ' / ' + context.dataset.kapasitas;
                            }
                            return label;
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
                type: 'bar',
                data: chartData,
                options: chartOptions
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
                        data: data.logam.listSensor,
                        barThickness: data.logam.listKapasitas // Menghitung bar thickness berdasarkan kapasitas
                    },
                    {
                        label: 'Organik',
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 0.8)',
                        data: data.organik.listSensor,
                        barThickness: data.organik.listKapasitas
                    },
                    {
                        label: 'Anorganik',
                        backgroundColor: 'rgba(201, 203, 207, 0.5)',
                        borderColor: 'rgba(201, 203, 207, 0.8)',
                        data: data.anorganik.listSensor,
                        barThickness: data.anorganik.listKapasitas
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
                        beginAtZero: true
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
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        }



        // Fungsi untuk menghitung bar thickness berdasarkan kapasitas
        function calculateBarThickness(kapasitas) {
            // Misalnya, kita tentukan 10 sebagai nilai default untuk bar thickness
            var defaultBarThickness = 10;
            // Misalnya, kita ambil setengah dari kapasitas sebagai batas maksimum untuk bar thickness
            var maxBarThickness = kapasitas / 2;
            // Menghitung bar thickness berdasarkan kapasitas
            var barThickness = Math.min(defaultBarThickness, maxBarThickness);
            return barThickness;
        }


        // Panggil fungsi fetchData setiap 2 detik menggunakan setInterval
        setInterval(fetchData, 2000); // Setiap 2000 milidetik (2 detik)
    </script>
@endpush
