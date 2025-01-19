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
- [Setting up Reverse Proxy](#setting-up-reverse-proxy-with-nginx-proxy-manager)

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

## Running Multiple WordPress Sites

You can run multiple WordPress sites using this setup, sharing the main MySQL server but with separate databases. Here's how to set up additional sites:

1. **Create New Site Directory Structure**
   ```bash
   # Create required directories
   mkdir -p site2/{config,wp-app/wp-content}
   
   # Copy configuration files
   cp wordpress/config/wp_php.ini site2/config/
   ```

2. **Set Up Configuration Files**
   - Create `.env` from template:
     ```bash
     cd site2
     cp .env.sample .env
     ```
   - Configure in `.env`:
     - Different PORT (e.g., 8001)
     - Different DB_NAME (e.g., wordpress_site2)
     - Same DB_ROOT_PASSWORD as main site

   - Create wp-config.php with:
     - Unique table prefix (e.g., 'wp_site2_')
     - Different authentication keys and salts

3. **Create Database and Start Site**
   ```bash
   # Create new database
   docker-compose exec db mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS wordpress_site2;"
   
   # Navigate to site directory
   cd site2
   
   # Start WordPress
   docker-compose up -d
   ```

Your new site will be available at http://127.0.0.1:8001 (or your configured IP:PORT)

### Multi-Site Architecture

Each site has its own:
- Docker Compose file (using shared MySQL)
- WordPress container
- Environment configuration
- wp-content directory
- Database (on shared MySQL server)

Benefits of this approach:
- Simplified database management
- Shared MySQL resources
- Independent WordPress instances
- Separate content directories
- Easy database backups through phpMyAdmin

### Using Nginx Proxy Manager

You can still use the main installation's Nginx Proxy Manager to:
- Set up different domains for each site
- Manage SSL certificates
- Configure reverse proxies for all sites

## Notes

- The wp-content directory is persistent and stored locally
- Database data is stored in ./database/mysql
- For production, ensure you change all default passwords in .env
- Keep your WordPress core, themes, and plugins updated using WP-CLI

## Setting up Reverse Proxy with Nginx Proxy Manager

The Nginx Proxy Manager allows you to easily set up reverse proxies for your WordPress site. This is particularly useful when:
- You want to access your site using a domain name instead of IP:PORT
- You need to set up SSL/TLS certificates
- You're running multiple sites on different ports

### Steps to Configure a Reverse Proxy

1. **Access Nginx Proxy Manager**
   - Go to http://127.0.0.1:81
   - Log in with default credentials (if first time)
   - Change default password when prompted

2. **Add a New Proxy Host**
   - Click "Add Proxy Host"
   - Fill in the following:
     - Domain Names: Your domain (e.g., yourdomain.local)
     - Scheme: http
     - Forward Hostname/IP: wp
     - Forward Port: 80
     - Configure any additional settings as needed

3. **SSL/TLS Configuration (Optional)**
   - In the SSL tab of your proxy host:
     - Select "Request a new SSL Certificate"
     - Or "Use a custom certificate" if you have one
     - Enable Force SSL if desired

4. **Advanced Configuration**
   - Custom locations
   - Websockets support
   - Access lists
   - Custom headers

### Important Notes
- The container name 'wp' is used as the Forward Hostname because Docker's internal DNS will resolve it
- Make sure your domain points to your server's IP if using a real domain
- For local development, add your domain to your hosts file
