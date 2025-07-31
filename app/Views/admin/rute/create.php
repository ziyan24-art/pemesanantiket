<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<!-- ✅ Flash Success Toast -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="position-fixed top-0 end-0 p-3 mt-3" style="z-index: 1055;">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ✅ Main Content -->
<main class="main-content" style="margin-left: 250px; padding: 20px 20px 100px 20px; padding-top: 100px; min-height: calc(100vh - 60px);">
    <div class="container-fluid">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center gap-3 mb-4 flex-wrap">
            <h2 class="mb-0">➕ Tambah Rute Speedboat</h2>
            <a href="/admin/rute" class="btn btn-secondary">← Kembali</a>
        </div>


        <!-- ✅ Form Partial -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <?= $this->include('admin/rute/_form') ?>
            </div>
        </div>

    </div>
</main>

<!-- ✅ Toast Script -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const toastEl = document.getElementById('successToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>