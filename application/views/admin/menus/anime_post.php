<h4 class="mb-4">Anime Post Management</h4>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form class="d-flex" id="searchForm">
                    <input class="form-control me-2" type="search" id="searchInput" placeholder="Search anime...">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Anime
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be fetched here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination Controls -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <button class="page-link" id="prevPage">Previous</button>
                </li>
                <li class="page-item">
                    <span class="page-link" id="currentPage">1</span>
                </li>
                <li class="page-item">
                    <button class="page-link" id="nextPage">Next</button>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewAnimeModal" tabindex="-1" aria-labelledby="viewAnimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="animeModalContent">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="viewAnimeModalLabel">Anime Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="" id="animePoster" alt="Anime Poster" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                        <p><strong>Title:</strong> <span id="animeTitle"></span></p>
                        <p><strong>Status:</strong> <span id="animeStatus"></span></p>
                        <p><strong>Upload Date:</strong> <span id="animeDate"></span></p>
                        <p><strong>Category:</strong> <span id="animeCategory"></span></p>
                        <p><strong>Genres:</strong> <span id="animeGenres"></span></p>
                        <p><strong>Language:</strong> <span id="animeLanguage"></span></p>
                        <p><strong>Score:</strong> <span id="animeScore"></span></p>
                        <p><strong>Urls:</strong> <span id="animeUrls"></span></p>
                        <p><strong>Total Episodes:</strong> <span id="animeEpisodes"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editAnimeModal" tabindex="-1" aria-labelledby="editAnimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="editAnimeModalLabel">Edit Anime</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAnimeForm">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="editTitle">
                            </div>
                            <div class="mb-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-control" id="editStatus">
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Finished Airing">Finished Airing</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editDate" class="form-label">Upload Date</label>
                                <input type="date" class="form-control" id="editDate">
                            </div>
                            <div class="mb-3">
                                <label for="editCategory" class="form-label">Category</label>
                                <select class="form-control" id="editCategory">
                                    <option value="TV">TV</option>
                                    <option value="OVA">OVA</option>
                                    <option value="MOVIE">MOVIE</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editGenres" class="form-label">Genres</label>
                                <input type="text" class="form-control" id="editGenres">
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editLanguage" class="form-label">Language</label>
                                <input type="text" class="form-control" id="editLanguage">
                            </div>
                            <div class="mb-3">
                                <label for="editScore" class="form-label">Score</label>
                                <input type="number" class="form-control" id="editScore" min="0" max="10" step="0.1">
                            </div>
                            <div class="mb-3">
                                <label for="editUrls" class="form-label">URLs</label>
                                <input type="text" class="form-control" id="editUrls">
                            </div>
                            <div class="mb-3">
                                <label for="editEpisodes" class="form-label">Total Episodes</label>
                                <input type="number" class="form-control" id="editEpisodes" min="0">
                            </div>
                            <div class="mb-3">
                                <label for="editUrl" class="form-label">Poster Url</label>
                                <input type="url" class="form-control" id="editUrl">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="searchModalContent">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="searchModalLabel">Search Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table-custom" id="searchResultsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Search results will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Upload JSON Modal -->
