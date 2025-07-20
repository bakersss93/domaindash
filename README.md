# DomainDash

DomainDash is a Laravel based dashboard for managing domain names, hosting and SSL services. It integrates with the Synergy Wholesale API to synchronise domain data and allows administrators and customers to view and manage their services through a single interface.

## Installation

1. Clone the repository and install PHP dependencies:

   ```bash
   composer install
   ```

2. Install JavaScript dependencies for the front‑end assets:

   ```bash
   npm install
   ```

3. Copy the example environment file and generate an application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database settings in `.env` and run the migrations:

   ```bash
   php artisan migrate
   ```

## Environment variables

DomainDash requires credentials for the Synergy Wholesale API. Add the following variables to your `.env` file:

```env
SYNERGY_API_URL=https://api.synergywholesale.com
SYNERGY_RESELLER_ID=your-reseller-id
SYNERGY_API_KEY=your-api-key
```

These values are used by `config/synergy.php` and are needed for any interaction with the Synergy API.

## Running tests

The project includes a suite of PHPUnit feature and unit tests. Once the dependencies and environment file are in place you can execute:

```bash
php artisan test
```

This command will run all tests defined in the `tests` directory.
