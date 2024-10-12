<!-- views/produksi/viewProduksi.php -->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Detail Produksi</h5>
        </div>
        <div class="card-body">
            <p><strong>ID Produksi:</strong> <?= $produksi['id'] ?></p>
            <p><strong>Barang:</strong> <?= $produksi['barang_id'] ?></p>
            <p><strong>Shift:</strong> <?= $produksi['shift_id'] ?></p>
            <p><strong>Jumlah Produksi:</strong> <?= $produksi['jumlah_produksi'] ?></p>
            <p><strong>Barcode:</strong> <?= $produksi['barcode'] ?></p>
            <p><strong>Tanggal Produksi:</strong> <?= $produksi['tanggal_produksi'] ?></p>
            <!-- Tambahkan detail lain yang relevan -->
        </div>
    </div>
</div>