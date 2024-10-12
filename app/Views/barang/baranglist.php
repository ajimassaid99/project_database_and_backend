<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Barang Menu List
                <button class="btn btn-primary btn-sm float-end btnAddBarang" data-bs-toggle="modal"
                    data-bs-target="#formBarangModal">Create New Barang</button>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Id</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </thead>

                    <tbody>
                        <?php foreach($Barang as $barang): ?>
                        <tr>
                            <td><?= $barang['id'] ?> </td>
                            <td><?= $barang['nama_barang'] ?> </td>
                            <td><?= $barang['kode_barang'] ?> </td>
                            <td><?= $barang['created_at'] ?> </td>
                            <td><?= $barang['updated_at'] ?> </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#formBarangModal"
                                    onclick="editBarang(<?= $barang['id'] ?>)">Update</button>
                                <form action="<?= base_url('barang/deleteBarang/' . $barang['id']) ?>" method="post"
                                    style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this barang?')">Delete</button>
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

<div class="modal fade" id="formBarangModal" tabindex="-1" aria-labelledby="formBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="formBarangModalLabel">Create New Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="barangForm" action="<?= base_url('barang/createBarang'); ?>" method="post">
                <div class="form-group">
                    <input type="hidden" class="form-control" name="inputBarangID" id="inputBarangID" required>
                </div>
                <div class="form-group">
                    <label for="inputNamaBarang">Nama Barang</label>
                    <input type="text" class="form-control" name="inputNamaBarang" id="inputNamaBarang" required>
                </div>
                <div class="form-group">
                    <label for="inputKodeBarang">Kode Barang</label>
                    <input type="text" class="form-control" name="inputKodeBarang" id="inputKodeBarang" required>
                </div>
                <input type="hidden" name="id" id="inputBarangID">
                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-primary" type="submit">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editBarang(id) {
    $.ajax({
        url: "<?= base_url('barang/getBarangData/'); ?>" + id,
        type: 'GET',
        success: function(response) {
            const barang = JSON.parse(response);
            $('#inputBarangID').val(barang.id);
            $('#inputNamaBarang').val(barang.nama_barang);
            $('#inputKodeBarang').val(barang.kode_barang);
            $('#barangForm').attr('action', "<?= base_url('barang/updateBarang'); ?>");
        }
    });
}
</script>
<?= $this->endSection(); ?>