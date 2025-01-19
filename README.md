# WordPress Docker Development Environment

This is a Docker-based development environment for WordPress, featuring MySQL, phpMyAdmin, and Nginx Proxy Manager.

## Initial Setup

1. **Environment Configuration**
   ```bash
   cp .env.sample .env
   ```
   Edit `.env` with your preferred settings:
   - `IP`: Local IP address (default: 127.0.0.1)
   - `PORT`: WordPress port (default: 8000)
   - `DB_NAME`: Database name (default: wordpress)
   - `DB_ROOT_PASSWORD`: MySQL root password (default: somewordpress)

2. **Start MySQL First**
   ```bash
   docker-compose up -d db
   ```
   Wait a few seconds for MySQL to initialize completely.

3. **Start WordPress and Nginx Proxy**
   ```bash
   docker-compose up -d wp proxy
   ```
   This will start:
   - WordPress at http://127.0.0.1:8000 (or your configured IP:PORT)
   - Nginx Proxy Manager at http://127.0.0.1:81

## Accessing Services

### WordPress
- Main site: http://127.0.0.1:8000 (or your configured IP:PORT)
- Admin panel: http://127.0.0.1:8000/wp-admin

### phpMyAdmin
- Access at: http://127.0.0.1:8080
- Login with:
  - Server: db
  - Username: root
  - Password: (your DB_ROOT_PASSWORD from .env)

### Nginx Proxy Manager
- Admin UI: http://127.0.0.1:81
- Default login:
  - Email: admin@example.com
  - Password: changeme

## Using WP-CLI

WP-CLI is included for WordPress management. Here are some common commands:

1. **Update WordPress Core**
   ```bash
   docker-compose run --rm wpcli core update
   ```

2. **Update Themes**
   ```bash
   # List themes
   docker-compose run --rm wpcli theme list
   
   # Update all themes
   docker-compose run --rm wpcli theme update --all
   
   # Update specific theme
   docker-compose run --rm wpcli theme update theme-name
   ```

3. **Update Plugins**
   ```bash
   # List plugins
   docker-compose run --rm wpcli plugin list
   
   # Update all plugins
   docker-compose run --rm wpcli plugin update --all
   ```

## Project Structure

```
.
├── wordpress/
│   ├── wp-app/
│   │   ├── wp-config.php
│   │   └── wp-content/
│   └── config/
├── database/
│   ├── mysql/
│   ├── wp-data/
│   └── config/
└── proxy/
    ├── data/
    └── letsencrypt/
```

- `wordpress/`: Contains WordPress configuration and content
- `database/`: Contains MySQL data and phpMyAdmin configuration
- `proxy/`: Contains Nginx Proxy Manager data and certificates

## Database Management with phpMyAdmin

1. **Viewing Database**
   - Log in to phpMyAdmin at http://127.0.0.1:8080
   - Navigate to your database (default: wordpress)
   - Browse tables, run queries, and manage data

2. **Common Operations**
   - View table structure and data
   - Export/Import databases
   - Run SQL queries
   - Manage users and permissions

## Maintenance

1. **Backup Database**
   ```bash
   docker-compose exec db mysqldump -u root -p wordpress > backup.sql
   ```

2. **Stop All Services**
   ```bash
   docker-compose down
   ```

3. **View Logs**
   ```bash
   docker-compose logs -f [service_name]
   ```
   Replace [service_name] with: wp, db, proxy, or pma

## Notes

- The wp-content directory is persistent and stored locally
- Database data is stored in ./database/mysql
- For production, ensure you change all default passwords in .env
- Keep your WordPress core, themes, and plugins updated using WP-CLI
