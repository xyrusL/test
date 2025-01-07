<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_panel.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!--JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
</head>

<body class="bg-white">
    <div class="d-flex">
        <nav class="sidebar p-4">
            <div class="mb-4">
                <h5 class="mb-3">Admin Panel</h5>
            </div>
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contentSubmenu" data-bs-toggle="collapse">
                        <i class="bi bi-file-text"></i>
                        <span>Content</span>
                    </a>
                    <div class="collapse submenu" id="contentSubmenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Featured Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">Anime Post</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-people me-2"></i>Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-bar-chart me-2"></i>Reports
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <hr>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#">
                        <i class="bi bi-box-arrow-right me-2"></i>Log out
                    </a>
                </li>
            </ul>
        </nav>
        <main class="flex-grow-1 p-4">
            <div class="container-fluid" id="mainContent">
                <!-- Main content goes here -->
                <?= $this->load->view('admin/menus/featured_post', [], TRUE); ?>
            </div>
        </main>
    </div>
</body>
<script>
    $(document).ready(function() {
        // Event listener for all navigation links
        $('.nav-link').click(function(e) {
            const menuText = $(this).text().trim();

            // Map menu text to page identifiers
            const pageMap = {
                'Anime Post': 'anime_post',
                'Featured Post': 'featured_post'
                // Add new pages here easily
            };

            if (pageMap[menuText]) {
                e.preventDefault();

                // Show loading indicator
                $('#mainContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

                // Fetch content using generic endpoint
                $.ajax({
                    url: '<?= base_url() ?>' + 'admin/load_page/' + pageMap[menuText],
                    type: 'GET',
                    dataType: 'html',
                    success: function(response) {
                        $('#mainContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading content:', error);
                        $('#mainContent').html('<div class="alert alert-danger">Error loading content. Please try again later.</div>');
                    }
                });
            }
        });
    });
</script>

</html>