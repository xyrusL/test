<link rel="stylesheet" href="<?php echo base_url('assets/css/upload.css'); ?>">
<script defer src="<?php echo base_url('assets/js/upload.js'); ?>"></script>
</head>
<body>
<div class="upload-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card upload-card">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Upload JSON</h3>
                        <div class="upload-zone">
                            <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                            <h5 class="mb-3">Upload your JSON file</h5>
                            <p class="text-muted small mb-4">Files Supported: JSON Only</p>
                            <input type="file" hidden accept=".json" id="fileID">
                            <button class="btn btn-primary px-4" id="uploadBtn">
                                <i class="bi bi-file-earmark-arrow-up me-2"></i>Choose File
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Loading Modal -->
<div class="modal fade" id="loadingModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-body text-center p-4">
                <div class="spinner-grow text-primary mb-2" style="width: 2rem; height: 2rem;" role="status"></div>
                <h6 class="fw-normal mb-3" id="uploadStatus">Processing...</h6>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-primary" id="uploadProgress" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
