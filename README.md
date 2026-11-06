# Laguna University - BS Entrepreneurship Stall Website

A PHP-based website for the BS Entrepreneurship Stall at Laguna University.

## Folder Structure

```
├── public/                 # Public web root
│   └── index.php          # Entry point
├── src/                   # Application source code
│   ├── Controllers/       # Controller classes
│   ├── Models/            # Model classes
│   └── Views/             # View templates
│       ├── layouts/       # Layout templates
│       ├── partials/      # Reusable partials
│       └── pages/         # Page templates
├── assets/                # Static assets
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   └── images/            # Images
├── config/                # Configuration files
├── database/              # Database migrations/seeds
└── vendor/                # Composer dependencies (gitignored)
```

## Requirements

- PHP 8.0+
- MySQL/MariaDB
- Composer (for dependencies)
- Web server (Apache/Nginx) or PHP built-in server

## Setup

1. Clone the repository
2. Run `composer install` (when dependencies are added)
3. Create database `laguna_university_stall`
4. Configure database in `config/config.php`
5. Start the development server:
   ```bash
   php -S localhost:8000 -t public
   ```

## Features

- Home page with hero section
- Products catalog
- About page
- Contact form
- Responsive design with Bootstrap 5
- Clean MVC-inspired structure

## Development

The site uses a simple MVC-like pattern:
- **Controllers** handle requests and logic
- **Views** handle presentation
- **Models** (to be added) handle data

## License

MIT License