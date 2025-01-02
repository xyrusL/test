<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        
        .sidebar .logo {
            font-size: 24px;
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid #34495e;
        }
        
        .sidebar .menu {
            margin-top: 20px;
        }
        
        .sidebar .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 8px 0;
            border-radius: 5px;
        }
        
        .sidebar .menu a:hover {
            background: #34495e;
        }
        
        .submenu {
            margin: 8px 0;
        }
        
        .submenu-trigger {
            display: block;
            padding: 12px 20px;
            border-radius: 5px;
        }
        
        .submenu-trigger:hover {
            background: #34495e;
        }
        
        .submenu-content {
            display: none;
            margin-left: 20px;
        }
        
        .submenu-content a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            margin: 4px 0;
            border-radius: 5px;
        }
        
        .submenu-content a:hover {
            background: #34495e;
        }
        
        .main-content {
            flex: 1;
            background: #f5f6fa;
        }
        
        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .content {
            padding: 20px;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="logo">Admin Panel</div>
            <div class="menu">
                <a href="#"><i class="fas fa-home"></i> Dashboard</a>
                <div class="submenu">
                    <a href="#" class="submenu-trigger"><i class="fas fa-newspaper"></i> Content <i class="fas fa-chevron-down"></i></a>
                    <div class="submenu-content">
                        <a href="#"><i class="fas fa-star"></i> Featured Post</a>
                        <a href="#"><i class="fas fa-tv"></i> Anime Series</a>
                    </div>
                </div>
                <a href="#"><i class="fas fa-users"></i> Users</a>
                <a href="#"><i class="fas fa-cog"></i> Settings</a>
                <a href="#"><i class="fas fa-chart-bar"></i> Reports</a>
                <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h2>Dashboard Overview</h2>
            </div>
            
            <div class="content">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submenuTrigger = document.querySelector('.submenu-trigger');
            const submenuContent = document.querySelector('.submenu-content');
            
            submenuTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                submenuContent.style.display = submenuContent.style.display === 'block' ? 'none' : 'block';
                this.querySelector('.fa-chevron-down').style.transform = 
                    submenuContent.style.display === 'block' ? 'rotate(180deg)' : 'rotate(0)';
            });
        });
    </script>
</body>
</html>
