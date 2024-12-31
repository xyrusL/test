# Anime Series Website

A CodeIgniter 3 based website for streaming anime series, featuring both dubbed and subbed content.

## Features

- Browse all anime series
- Filter anime by:
  - Dubbed anime
  - Subbed anime
  - Anime movies
- Load more functionality for pagination
- Modern and responsive interface

## Tech Stack

- CodeIgniter 3
- PHP
- MySQL
- JavaScript/jQuery
- Bootstrap (for styling)

## Project Structure

```
application/
├── controllers/
│   └── Home.php         # Main controller for anime operations
├── models/
│   └── fetchAnimeModel.php  # Handles database operations
└── views/
    └── homepage.php     # Main interface
```

## Setup

1. Clone the repository
2. Configure your database settings in `application/config/database.php`
3. Import the database schema
4. Run using XAMPP or similar PHP server

## Requirements

- PHP 7.3 or higher
- MySQL
- XAMPP/Web Server
