<h4 class="mb-4">Anime Featured Post</h4>
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <div class="search-container">
                    <div class="search-input-group">
                        <input type="text" class="form-control" placeholder="Search anime..." id="searchAnime">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                    <div class="search-results" id="searchResults"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Clicked</th>
                        <th>Views</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                   <!-- table rows will be added dynamically -->
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button class="btn btn-primary save-featured" type="button">
                <i class="bi bi-save me-2"></i>Save Featured Posts
            </button>
        </div>
    </div>
</div>

<!-- Add this modal markup at the end of your file -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertTitle">Notice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="alertMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const $searchInput = $('#searchAnime');
        const $searchResults = $('#searchResults');
        let searchTimeout;

        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

        // Handle search input
        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();

            searchTimeout = setTimeout(() => {
                if (query.length > 0) {
                    $.ajax({
                        url: '<?= base_url() ?>/api/searchAnime',
                        method: 'POST',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $searchResults.empty();
                            let data = JSON.parse(response);
                            if (data.length > 0) {
                                data.forEach(item => {
                                    $searchResults.append(`
                                        <div class="result-item" data-id="${item.id}">
                                            <div class="result-title">${item.title}</div>
                                            <div class="result-info">
                                                <span><i class="bi bi-circle-fill"></i> ${item.status}</span>
                                                <span><i class="bi bi-collection-play"></i> ${item.episodes} eps</span>
                                                <span><i class="bi bi-star-fill"></i> ${item.rating}</span>
                                            </div>
                                            <button class="add-button"><i class="bi bi-plus-lg me-1"></i>Add</button>
                                        </div>
                                    `);
                                });
                                $searchResults.fadeIn(200);
                            }
                        }
                    });
                } else {
                    $searchResults.fadeOut(200);
                }
            }, 300);
        });

        // Hide results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-container').length) {
                $searchResults.fadeOut(200);
            }
        });

        // Handle result item click
        $(document).on('click', '.result-item', function() {
            $searchInput.val($(this).find('.result-title').text());
            $searchResults.fadeOut(200);
        });

        // Load featured anime on page load
        $.ajax({
            url: '<?= base_url() ?>/api/getFeaturedAnime',
            method: 'GET',
            success: function(response) {
                let data = JSON.parse(response);
                if (data.length > 0) {
                    data.forEach((item, index) => {
                        const rowPosition = index + 1;
                        $('.table-custom tbody').append(`
                            <tr>
                                <td class="text-center">${rowPosition}</td>
                                <td>${item.id}</td>
                                <td>${item.title}</td>
                                <td>${item.status}</td>
                                <td>${item.clicked}</td>
                                <td>${item.views}</td>
                                <td class="position-controls">
                                    <button class="btn btn-sm move-up" title="Move Up">
                                        <i class="bi bi-chevron-double-up"></i>
                                    </button>
                                    <button class="btn btn-sm move-down" title="Move Down">
                                        <i class="bi bi-chevron-double-down"></i>
                                    </button>
                                    <button class="btn btn-sm delete-btn" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
            }
        })

        // Handle add button click
        $(document).on('click', '.add-button', function(e) {
            e.stopPropagation(); // Prevent triggering the result-item click event
            const $resultItem = $(this).closest('.result-item');
            const animeId = $resultItem.data('id');
            const animeTitle = $resultItem.find('.result-title').text();

            $.ajax({
                url: '<?= base_url() ?>/api/getAnimeById',
                method: 'POST',
                data: {
                    id: animeId
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    const rowPosition = $('.table-custom tbody tr').length + 1;
                    $('.table-custom tbody').append(`
                        <tr>
                            <td class="text-center">${rowPosition}</td>
                            <td>${animeId}</td>
                            <td>${animeTitle}</td>
                            <td>${data.status}</td>
                            <td>0</td>
                            <td>0</td>
                            <td class="position-controls">
                                <button class="btn btn-sm move-up" title="Move Up">
                                    <i class="bi bi-chevron-double-up"></i>
                                </button>
                                <button class="btn btn-sm move-down" title="Move Down">
                                    <i class="bi bi-chevron-double-down"></i>
                                </button>
                                <button class="btn btn-sm delete-btn" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    `);

                    // Clear search and hide results
                    $searchInput.val('');
                    $searchResults.fadeOut(200);
                },
                error: function(xhr, status, error) {
                    console.error('Error adding anime:', error);
                    showAlert('Error', 'Failed to add anime to featured list', true);
                }
            });
        });

        // Add the position control handlers
        $(document).on('click', '.move-up', function() {
            const currentRow = $(this).closest('tr');
            const prevRow = currentRow.prev();

            if (prevRow.length) {
                // Animate the swap
                currentRow.css('backgroundColor', 'rgba(255,255,255,0.1)');
                prevRow.css('backgroundColor', 'rgba(255,255,255,0.1)');

                currentRow.fadeOut(200, function() {
                    prevRow.before(currentRow);
                    currentRow.fadeIn(200);
                    updatePositions();

                    // Reset background
                    setTimeout(() => {
                        currentRow.css('backgroundColor', '');
                        prevRow.css('backgroundColor', '');
                    }, 300);
                });
            }
        });

        $(document).on('click', '.move-down', function() {
            const currentRow = $(this).closest('tr');
            const nextRow = currentRow.next();

            if (nextRow.length) {
                // Animate the swap
                currentRow.css('backgroundColor', 'rgba(255,255,255,0.1)');
                nextRow.css('backgroundColor', 'rgba(255,255,255,0.1)');

                currentRow.fadeOut(200, function() {
                    nextRow.after(currentRow);
                    currentRow.fadeIn(200);
                    updatePositions();

                    // Reset background
                    setTimeout(() => {
                        currentRow.css('backgroundColor', '');
                        nextRow.css('backgroundColor', '');
                    }, 300);
                });
            }
        });

        // Simplified delete handler - no API call needed
        $(document).on('click', '.delete-btn', function() {
            const currentRow = $(this).closest('tr');
            const animeTitle = currentRow.find('td:eq(2)').text(); // Get anime title
            
            $('#modalMessage').text(`Are you sure you want to remove "${animeTitle}" from featured list?`);
            $('#confirmButton').off('click').on('click', function() {
                currentRow.fadeOut(300, function() {
                    $(this).remove();
                    updatePositions();
                });
                confirmModal.hide();
            });
            confirmModal.show();
        });

        // Function to update positions (simplified, no API call)
        function updatePositions() {
            // Only update visible position numbers
            $('.table-custom tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        // Handle save button click
        $('.save-featured').on('click', function() {
            const button = $(this);
            button.prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Saving...');

            // Get all anime IDs in their current order
            const animeIds = $('.table-custom tbody tr').map(function() {
                return $(this).find('td:eq(1)').text();
            }).get();

            $.ajax({
                url: '<?= base_url() ?>/api/saveFeaturedPosts',
                method: 'POST',
                data: { anime_ids: animeIds },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        button.removeClass('btn-primary').addClass('btn-success')
                            .html('<i class="bi bi-check-lg me-2"></i>Saved Successfully');
                        setTimeout(() => {
                            button.addClass('btn-primary').removeClass('btn-success')
                                .html('<i class="bi bi-save me-2"></i>Save Featured Posts');
                        }, 2000);
                    }
                },
                error: function(error) {
                    button.removeClass('btn-primary').addClass('btn-danger')
                        .html('<i class="bi bi-x-lg me-2"></i>Save Failed');
                    setTimeout(() => {
                        button.addClass('btn-primary').removeClass('btn-danger')
                            .html('<i class="bi bi-save me-2"></i>Save Featured Posts');
                    }, 2000);
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        // Replace error alerts in AJAX calls
        function showAlert(title, message, isError = false) {
            $('#alertTitle').text(title);
            $('#alertMessage').text(message);
            if (isError) {
                $('#alertTitle').addClass('text-danger');
            } else {
                $('#alertTitle').removeClass('text-danger');
            }
            alertModal.show();
        }
    });
</script>