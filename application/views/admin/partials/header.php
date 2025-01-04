<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="<?= base_url('assets/js/admin.js') ?>"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="<?= site_url('admin/dashboard') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>

                        <!-- Posts Management -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#postsSubmenu">
                                <span><i class="bi bi-file-text"></i> Posts</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse" id="postsSubmenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/anime_post') ?>">
                                            <i class="bi bi-list"></i> Anime Posts
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/menus/featured_post') ?>">
                                            <i class="bi bi-plus-circle"></i> Featured Posts
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Users Management -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#usersSubmenu">
                                <span><i class="bi bi-people"></i> Users</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse" id="usersSubmenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/users/all') ?>">
                                            <i class="bi bi-person-lines-fill"></i> All Users
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/users/new') ?>">
                                            <i class="bi bi-person-plus"></i> Add New
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/users/roles') ?>">
                                            <i class="bi bi-person-badge"></i> Roles
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Settings -->
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#settingsSubmenu">
                                <span><i class="bi bi-gear"></i> Settings</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse" id="settingsSubmenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/settings/general') ?>">
                                            <i class="bi bi-sliders"></i> General
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/settings/appearance') ?>">
                                            <i class="bi bi-palette"></i> Appearance
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="<?= site_url('admin/settings/security') ?>">
                                            <i class="bi bi-shield-lock"></i> Security
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Logout -->
                        <li class="nav-item mt-4">
                            <a class="nav-link text-white" href="<?= site_url('admin/logout') ?>">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">