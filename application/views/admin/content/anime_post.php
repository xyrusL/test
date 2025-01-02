<div class="content-section">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mt-4 mb-4">Anime Series Management</h2>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Upload Anime Data</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/upload_json') ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="jsonFile" class="form-label">Choose JSON File</label>
                                <input type="file" class="form-control" id="jsonFile" name="jsonFile" accept=".json">
                                <div class="form-text">Only JSON files are accepted</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload JSON
                            </button>
                        </form>

                        <?php if(isset($upload_status)): ?>
                            <div class="alert alert-<?= $upload_status['type'] === 'success' ? 'success' : 'danger' ?> mt-3">
                                <?= $upload_status['message'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">JSON Data Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="previewData">
                                    <!-- Data will be populated via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>