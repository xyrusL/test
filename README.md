# Anime Series Website

A CodeIgniter 3 based website for streaming anime series, featuring both dubbed and subbed content.

## Features

- Browse all anime series
- Filter anime by:
  - Dubbed/Subbed
  - Genre
  - Season
  - Year
  - Status
- Admin dashboard for content management
- Dark mode interface
- Bootstrap responsive design
- JSON-based content updates

## Project Structure

```
application/
├── controllers/
│   ├── Home.php         # Main controller for anime operations
│   └── Admin.php        # Admin dashboard controller with content management
├── models/
│   ├── fetchAnimeModel.php  # Handles database operations for anime
│   └── admin/
│       └── UploadModel.php  # Handles admin data upload operations
└── views/
    ├── homepage.php     # Main interface
    └── admin/
        ├── dashboard.php    # Admin dashboard main layout
        └── content/         # Dynamic content sections
            ├── anime_post.php   # Anime upload and management
            ├── featured_post.php # Featured content management
            ├── monitoring.php    # Dashboard statistics
            ├── reports.php       # System reports
            └── settings.php      # System settings
```

### Controllers

- **Admin.php**
  - `dashboard()`: Renders the main admin interface
  - `upload()`: Handles anime upload form
  - `uploadAnimeData()`: Processes JSON anime data uploads
  - `load_content()`: Dynamic content loading for dashboard sections

### Models

- **admin/UploadModel.php**
  - `insertAnimeData()`: Inserts new anime data from JSON uploads

### Views

#### Admin Dashboard
- **dashboard.php**: Main layout with:
  - Responsive sidebar navigation
  - Dynamic content area
  - Bootstrap 5.3 integration
  - FontAwesome icons

#### Content Views
- **anime_post.php**
  - JSON file upload form
  - Data preview table
  - Bootstrap card layout
- **featured_post.php**
  - Featured content management
  - Content listing table
- **monitoring.php**
  - Dashboard statistics
  - Activity monitoring

## Setup

1. Clone the repository
2. Configure your database settings in `application/config/database.php`
3. Import the database schema
4. Run using XAMPP or similar PHP server

## Requirements

- PHP 7.3 or higher
- MySQL
- XAMPP/Web Server
- Bootstrap 5.3
- jQuery 3.7.1
- FontAwesome 6.0
