document.addEventListener('DOMContentLoaded', function() {
    const submenuTrigger = document.querySelector('.submenu-trigger');
    const submenuContent = document.querySelector('.submenu-content');
    
    // Submenu toggle functionality
    submenuTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent event bubbling
        submenuContent.style.display = submenuContent.style.display === 'block' ? 'none' : 'block';
        this.querySelector('.fa-chevron-down').style.transform = 
            submenuContent.style.display === 'block' ? 'rotate(180deg)' : 'rotate(0)';
    });

    // Function to load content
    function loadContent(contentType) {
        // Update active state
        document.querySelectorAll('.load-content').forEach(el => el.classList.remove('active'));
        document.querySelector(`[data-content="${contentType}"]`)?.classList.add('active');

        // Load content via AJAX
        $.get(`${baseUrl}admin/load_content`, { content: contentType }, function(response) {
            $('#mainContentArea').html(response);
        }).fail(function() {
            alert('Error loading content. Please try again.');
        });
    }

    // Dynamic content loading
    document.querySelectorAll('.load-content').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling
            const content = this.dataset.content;
            
            // Don't reload if clicking the same content
            if (this.classList.contains('active')) return;

            loadContent(content);
        });
    });

    // Load dashboard content by default
    loadContent('dashboard');
});