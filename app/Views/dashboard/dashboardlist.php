<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="mt-3 mb-3">Grafik Produksi Harian</h3>
            <div class="card">
                <div class="card-header">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-4">
                            <label for="tanggalProduksi" class="form-label">Tanggal Produksi</label>
                            <input type="date" class="form-control" id="tanggalProduksi" value="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="filterTampilan" class="form-label">Tampilan Data</label>
                            <select class="form-select" id="filterTampilan" onchange="ubahFilterTampilan()">
                                <option value="jam">Per Jam</option>
                                <option value="shift">Per Shift</option>
                                <option value="hari">Per Hari</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-primary" onclick="loadData()">Tampilkan Data</button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="printChart()">Print
                                Grafik</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <canvas id="produksiChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let produksiChart;

function ubahFilterTampilan() {
    const filterTampilan = document.getElementById('filterTampilan').value;
    const tanggalProduksi = document.getElementById('tanggalProduksi');

    // Ubah input tanggal menjadi input bulan saat opsi "Per Hari" dipilih
    if (filterTampilan === 'hari') {
        tanggalProduksi.type = 'month'; // Ubah ke input bulan
    } else {
        tanggalProduksi.type = 'date'; // Kembalikan ke input tanggal jika bukan opsi "Per Hari"
    }
}

function loadData() {
    const tanggalProduksi = document.getElementById('tanggalProduksi').value;
    const filterTampilan = document.getElementById('filterTampilan').value;

    // Ajax untuk mengambil data dari server berdasarkan tanggal dan tampilan
    $.ajax({
        url: '<?= base_url("produksi/getGrafikData") ?>',
        type: 'POST',
        data: {
            tanggal: tanggalProduksi,
            tampilan: filterTampilan
        },
        success: function(response) {
            const data = JSON.parse(response);

            if (data.error) {
                alert(data.error); // Menampilkan pesan error jika ada
                return;
            }

            updateChart(data.labels, data.datasets); // Menggunakan 'datasets' dari respon JSON
        },
        error: function() {
            alert('Terjadi kesalahan saat mengambil data.');
        }
    });
}

function updateChart(labels, datasets) {
    const ctx = document.getElementById('produksiChart').getContext('2d');
    if (produksiChart) {
        produksiChart.destroy();
    }

    let titleText = '';
    let xAxisText = '';
    const filterTampilan = document.getElementById('filterTampilan').value;

    if (filterTampilan === 'shift') {
        titleText = 'Grafik Produksi Harian per Shift per Barang';
        xAxisText = 'Shift';
    } else if (filterTampilan === 'hari') {
        titleText = 'Grafik Produksi Bulanan per Hari per Barang';
        xAxisText = 'Tanggal';
    } else {
        titleText = 'Grafik Produksi Harian per Barang';
        xAxisText = 'Jam';
    }

    produksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels, // Labels untuk x-axis (bisa berupa jam, shift, atau tanggal)
            datasets: datasets // Menampilkan data produksi per barang
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: xAxisText
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: filterTampilan === 'shift' ? 3 : 12 // Sesuaikan ticks
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Produksi'
                    }
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top', // Menampilkan label barang di atas grafik
                },
                title: {
                    display: true,
                    text: titleText
                }
            }
        }
    });
}

function printChart() {
    const canvas = document.getElementById('produksiChart');
    const canvasImage = canvas.toDataURL('image/png', 1.0); // Mengambil gambar dari canvas

    const printWindow = window.open('', '_blank'); // Membuka jendela baru
    printWindow.document.write('<html><head><title>Print Grafik</title>');
    printWindow.document.write(
        '<style>body{display:flex;justify-content:center;align-items:center;height:100vh;margin:0;} img{max-width:100%;max-height:100%;}</style>'
        ); // Mengatur gaya agar gambar sesuai ukuran
    printWindow.document.write('</head><body>');
    printWindow.document.write('<img src="' + canvasImage + '">'); // Menampilkan gambar dari canvas
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print(); // Membuka dialog print
        printWindow.close();
    };
}

// Inisialisasi dengan data awal (misalnya hari ini)
loadData();
</script>
<?= $this->endSection(); ?>