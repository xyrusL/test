/**
 * AnimeManager - Handles anime data management operations
 * Core functionalities:
 * 1. JSON file upload and validation
 * 2. Data preview and display
 * 3. View and edit operations
 * 4. UI feedback (toasts, modals)
 */
// Check if AnimeManager already exists
if (typeof window.AnimeManager === 'undefined') {
    window.AnimeManager = {
        // Data store
        data: [], 

        // =========================================
        // Initialization
        // =========================================
        init: function() {
            this.initializeFileUpload();
        },

        // =========================================
        // File Upload Handling
        // =========================================
        initializeFileUpload: function() {
            const fileInput = document.getElementById('jsonFile');
            
            if (!fileInput) {
                console.error('File input element not found!');
                return;
            }
            
            fileInput.addEventListener('change', (e) => {
                e.preventDefault();
                const file = e.target.files[0];
                if (!file) return;

                if (!this.isValidFileType(file)) {
                    this.showErrorModal('Please select a valid JSON file');
                    this.resetUpload();
                    return;
                }
                
                this.readAndProcessFile(file);
            });
        },

        isValidFileType: function(file) {
            return file.type.match('application/json');
        },

        readAndProcessFile: function(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                try {
                    const jsonData = JSON.parse(e.target.result);
                    this.validateAndPreviewJson(jsonData);
                } catch (error) {
                    console.error('JSON parse error:', error);
                    this.showErrorModal('Invalid JSON format: ' + error.message);
                    this.resetUpload();
                }
            };
            reader.readAsText(file);
        },

        // =========================================
        // Data Validation
        // =========================================
        validateAndPreviewJson: function(data) {
            // All fields required for initial JSON upload
            const requiredKeys = [
                'Title', 'Poster', 'Total Episodes', 'Category', 
                'Genres', 'MAL Score', 'Status', 'Language', 
                'Season', 'Year', 'urls'
            ];
            const optionalKeys = [];
            
            const animeList = Array.isArray(data) ? data : [data];
            
            if (!this.validateAnimeData(animeList, requiredKeys, optionalKeys, true)) return;

            this.data = animeList;
            this.displayPreview(animeList);
            document.getElementById('uploadBtn').disabled = false;
        },

        validateAnimeData: function(animeList, requiredKeys, optionalKeys, isInitialUpload = false) {
            for (const anime of animeList) {
                // Only check required fields during initial JSON upload
                if (isInitialUpload) {
                    const missingKeys = requiredKeys.filter(key => !(key in anime));
                    if (missingKeys.length > 0) {
                        this.showErrorModal(`Missing critical fields: ${missingKeys.join(', ')}`);
                        this.resetUpload();
                        return false;
                    }
                }

                // Handle arrays
                if (!Array.isArray(anime.Genres)) {
                    anime.Genres = anime.Genres ? [anime.Genres] : [];
                }
                if (!Array.isArray(anime.urls)) {
                    anime.urls = anime.urls ? [anime.urls] : [];
                }
            }
            return true;
        },

        // =========================================
        // Data Display
        // =========================================
        displayPreview: function(animeList) {
            const previewTable = document.getElementById('previewData');
            const displayCountEl = document.getElementById('displayCount');
            const totalCountEl = document.getElementById('totalCount');
            
            if (!previewTable || !displayCountEl || !totalCountEl) return;
            
            previewTable.innerHTML = '';
            totalCountEl.textContent = animeList.length;
            
            const fragment = document.createDocumentFragment();
            
            animeList.forEach((anime, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${anime.Title}</td>
                    <td>${anime.Status}</td>
                    <td>
                        <button class="btn btn-sm btn-info me-2" onclick="AnimeManager.viewDetails(${index})">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="AnimeManager.editDetails(${index})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                `;
                fragment.appendChild(tr);
            });
            
            previewTable.appendChild(fragment);
            displayCountEl.textContent = animeList.length;
        },

        // =========================================
        // CRUD Operations
        // =========================================
        viewDetails: function(index) {
            const anime = this.data[index];
            const detailsContent = document.getElementById('detailsContent');
            
            if (!detailsContent || !anime) return;
            
            const detailsHtml = `
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <img src="${anime.Poster}" class="img-fluid rounded" alt="${anime.Title}">
                        </div>
                        <div class="col-md-8">
                            <h4 class="mb-4 text-info">${anime.Title}</h4>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded bg-secondary bg-opacity-25">
                                        <strong class="text-info">MAL Score:</strong>
                                        <div class="h5 mb-0 text-white">${anime['MAL Score'] || 'N/A'}</div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded bg-secondary bg-opacity-25">
                                        <strong class="text-info">Total Episodes:</strong>
                                        <div class="h5 mb-0 text-white">${anime['Total Episodes'] || 'N/A'}</div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded bg-secondary bg-opacity-25">
                                        <strong class="text-info">Season:</strong>
                                        <div class="h5 mb-0 text-white">${anime.Season || 'N/A'}</div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 rounded bg-secondary bg-opacity-25">
                                        <strong class="text-info">Year:</strong>
                                        <div class="h5 mb-0 text-white">${anime.Year || 'N/A'}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded bg-secondary bg-opacity-25">
                                        <strong class="text-info">URLs:</strong>
                                        <div class="h5 mb-0 text-white">${anime.urls ? anime.urls.length : 0}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            detailsContent.innerHTML = detailsHtml;
            const detailsModalEl = document.getElementById('detailsModal');
            detailsModalEl.querySelector('.modal-content').classList.add('bg-dark', 'text-light');
            const modal = new bootstrap.Modal(detailsModalEl);
            modal.show();
        },

        editDetails: function(index) {
            const anime = this.data[index];
            if (!anime) return;

            const editForm = document.getElementById('editForm');
            // Populate form fields
            Object.keys(anime).forEach(key => {
                const input = editForm.querySelector(`[name="${key}"]`);
                if (input) {
                    if (Array.isArray(anime[key])) {
                        input.value = anime[key].join(', ');
                    } else {
                        input.value = anime[key];
                    }
                }
            });

            // Store current index for saving
            editForm.dataset.index = index;
            
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        },

        saveEdit: function(form) {
            const index = parseInt(form.dataset.index);
            if (isNaN(index)) return;

            const formData = new FormData(form);
            const updatedAnime = {...this.data[index]};

            this.processFormData(formData, updatedAnime);
            // Validate with isInitialUpload = false for flexible editing
            if (this.validateAnimeData([updatedAnime], [], [], false)) {
                this.updateAnimeData(index, updatedAnime);
            }
        },

        processFormData: function(formData, updatedAnime) {
            formData.forEach((value, key) => {
                const trimmedValue = value.trim();
                updatedAnime[key] = this.processFieldValue(key, trimmedValue);
            });
        },

        processFieldValue: function(key, value) {
            if (value === '') return null;

            switch(key) {
                case 'Genres':
                case 'urls':
                    return this.processArrayField(value);
                case 'MAL Score':
                case 'Total Episodes':
                case 'Year':
                    return this.processNumericField(value);
                default:
                    return value;
            }
        },

        processArrayField: function(value) {
            const array = value.split(',')
                .map(item => item.trim())
                .filter(item => item !== '');
            return array.length ? array : null;
        },

        processNumericField: function(value) {
            const num = Number(value);
            return isNaN(num) ? null : num;
        },

        updateAnimeData: function(index, updatedAnime) {
            this.data[index] = updatedAnime;
            this.displayPreview(this.data);
            this.closeEditModal();
            this.showSuccessToast('Anime details updated successfully!');
        },

        // =========================================
        // UI Utilities
        // =========================================
        resetUpload: function() {
            const fileInput = document.getElementById('jsonFile');
            if (fileInput) {
                fileInput.value = '';
            }
            // Clear preview data
            this.data = [];
            const previewTable = document.getElementById('previewData');
            const displayCountEl = document.getElementById('displayCount');
            const totalCountEl = document.getElementById('totalCount');
            
            if (previewTable) previewTable.innerHTML = '';
            if (displayCountEl) displayCountEl.textContent = '0';
            if (totalCountEl) totalCountEl.textContent = '0';
            document.getElementById('uploadBtn').disabled = true;
        },

        closeEditModal: function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            if (modal) modal.hide();
        },

        showSuccessToast: function(message) {
            const toastHtml = `
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div class="toast align-items-center text-white bg-success border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>`;
            
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            const toastEl = document.querySelector('.toast');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
            
            // Remove toast after it's hidden
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        },

        showErrorModal: function(message) {
            const modalHtml = `
                <div class="modal fade" id="errorModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-light">
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title">Validation Error</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${message}
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('errorModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add new modal
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('errorModal'));
            modal.show();
        },

        // =========================================
        // Upload Operations
        // =========================================
        uploadData: async function() {
            if (!this.data.length) {
                this.showErrorModal('No data to upload');
                return;
            }

            const modal = new bootstrap.Modal(document.getElementById('uploadProgressModal'));
            modal.show();

            const progressBar = document.getElementById('uploadProgress');
            const statusText = document.getElementById('uploadStatus');
            let completed = 0;

            for (const anime of this.data) {
                try {
                    statusText.textContent = `Uploading: ${anime.Title}`;
                    
                    const response = await fetch(`${baseUrl}admin/uploadAnimeData`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(anime)
                    });

                    const result = await response.json();
                    if (!response.ok || result.status !== 'success') {
                        throw new Error(result.message || 'Upload failed');
                    }

                    completed++;
                    const progress = (completed / this.data.length) * 100;
                    progressBar.style.width = `${progress}%`;
                    progressBar.textContent = `${Math.round(progress)}%`;

                } catch (error) {
                    console.error('Upload error:', error);
                    this.showErrorModal(`Failed to upload ${anime.Title}: ${error.message}`);
                    modal.hide();
                    return;
                }
            }

            statusText.textContent = 'Upload completed successfully!';
            progressBar.classList.remove('progress-bar-animated');
            
            setTimeout(() => {
                modal.hide();
                this.showSuccessToast('All anime data uploaded successfully!');
                this.resetUpload();
            }, 1500);
        }
    }; // End of AnimeManager object

    // Initialize after definition
    window.AnimeManager.init();
} else {
    // If AnimeManager exists, just reinitialize it
    window.AnimeManager.init();
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => window.AnimeManager.init());
} else {
    window.AnimeManager.init();
}
