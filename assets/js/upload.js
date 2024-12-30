document.querySelector('.btn').addEventListener('click', function() {
    document.getElementById('fileID').click();
});

document.getElementById('fileID').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type === "application/json") {
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const json = JSON.parse(e.target.result);
                validateJson(json);
            } catch (error) {
                showErrorPopup("Invalid JSON format. Please check your file.");
            }
        };
        reader.readAsText(file);
    } else {
        showErrorPopup("Please select a valid JSON file.");
    }
});

let successCount = 0;
let validCount = 0;
let totalItems = 0;
let processedItems = 0;

/**
 * Validates the JSON data against required fields and initiates upload process
 * @param {Object|Array} json - The parsed JSON data to validate
 */
function validateJson(json) {
    const requiredFields = ["Title", "Poster", "Total Episodes", "Category", "Genres", "MAL Score", "Status", "Language", "Season", "Year", "urls"];
    
    if (Array.isArray(json)) {
        totalItems = json.length;
        json.forEach((item, index) => {
            const missingFields = requiredFields.filter(field => !item.hasOwnProperty(field));
            if (missingFields.length === 0) {
                item.date = new Date().toLocaleDateString();
                console.log(`Item ${index + 1}: Correct`);
                passDataToServer(item);
                validCount++;
            } else {
                showErrorPopup(`Item ${index + 1} is missing required fields: ${missingFields.join(", ")}`);
            }
        });
    } else {
        totalItems = 1;
        const missingFields = requiredFields.filter(field => !json.hasOwnProperty(field));
        if (missingFields.length === 0) {
            json.date = new Date().toLocaleDateString();
            console.log("Correct");
            passDataToServer(json);
            validCount = 1;
        } else {
            showErrorPopup(`JSON is missing required fields: ${missingFields.join(", ")}`);
        }
    }
    
    if (validCount > 0) {
        showLoadingModal();
    }
    
    console.log(`Total valid JSON entries: ${validCount}`);
}

/**
 * Shows the loading modal with progress bar
 */
function showLoadingModal() {
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();
}

/**
 * Updates the progress bar and status message during upload
 * @param {string} title - The title of the anime being uploaded
 */
function updateProgress(title) {
    processedItems++;
    const percentage = Math.round((processedItems / totalItems) * 100);
    
    document.getElementById('uploadStatus').textContent = `Please wait, uploading: ${title}`;
    document.getElementById('uploadProgress').style.width = `${percentage}%`;
    document.getElementById('uploadProgress').setAttribute('aria-valuenow', percentage);
}

/**
 * Sends the anime data to the server and handles the response
 * @param {Object} data - The anime data object to be uploaded
 */
function passDataToServer(data) {
    $.ajax({
         url: "uploadAnimeData",
         type: "POST",
         data: {animeData: JSON.stringify(data)},
         success: function(response) {
             console.log(response);
             updateProgress(data.Title);
             successCount++;
             if (successCount === validCount) {
                 console.log("All Anime Data Uploaded");
                 document.getElementById('loadingModal').querySelector('.modal-body').innerHTML = `
                     <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                     <p class="mt-3 mb-0">Upload Complete</p>
                 `;
                 setTimeout(() => {
                     bootstrap.Modal.getInstance(document.getElementById('loadingModal')).hide();
                     showPopup("Upload Successful");
                     resetUpload();
                 }, 1500);
             }
         },
         error: function(xhr, error) {
             console.error("Error: " + error);
             console.error("Response: " + xhr.responseText);
             document.getElementById('loadingModal').querySelector('.modal-body').innerHTML = `
                 <i class="bi bi-x-circle-fill text-danger" style="font-size: 2rem;"></i>
                 <p class="mt-3 mb-0">Upload Failed</p>
             `;
             setTimeout(() => {
                 bootstrap.Modal.getInstance(document.getElementById('loadingModal')).hide();
                 showErrorPopup("Server error: " + (xhr.responseText || "Unknown error occurred"));
             }, 1500);
         }
    });
}

/**
 * Resets all counters and input field after upload completion
 */
function resetUpload() {
    successCount = 0;
    validCount = 0;
    totalItems = 0;
    processedItems = 0;
    document.getElementById('fileID').value = "";
    console.log("Upload reset. You can upload again.");
}

/**
 * Shows a success popup notification
 * @param {string} message - The success message to display
 */
function showPopup(message) {
    const popup = document.createElement('div');
    popup.className = "modal fade";
    popup.id = "uploadPopup";
    popup.tabIndex = -1;
    popup.innerHTML = `
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-check-circle-fill text-success mb-3" style="font-size: 2rem;"></i>
                    <p class="mb-0">${message}</p>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(popup);
    const modal = new bootstrap.Modal(document.getElementById('uploadPopup'));
    modal.show();
    
    // Auto close popup after 2 seconds
    setTimeout(() => {
        modal.hide();
        document.body.removeChild(popup);
    }, 2000);
}

/**
 * Shows an error popup notification with detailed message
 * @param {string} message - The error message to display
 */
function showErrorPopup(message) {
    const popup = document.createElement('div');
    popup.className = "modal fade";
    popup.id = "errorPopup";
    popup.tabIndex = -1;
    popup.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-exclamation-circle-fill text-warning mb-3" style="font-size: 2rem;"></i>
                    <h6 class="fw-bold mb-2">Upload Error</h6>
                    <p class="text-muted mb-3">${message}</p>
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(popup);
    const modal = new bootstrap.Modal(document.getElementById('errorPopup'));
    modal.show();
    
    // Remove popup from DOM after it's hidden
    popup.addEventListener('hidden.bs.modal', function () {
        document.body.removeChild(popup);
    });
}