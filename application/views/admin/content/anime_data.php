<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-book"></i> Anime Records</h2>
        <div class="search-container">
            <div class="input-group">
                <input type="text" id="animeSearch" class="form-control" placeholder="Search by title or ID...">
                <button class="btn btn-primary" type="button" id="searchBtn">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="card">
        <div class="card-body bg-dark">
            <div class="table-responsive">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Total Episodes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="animeTableBody">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="showing-entries">
                    Showing <span id="startEntry">0</span> to <span id="endEntry">0</span> of <span id="totalEntries">0</span> entries
                </div>
                <div class="pagination-container">
                    <button class="btn btn-secondary me-2" id="prevPage" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button class="btn btn-secondary" id="nextPage" disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editAnimeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Edit Anime</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editAnimeForm">
                    <input type="hidden" id="editAnimeId">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="editTitle" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alternative Title</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="editAltTitle">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select bg-dark text-light border-secondary" id="editCategory" required>
                                <option value="tv">TV Series</option>
                                <option value="movie">Movie</option>
                                <option value="ova">OVA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Language</label>
                            <select class="form-select bg-dark text-light border-secondary" id="editLanguage" required>
                                <option value="sub">Sub</option>
                                <option value="dub">Dub</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Total Episodes</label>
                            <input type="number" class="form-control bg-dark text-light border-secondary" id="editTotalEpisodes" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select bg-dark text-light border-secondary" id="editStatus" required>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Synopsis</label>
                        <textarea class="form-control bg-dark text-light border-secondary" id="editSynopsis" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Episode URLs (One per line)</label>
                        <textarea class="form-control bg-dark text-light border-secondary" id="editUrls" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAnimeChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewAnimeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">View Anime Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img id="viewPoster" src="" alt="Anime Poster" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <h3 id="viewTitle"></h3>
                        <p class="text-light opacity-75" id="viewAltTitle"></p>
                        <div class="mt-3">
                            <p><strong>Category:</strong> <span id="viewCategory"></span></p>
                            <p><strong>Language:</strong> <span id="viewLanguage"></span></p>
                            <p><strong>Total Episodes:</strong> <span id="viewTotalEpisodes"></span></p>
                            <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                            <p><strong>Synopsis:</strong></p>
                            <p id="viewSynopsis"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.content-header {
    padding: 1rem;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.table img {
    width: 50px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
}

.search-container {
    max-width: 400px;
}

.showing-entries {
    color: #fff;
}

.pagination-container button:disabled {
    cursor: not-allowed;
}

/* Modal adjustments */
.modal-dialog.modal-lg {
    max-width: 900px;
}

.modal-content {
    max-height: 85vh;
    overflow-y: auto;
}

.modal-body {
    padding: 1.5rem;
    max-height: calc(85vh - 120px);
    overflow-y: auto;
}

/* Improved form layout */
.form-label {
    font-weight: 500;
    margin-bottom: 0.3rem;
}

.form-control, .form-select {
    margin-bottom: 0.5rem;
}

textarea.form-control {
    min-height: 100px;
}

#editUrls {
    min-height: 80px;
}

/* Table styles */
.table-dark {
    --bs-table-bg: #2d2d2d;
    --bs-table-striped-bg: #343434;
    --bs-table-hover-bg: #3c3c3c;
    --bs-table-border-color: #404040;
    color: #fff;
}

.table-dark th {
    background-color: #222;
    border-bottom: 2px solid #404040;
}

.table-dark td {
    border-color: #404040;
}

.card-body.bg-dark {
    border-radius: 0.25rem;
}
</style>

<script defer src="<?php echo base_url('assets/js/anime_data.js'); ?>"></script>