<div class="modal fade" id="uploadJsonModal" tabindex="-1" aria-labelledby="uploadJsonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="uploadJsonModalContent">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="uploadJsonModalLabel">Upload JSON</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadJsonForm">
                    <div class="mb-3">
                        <label for="jsonFileInput" class="form-label">Select JSON File</label>
                        <input type="file" class="form-control" id="jsonFileInput" accept=".json">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="uploadJsonBtn">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="notificationModalContent">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="notificationMessage"></p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary mb-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mb-2" id="loadingMessage">Uploading anime data...</p>
                <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgress" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted" id="uploadDetails">Processed: 0 of 0</small>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let animeDataStore = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        const totalPages = () => Math.ceil(animeDataStore.length / itemsPerPage);

        function renderPage(page) {
            $('.table-custom tbody').empty();
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedData = animeDataStore.slice(start, end);
            paginatedData.forEach(anime => {
                $('.table-custom tbody').append(generateRow(anime));
            });
            $('#currentPage').text(page);
            $('#prevPage').prop('disabled', page === 1);
            $('#nextPage').prop('disabled', page === totalPages());
        }

        function initializePage() {
            $.ajax({
                url: '<?= base_url('api/getAnimeData') ?>',
                type: 'GET',
                success: function(response) {
                    animeDataStore = JSON.parse(response);
                    if (animeDataStore) {
                        renderPage(currentPage);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

            $('#prevPage').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $('#nextPage').click(function() {
                if (currentPage < totalPages()) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });
        }
        initializePage();
        
        function generateRow(anime) {
            return `
            <tr>
                <td>${anime.id}</td>
                <td>${anime.title}</td>
                <td>${anime.status}</td>
                <td>${anime.date}</td>
                <td>
                    <button class="btn btn-sm btn-primary">Edit</button>
                    <button class="btn btn-sm btn-info" id="view-button">View</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
        `;
        }

        function fetchAnimeById(id) {
            return $.ajax({
                url: '<?= base_url('api/getAnimeById') ?>',
                type: 'POST',
                data: {
                    id: id
                }
            });
        }

        $(document).on('click', '#view-button', function() {
            let animeId = $('td:first-child', $(this).closest('tr')).text();
            fetchAnimeById(animeId).done(function(response) {
                const animeData = JSON.parse(response);
                const urls = JSON.parse(animeData.urls);
                const urlsCount = urls.length;

                $('#animePoster').attr('src', animeData.poster);
                $('#animeTitle').text(animeData.title);
                $('#animeStatus').text(animeData.status);

                const date = new Date(animeData.date);
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                const formattedDate = date.toLocaleDateString('en-US', options);
                $('#animeDate').text(formattedDate);

                $('#animeCategory').text(animeData.category);
                $('#animeGenres').text(JSON.parse(animeData.genres).join(', '));
                $('#animeLanguage').text(animeData.language);
                $('#animeScore').text(animeData.mal_score);
                $('#animeUrls').text(urlsCount);
                $('#animeEpisodes').text(animeData.total_episodes);
                $('#viewAnimeModal').modal('show');
            }).fail(function(error) {
                console.log(error);
            });
        });

        $(document).on('click', '.btn-primary', function() {
            if ($(this).text() === 'Edit') {
                let row = $(this).closest('tr');
                let title = row.find('td:eq(1)').text();
                let animeId = row.find('td:eq(0)').text();

                fetchAnimeById(animeId).done(function(response) {
                    const animeData = JSON.parse(response);
                    const urls = JSON.parse(animeData.urls);
                    const urlsCount = urls.length;

                    $('#editTitle').val(animeData.title);
                    $('#editStatus').val(animeData.status);
                    $('#editDate').val(animeData.date);
                    $('#editCategory').val(animeData.category);
                    $('#editGenres').val(JSON.parse(animeData.genres).join(', '));
                    $('#editLanguage').val(animeData.language);
                    $('#editScore').val(animeData.mal_score);
                    $('#editUrls').val(urlsCount);
                    $('#editEpisodes').val(animeData.total_episodes);
                    $('#editUrl').val(animeData.poster);
                    $('#editAnimeModal').modal('show');

                }).fail(function(error) {
                    console.log(error);
                });
            } else if ($(this).text().includes('Add New Anime')) {
                $('#uploadJsonModal').modal('show');
            }
        });

        $('#saveChanges').click(function() {
            showNotification('Changes saved successfully!');
            $('#editAnimeModal').modal('hide');
        });

        // Handle Search Form Submission
        $('#searchForm').submit(function(event) {
            event.preventDefault();
            const query = $('#searchInput').val().toLowerCase();
            const filteredData = animeDataStore.filter(anime => 
                anime.title.toLowerCase().includes(query) || 
                anime.status.toLowerCase().includes(query)
            );
            renderSearchResults(filteredData, query);
        });

        function renderSearchResults(data, query) {
            $('#searchModalLabel').text(`Search Results: "${query}"`);
            $('#searchResultsTable tbody').empty();
            if (data.length === 0) {
                $('#searchResultsTable tbody').append('<tr><td colspan="5" class="text-center">No results found.</td></tr>');
            } else {
                data.forEach(anime => {
                    $('#searchResultsTable tbody').append(generateRow(anime));
                });
            }
            $('#searchModal').modal('show');
        }

        $('#uploadJsonBtn').click(function() {
            const requiredKeys = [
                'Title', 'Poster', 'Total Episodes', 'Category',
                'Genres', 'MAL Score', 'Status', 'Language', 'Season',
                'Year', 'urls'
            ];
            const fileInput = document.getElementById('jsonFileInput');
            if (!fileInput.files.length) {
                showNotification('Please select a JSON file first.');
                return;
            }
            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    let jsonData = JSON.parse(e.target.result);
                    if (!Array.isArray(jsonData)) {
                        jsonData = [jsonData];
                    }
                    
                    for (let i = 0; i < jsonData.length; i++) {
                        const item = jsonData[i];
                        const missingKeys = requiredKeys.filter(key => !(key in item));
                        if (missingKeys.length > 0) {
                            showNotification('Error missing key(s) in JSON object #' + (i + 1) + ': ' + missingKeys.join(', '));
                            fileInput.value = '';
                            return;
                        }
                    }

                    $('#uploadJsonModal').modal('hide');
                    showLoading(`Uploading ${jsonData.length} anime entries...`);

                    let completed = 0;
                    const totalEntries = jsonData.length;
                    
                    function uploadSequentially(index) {
                        if (index >= totalEntries) {
                            hideLoading();
                            showNotification(`Successfully uploaded ${completed} out of ${totalEntries} anime entries.`);
                            initializePage();
                            return;
                        }

                        $.ajax({
                            url: '<?= base_url('api/uploadNewAnime') ?>',
                            type: 'POST',
                            data: { animeData: JSON.stringify(jsonData[index]) },
                            dataType: 'json'
                        })
                        .done(function(response) {
                            if (response.success) {
                                completed++;
                            }
                            updateLoadingProgress(index + 1, totalEntries);
                            uploadSequentially(index + 1);
                        })
                        .fail(function(error) {
                            console.error(`Error uploading entry ${index + 1}:`, error);
                            updateLoadingProgress(index + 1, totalEntries);
                            uploadSequentially(index + 1);
                        });
                    }

                    uploadSequentially(0);

                } catch (error) {
                    hideLoading();
                    console.error(error);
                    showNotification('Invalid JSON file. Please check the file content.');
                    fileInput.value = '';
                }
            };
            reader.readAsText(file);
        });

        function showLoading(message = 'Uploading anime data...') {
            $('#loadingMessage').text(message);
            $('#uploadProgress').css('width', '0%').attr('aria-valuenow', 0);
            $('#uploadDetails').text('Processed: 0 of 0');
            $('#loadingModal').modal('show');
        }

        function updateLoadingProgress(current, total) {
            const percentage = Math.round((current / total) * 100);
            $('#uploadProgress').css('width', percentage + '%').attr('aria-valuenow', percentage);
            $('#uploadDetails').text(`Processed: ${current} of ${total}`);
        }

        function hideLoading() {
            $('#loadingModal').modal('hide');
        }

        function showNotification(message) {
            $('#notificationMessage').text(message);
            $('#notificationModal').modal('show');
        }
    });
</script>