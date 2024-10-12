<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Report Menu List</h5>
            <input type="text" class="form-control form-control-sm" id="scanBarcodeInput" placeholder="Scan Barcode"
                onchange="handleBarcodeScan()">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Id</th>
                        <th>Barang</th>
                        <th>Shift</th>
                        <th>Jumlah Produksi</th>
                        <th>Barcode</th>
                        <th>Tanggal Produksi</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach($Produksi as $produksi): ?>
                        <tr>
                            <td><?= $produksi['id'] ?></td>
                            <td><?= $produksi['nama_barang'] ?></td>
                            <td><?= $produksi['shift_name'] ?></td>
                            <td><?= $produksi['jumlah_produksi'] ?></td>
                            <td>
                                <button class="btn btn-info btn-sm"
                                    onclick="lihatBarcode('<?= $produksi['barcode'] ?>')">Lihat Barcode</button>
                            </td>
                            <td><?= $produksi['tanggal_produksi'] ?></td>
                            <td><?= $produksi['created_at'] ?></td>
                            <td><?= $produksi['updated_at'] ?></td>
                            <td><?= $produksi['status'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#formProduksiModal"
                                    onclick="editProduksi(<?= $produksi['id'] ?>)">Update</button>

                                <form action="<?= base_url('produksi/deleteProduksi/' . $produksi['id']) ?>"
                                    method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this produksi?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Memulai Produksi -->
<div class="modal fade" id="startProduksiModal" tabindex="-1" aria-labelledby="startProduksiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="startProduksiModalLabel">Mulai Produksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin memulai produksi ini?</p>
                <form id="startProduksiForm" action="<?= base_url('produksi/updateStatusProduksi'); ?>" method="post">
                    <input type="hidden" name="produksi_id" id="startProduksiId">
                    <input type="hidden" name="status" value="onProgres">

                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-success" type="submit">Mulai Produksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menampilkan Barcode -->
<div class="modal fade" id="lihatBarcodeModal" tabindex="-1" aria-labelledby="lihatBarcodeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content p-8">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatBarcodeModalLabel">Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center m-auto">
                <svg id="barcode"></svg>
            </div>
            <div class="modal-footer">
                <form id="barcodeForm" action="<?= base_url('produksi/processBarcode'); ?>" method="post">
                    <input type="hidden" name="inputBarcodeScan" id="inputBarcodeScan">
                </form>
                <button type="button" class="btn btn-success" onclick="printBarcode()">Print Barcode</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Create atau View Reports -->
<div class="modal fade" id="createReportModal" tabindex="-1" aria-labelledby="createReportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="createReportModalLabel">Create or View Reports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk input baru -->
                <form id="reportForm" action="<?= base_url('reportOperator'); ?>" method="post">
                    <input type="hidden" name="produksi_id" id="inputProduksiId">
                    <input type="hidden" name="created_by" id="inputCreatedBy" value="<?= $user['id']; ?>">
                    <input type="hidden" name="jam_produksi" id="inputJamProduksi" value="<?= date('H:i:s'); ?>">

                    <div class="form-group">
                        <label for="inputReportJumlahProduksi">Jumlah Produksi Baru</label>
                        <input type="number" class="form-control" name="inputReportJumlahProduksi"
                            id="inputReportJumlahProduksi" required>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Save Report</button>
                    </div>
                </form>

                <!-- Tabel untuk menampilkan data laporan sebelumnya -->
                <div class="mt-4">
                    <h6>Previous Reports</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Jumlah Produksi</th>
                                    <th>Jam Produksi</th>
                                    <th>Tanggal Produksi</th>
                                </tr>
                            </thead>
                            <tbody id="reportTableBody">
                                <!-- Data laporan akan dimasukkan di sini oleh AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
function lihatBarcode(barcode) {
    if (barcode) {
        JsBarcode("#barcode", barcode, {
            format: "CODE39",
            lineColor: "#00",
            width: 2,
            height: 100,
            displayValue: true
        });
        document.getElementById('inputBarcodeScan').value = barcode; // Set barcode in hidden input
        $('#lihatBarcodeModal').modal('show');
        document.getElementById('inputBarcodeScan').focus(); // Set focus to hidden input for auto submission
    }
}

function printBarcode() {
    const barcodeSvg = document.getElementById('barcode');
    const printWindow = window.open('', '_blank', 'width=600,height=400');
    printWindow.document.write('<html><head><title>Print Barcode</title></head><body>');
    printWindow.document.write(barcodeSvg.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Event listener untuk menangani input dari scanner
document.getElementById('inputBarcodeScan').addEventListener('input', function() {
    console.log("Barcode scanned:", this.value); // Debug log untuk melihat input dari scanner
    $('#lihatBarcodeModal').modal('hide'); // Hide barcode modal
    setTimeout(function() {
        $('#createReportModal').modal('show'); // Show report modal setelah sedikit jeda
    }, 500); // Tambahkan jeda 500ms
});

function editProduksi(id) {
    $.ajax({
        url: "<?= base_url('produksi/getProduksiData/'); ?>" + id,
        type: 'GET',
        success: function(response) {
            const produksi = JSON.parse(response);
            $('#inputProduksiID').val(produksi.id);
            $('#inputBarangId').val(produksi.barang_id);
            $('#inputShiftId').val(produksi.shift_id);
            $('#inputBarcode').val(produksi.barcode);
            $('#inputTanggalProduksi').val(produksi.tanggal_produksi);
            $('#produksiForm').attr('action', "<?= base_url('produksi/updateProduksi'); ?>");
        }
    });
}

function handleBarcodeScan() {
    const barcodeInput = document.getElementById('scanBarcodeInput');
    const barcode = barcodeInput.value.trim();

    if (barcode !== '') {
        $.ajax({
            url: "<?= base_url('produksi/checkBarcode'); ?>",
            type: 'POST',
            data: {
                barcode: barcode
            },
            success: function(response) {
                if (response.found) {
                    document.getElementById('inputProduksiId').value = response.produksi.id;
                    document.getElementById('inputJamProduksi').value = new Date().toLocaleTimeString();

                    // Cek status produksi
                    if (response.produksi.status === 'start') {
                        // Set produksi ID di modal start produksi
                        document.getElementById('startProduksiId').value = response.produksi.id;
                        $('#startProduksiModal').modal('show'); // Tampilkan modal mulai produksi
                    } else {
                        // Jika status bukan start, tampilkan modal laporan seperti biasa
                        $('#createReportModal').modal('show');

                        // Ambil data laporan berdasarkan ID produksi
                        fetchReportData(response.produksi.id);
                    }
                } else {
                    alert('Kode produksi tidak ditemukan');
                    barcodeInput.value = '';
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengecek barcode.');
                barcodeInput.value = '';
            }
        });
    }
}

function fetchReportData(produksiId) {
    $.ajax({
        url: "<?= base_url('report/getReportByProduksiId/'); ?>" + produksiId,
        type: 'GET',
        success: function(response) {
            const reportTableBody = document.getElementById('reportTableBody');
            reportTableBody.innerHTML = ''; // Kosongkan tabel sebelum diisi

            if (response.reports && response.reports.length > 0) {
                response.reports.forEach(function(report) {
                    const row = `<tr>
                                    <td>${report.id}</td>
                                    <td>${report.jumlah_produksi}</td>
                                    <td>${report.jam_produksi}</td>
                                    <td>${report.tanggal_produksi}</td>
                                </tr>`;
                    reportTableBody.innerHTML += row;
                });
            } else {
                const emptyRow = `<tr><td colspan="4" class="text-center">No reports found</td></tr>`;
                reportTableBody.innerHTML = emptyRow;
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat mengambil data laporan.');
        }
    });
}
</script>
<?= $this->endSection(); ?>