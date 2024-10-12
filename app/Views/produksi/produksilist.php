<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Produksi Menu List
                <button class="btn btn-primary btn-sm float-end btnAddProduksi" data-bs-toggle="modal"
                    data-bs-target="#formProduksiModal">Create New Produksi</button>
            </h5>
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


<div class="modal fade" id="formProduksiModal" tabindex="-1" aria-labelledby="formProduksiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="formProduksiModalLabel">Create New Produksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="produksiForm" action="<?= base_url('produksi/createProduksi'); ?>" method="post">
                    <div class="form-group">
                        <label for="inputBarangId">Barang</label>
                        <select class="form-control" name="inputBarangId" id="inputBarangId" required>
                            <?php foreach($Barang as $barang): ?>
                            <option value="<?= $barang['id']; ?>"><?= $barang['nama_barang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputShiftId">Shift</label>
                        <select class="form-control" name="inputShiftId" id="inputShiftId" required>
                            <?php foreach($Shift as $shift): ?>
                            <option value="<?= $shift['id']; ?>"><?= $shift['shift_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">

                        <input type="text" class="form-control" name="inputBarcode" id="inputBarcode"
                            value="<?= rand(1000000000, 9999999999); ?>" hidden>
                    </div>
                    <div class="form-group">
                        <label for="inputTanggalProduksi">Tanggal Produksi</label>
                        <input type="date" class="form-control" name="inputTanggalProduksi" id="inputTanggalProduksi"
                            required>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="submit">Save Data</button>
                    </div>
                </form>
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

// Automatically submit form when barcode is scanned
document.getElementById('inputBarcodeScan').addEventListener('input', function() {
    document.getElementById('barcodeForm').submit();
});


function printBarcode() {
    const barcodeSvg = document.getElementById('barcode');
    const printWindow = window.open('', '_blank', 'width=600,height=400');
    printWindow.document.write('<html><head><title>Print Barcode</title></head><body>');
    printWindow.document.write(barcodeSvg.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

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
</script>
<?= $this->endSection(); ?>