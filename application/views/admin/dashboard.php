<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dashboard.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        const baseUrl = '<?php echo base_url(); ?>';
    </script>
    <script defer src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="logo">Admin Panel</div>
            <div class="menu">
                <a href="#" class="load-content" data-content="dashboard"><i class="fas fa-home"></i> Dashboard</a>
                <div class="submenu">
                    <a href="#" class="submenu-trigger"><i class="fas fa-newspaper"></i> Content <i class="fas fa-chevron-down"></i></a>
                    <div class="submenu-content">
                        <a href="#" class="load-content" data-content="featured_post"><i class="fas fa-star"></i> Featured Post</a>
                        <a href="#" class="load-content" data-content="anime_post"><i class="fas fa-tv"></i> Anime Series</a>
                    </div>
                </div>
                <a href="#" class="load-content" data-content="users"><i class="fas fa-users"></i> Users</a>
                <a href="#" class="load-content" data-content="settings"><i class="fas fa-cog"></i> Settings</a>
                <a href="#" class="load-content" data-content="reports"><i class="fas fa-chart-bar"></i> Reports</a>
                <a href="#" class="load-content" data-content="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h2>Dashboard Overview</h2>
            </div>

            <div class="content" id="mainContentArea">
                <div class="dashboard-cards">
                    <div class="card">
                        <h3>Total Users</h3>
                        <p>1,234</p>
                    </div>
                    <div class="card">
                        <h3>Total Revenue</h3>
                        <p>$45,678</p>
                    </div>
                    <div class="card">
                        <h3>New Orders</h3>
                        <p>56</p>
                    </div>
                    <div class="card">
                        <h3>Pending Tasks</h3>
                        <p>12</p>
                    </div>
                </div>

                <div class="card">
                    <h3>Recent Activity</h3>
                    <p>Your recent activity will appear here...</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>