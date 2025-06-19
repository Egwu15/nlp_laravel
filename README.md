# Nigerian Law Application

A comprehensive digital platform for accessing and navigating Nigerian legal resources, including laws, court rules, and
legal terminology.

## Features

- **Legal Content Access**: Browse Nigerian laws, organized by chapters, parts, and sections
- **Legal Terminology**: Access a comprehensive database of legal terms and definitions
- **User Authentication**: Secure registration and login system
- **Subscription System**: Tiered access plans for different levels of content access
- **Admin Panel**: Manage users, content, and subscriptions through a Filament admin panel
- **API Access**: RESTful API for programmatic access to legal resources

## Technologies Used

- **Backend**: Laravel 12.0, PHP 8.2+
- **Frontend**: Inertia.js, Vue.js
- **Authentication**: Laravel Sanctum, Laravel Breeze
- **Admin Panel**: Filament
- **Testing**: Pest PHP
- **Database**: MySQL/SQLite

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL or SQLite

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/nigerian_law_app.git
   cd nigerian_law_app
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nigerian_law_app
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Run migrations:
   ```bash
   php artisan migrate
   ```

8. Import legal terms (optional):
   ```bash
   php artisan legalterms:import storage/app/legal-terms.json
   ```

9. Build assets:
   ```bash
   npm run build
   ```

10. Start the development server:
    ```bash
    php artisan serve
    ```

## Usage

### Web Interface

1. Register a new account or log in with existing credentials
2. Browse laws through the dashboard
3. Navigate through chapters, parts, and sections
4. Search for specific legal terms

### API Endpoints

- `POST /api/register` - Register a new user
- `POST /api/login` - Log in a user
- `GET /api/user` - Get authenticated user information (requires authentication)
- `POST /api/logout` - Log out a user (requires authentication)

## Administration

Access the admin panel at `/admin` to manage:

- Users
- Laws and legal content
- Subscription plans
- Legal terminology

## Development

Run the development environment with:

```bash
composer dev
```

This will start:

- Laravel development server
- Queue worker
- Log viewer
- Vite development server

## Testing

Run tests with:

```bash
php artisan test
```

## To migrate  the legal terms.

php artisan legal terms:import storage/app/legal-terms.json

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

