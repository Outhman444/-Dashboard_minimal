# Dashboard - Management System

A dashboard project built with the Symfony framework.

## Description
A comprehensive management system with user authentication, category management, and product management features.

## Developer
- **Outmane Yasyn**


## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher

## Installation

1. Clone the repository:
```bash
git clone [REPOSITORY_URL]
```

2. Install dependencies:
```bash
composer install
```

3. Set up environment file:
```bash
cp .env .env.local
```

4. Configure database in `.env.local` file

5. Create database and run migrations:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. Load initial data (optional):
```bash
php bin/console doctrine:fixtures:load
```

## Features

- User and role management
- Category management
- Product management
- User-friendly interface

- ######################################################################

- ## Acknowledgment

This project was developed during my internship at **Pixcod Digital Agency**.  
Special thanks to the team for their guidance and support❤❤.

