// Check if AnimeDataManager already exists
if (typeof window.AnimeDataManager === 'undefined') {
    window.AnimeDataManager = {
        currentPage: 1,
        itemsPerPage: 6,
        totalItems: 0,
        animeData: [],

        init: function() {
            this.loadAnimeData();
            this.setupEventListeners();
        },

        setupEventListeners: function() {
            $('#searchBtn').off('click').on('click', () => this.performSearch());
            $('#animeSearch').off('keypress').on('keypress', (e) => {
                if (e.which === 13) this.performSearch();
            });
            $('#prevPage').off('click').on('click', () => this.changePage(-1));
            $('#nextPage').off('click').on('click', () => this.changePage(1));
            $('#saveAnimeChanges').off('click').on('click', () => this.saveAnimeChanges());
        },

        loadAnimeData: function(searchQuery = '') {
            this.showLoading();
            $.ajax({
                url: `${baseUrl}api/getAllAnime`,
                type: 'POST',
                data: { query: searchQuery },
                success: (response) => {
                    try {
                        this.animeData = JSON.parse(response);
                        this.totalItems = this.animeData.length;
                        this.updatePagination();
                        this.displayAnimeData();
                    } catch (error) {
                        console.error('Error parsing anime data:', error);
                        this.showAlert('Error loading anime data', 'danger');
                    }
                    this.hideLoading();
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching anime data:', error);
                    this.showAlert('Failed to load anime data', 'danger');
                    this.hideLoading();
                }
            });
        },

        displayAnimeData: function() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = Math.min(startIndex + this.itemsPerPage, this.totalItems);
            const pageData = this.animeData.slice(startIndex, endIndex);
            
            $('#animeTableBody').empty();
            
            if (pageData.length === 0) {
                $('#animeTableBody').append(`
                    <tr>
                        <td colspan="8" class="text-center">No anime records found</td>
                    </tr>
                `);
                return;
            }
            
            pageData.forEach(anime => {
                const status = anime.status === 'Ongoing' 
                    ? '<span class="badge bg-primary">Ongoing</span>' 
                    : '<span class="badge bg-success">Completed</span>';
                    
                $('#animeTableBody').append(`
                    <tr>
                        <td>${anime.id}</td>
                        <td>
                            <img src="${anime.poster}" alt="${anime.title}" class="anime-poster" 
                                 style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong>${anime.title}</strong>
                                <small class="text-muted">${anime.alternative_title || ''}</small>
                            </div>
                        </td>
                        <td><span class="badge bg-info">${anime.category}</span></td>
                        <td><span class="badge bg-secondary">${anime.language}</span></td>
                        <td>${anime.total_episodes}</td>
                        <td>${status}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-info btn-sm" onclick="AnimeDataManager.viewAnime(${anime.id})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="AnimeDataManager.editAnime(${anime.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            });
            
            this.updateEntryInfo(startIndex + 1, endIndex, this.totalItems);
        },

        updateEntryInfo: function(start, end, total) {
            $('#startEntry').text(total === 0 ? 0 : start);
            $('#endEntry').text(end);
            $('#totalEntries').text(total);
        },

        updatePagination: function() {
            const totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
            $('#prevPage').prop('disabled', this.currentPage === 1);
            $('#nextPage').prop('disabled', this.currentPage === totalPages || this.totalItems === 0);
        },

        changePage: function(delta) {
            const newPage = this.currentPage + delta;
            const totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
            
            if (newPage >= 1 && newPage <= totalPages) {
                this.currentPage = newPage;
                this.displayAnimeData();
                this.updatePagination();
            }
        },

        performSearch: function() {
            const query = $('#animeSearch').val().trim();
            $('#searchBtn').prop('disabled', true);
            this.currentPage = 1;
            this.loadAnimeData(query);
            setTimeout(() => $('#searchBtn').prop('disabled', false), 1000);
        },

        viewAnime: function(id) {
            this.showLoading();
            $.ajax({
                url: `${baseUrl}api/getAnimeById`,
                type: 'POST',
                data: { id: id },
                success: (response) => {
                    try {
                        const anime = JSON.parse(response);
                        if (!anime) {
                            this.showAlert('Anime not found', 'danger');
                            return;
                        }
                        
                        $('#viewTitle').text(anime.title);
                        $('#viewAltTitle').text(anime.alternative_title || '');
                        $('#viewPoster').attr('src', anime.poster);
                        $('#viewCategory').text(anime.category);
                        $('#viewLanguage').text(anime.language);
                        $('#viewTotalEpisodes').text(anime.total_episodes);
                        $('#viewStatus').text(anime.status);
                        $('#viewSynopsis').text(anime.synopsis || 'No synopsis available');
                        
                        $('#viewAnimeModal').modal('show');
                    } catch (error) {
                        console.error('Error parsing anime data:', error);
                        this.showAlert('Error loading anime details', 'danger');
                    }
                    this.hideLoading();
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching anime details:', error);
                    this.showAlert('Failed to load anime details', 'danger');
                    this.hideLoading();
                }
            });
        },

        editAnime: function(id) {
            this.showLoading();
            $.ajax({
                url: `${baseUrl}api/getAnimeById`,
                type: 'POST',
                data: { id: id },
                success: (response) => {
                    try {
                        const anime = JSON.parse(response);
                        if (!anime) {
                            this.showAlert('Anime not found', 'danger');
                            return;
                        }
                        
                        $('#editAnimeId').val(id);
                        $('#editTitle').val(anime.title);
                        $('#editAltTitle').val(anime.alternative_title || '');
                        $('#editCategory').val(anime.category);
                        $('#editLanguage').val(anime.language);
                        $('#editTotalEpisodes').val(anime.total_episodes);
                        $('#editStatus').val(anime.status);
                        $('#editSynopsis').val(anime.synopsis || '');
                        $('#editUrls').val(anime.urls ? JSON.parse(anime.urls).join('\n') : '');
                        
                        $('#editAnimeModal').modal('show');
                    } catch (error) {
                        console.error('Error parsing anime data:', error);
                        this.showAlert('Error loading anime details', 'danger');
                    }
                    this.hideLoading();
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching anime details:', error);
                    this.showAlert('Failed to load anime details', 'danger');
                    this.hideLoading();
                }
            });
        },

        saveAnimeChanges: function() {
            const id = $('#editAnimeId').val();
            const formData = {
                id: id,
                title: $('#editTitle').val().trim(),
                alternative_title: $('#editAltTitle').val().trim(),
                category: $('#editCategory').val(),
                language: $('#editLanguage').val(),
                total_episodes: $('#editTotalEpisodes').val(),
                status: $('#editStatus').val(),
                synopsis: $('#editSynopsis').val().trim(),
                urls: $('#editUrls').val().split('\n').filter(url => url.trim())
            };
            
            if (!formData.title) {
                this.showAlert('Title is required', 'warning');
                return;
            }
            
            this.showLoading();
            $.ajax({
                url: `${baseUrl}api/updateAnime`,
                type: 'POST',
                data: formData,
                success: (response) => {
                    try {
                        const result = JSON.parse(response);
                        if (result.success) {
                            this.showAlert('Anime updated successfully', 'success');
                            $('#editAnimeModal').modal('hide');
                            this.loadAnimeData();
                        } else {
                            this.showAlert(result.message || 'Failed to update anime', 'danger');
                        }
                    } catch (error) {
                        console.error('Error parsing response:', error);
                        this.showAlert('Error updating anime', 'danger');
                    }
                    this.hideLoading();
                },
                error: (xhr, status, error) => {
                    console.error('Error updating anime:', error);
                    this.showAlert('Failed to update anime', 'danger');
                    this.hideLoading();
                }
            });
        },

        showAlert: function(message, type = 'info') {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            const alertContainer = $('.alert-container');
            if (alertContainer.length === 0) {
                $('.content-header').after('<div class="alert-container"></div>');
            }
            
            $('.alert-container').append(alertHtml);
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        },

        showLoading: function() {
            if ($('.loading-overlay').length === 0) {
                $('body').append(`
                    <div class="loading-overlay">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
            }
            $('.loading-overlay').show();
        },

        hideLoading: function() {
            $('.loading-overlay').hide();
        }
    };
}

// Initialize when document is ready
$(document).ready(function() {
    if ($('#animeTableBody').length) {
        // Clear any existing event listeners
        $('#searchBtn, #animeSearch, #prevPage, #nextPage, #saveAnimeChanges').off();
        AnimeDataManager.init();
    }
});

// Handle dynamic content loading
$(document).on('contentLoaded', function() {
    if ($('#animeTableBody').length) {
        // Clear any existing event listeners
        $('#searchBtn, #animeSearch, #prevPage, #nextPage, #saveAnimeChanges').off();
        AnimeDataManager.init();
    }
});