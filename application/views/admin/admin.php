<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: linear-gradient(180deg, #1a1c23 0%, #242731 100%);
            --sidebar-hover: rgba(255, 255, 255, 0.1);
            --text-color: rgba(255, 255, 255, 0.85);
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(255, 255, 255, 0.1);
        }
        body {
            background: linear-gradient(135deg, #1a1c23 0%, #242731 100%);
            color: var(--text-color);
        }
        .sidebar {
            min-width: 250px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
        }
        .nav-link {
            color: var(--text-muted);
            padding: 0.8rem 1rem;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 2px 0;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
        }
        .nav-link:hover, 
        .nav-link:focus {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .nav-link.active {
            background: var(--sidebar-hover);
            color: #fff;
            font-weight: 500;
        }
        .nav-link[data-bs-toggle="collapse"] {
            position: relative;
            display: flex;
            align-items: center;
        }
        .nav-link[data-bs-toggle="collapse"] i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }
        .nav-link[data-bs-toggle="collapse"]::after {
            content: '\F285';
            font-family: 'bootstrap-icons';
            font-size: 0.8rem;
            transition: transform 0.35s ease;
            opacity: 0.7;
            margin-left: auto;
        }
        .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] {
            color: #fff;
        }
        .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]::after {
            transform: rotate(90deg);
            opacity: 1;
        }
        .submenu {
            margin-left: 2.5rem;
            border-left: 2px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 0 0.5rem 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .submenu .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            margin: 0.2rem 0;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s ease;
        }
        .submenu .nav-link::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 50%;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--border-color);
            transform: translateY(-50%);
            transition: all 0.2s ease;
        }
        .submenu .nav-link:hover::before {
            background: #fff;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }
        .submenu .nav-link:hover {
            color: #fff;
            padding-left: 1.5rem;
        }
        h4, h5 {
            color: #fff;
        }
        hr {
            border-color: var(--border-color);
        }
        .text-danger {
            color: #ff4d4d !important;
        }
    </style>
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
            <div class="container-fluid">
                <h4 class="mb-4">Dashboard</h4>
                <!-- Main content goes here -->
            </div>
        </main>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
