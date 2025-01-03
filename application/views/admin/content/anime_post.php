<script defer src="<?= base_url('assets/js/anime_post.js') ?>"></script>
<div class="content-section">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mt-4 mb-4 text-light">Anime Series Management</h2>
                
                <div class="card bg-dark text-light border-secondary mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Upload Anime Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="jsonFile" class="form-label">Choose JSON File</label>
                            <input type="file" class="form-control bg-dark text-light border-secondary" id="jsonFile" accept=".json">
                            <div class="form-text">Only JSON files are accepted. File will be validated automatically.</div>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="card bg-dark text-light border-secondary mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">JSON Data Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-dark table-hover">
                                <thead class="sticky-top">
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
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <small class="text-light">Showing <span id="displayCount">0</span> of <span id="totalCount">0</span> items</small>
                            <button id="uploadBtn" class="btn btn-success" disabled onclick="AnimeManager.uploadData()">
                                <i class="fas fa-upload"></i> Upload Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Anime Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Edit Anime Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" onsubmit="event.preventDefault(); AnimeManager.saveEdit(this);">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" name="Title">
                            <small class="form-text text-muted">Required</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Poster URL</label>
                            <input type="url" class="form-control bg-dark text-light border-secondary" name="Poster">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Episodes</label>
                            <input type="number" class="form-control bg-dark text-light border-secondary" name="Total Episodes" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" name="Category">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">MAL Score</label>
                            <input type="number" class="form-control bg-dark text-light border-secondary" name="MAL Score" step="0.01" min="0" max="10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select bg-dark text-light border-secondary" name="Status">
                                <option value="">Select Status</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Language</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" name="Language">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Season</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" name="Season">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" class="form-control bg-dark text-light border-secondary" name="Year" min="1900">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Genres (comma-separated)</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" name="Genres" placeholder="Action, Adventure, etc">
                        </div>
                        <div class="col-12">
                            <label class="form-label">URLs (comma-separated)</label>
                            <textarea class="form-control bg-dark text-light border-secondary" name="urls" rows="3" placeholder="http://example1.com, http://example2.com"></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Upload Progress Modal -->
<div class="modal fade" id="uploadProgressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Uploading Anime Data</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="progress">
                    <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated" 
                         role="progressbar" style="width: 0%">0%</div>
                </div>
                <div class="mt-2 text-center">
                    <span id="uploadStatus">Preparing to upload...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize AnimeManager
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AnimeManager !== 'undefined') {
            AnimeManager.init();
        }
    });
</script>