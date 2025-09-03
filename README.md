# Dashboard - Management System

A dashboard project built with the Symfony framework.

## Description
A comprehensive management system with user authentication, category management, and product management features.


## Screenshots of the Project

<div style="display: flex; flex-wrap: wrap; gap: 10px;">

  <img src="https://github.com/user-attachments/assets/f2dccdab-da87-487e-a36c-3c01ceec4bb2" alt="Product" width="300" />
  
  <img src="https://github.com/user-attachments/assets/38ed5888-9c79-4656-9b85-f5b09d29fb58" alt="Ajouter un product" width="300" />
  <img src="https://github.com/user-attachments/assets/4fc7083a-603d-46d2-9c86-2a240d99fb28" alt="Login" width="300" />
  <img src="https://github.com/user-attachments/assets/38210d26-7475-44fd-bdfb-bb7991459f2a" alt="Login" width="300" />
    
    



</div>


## Developer
- **Outmane Yasyn**


## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Outhman444/-Dashboard_minimal.git
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


- ######################################################################

- ## Acknowledgment

This project was developed during my internship at **Pixcod Digital Agency**.  
Special thanks to the team for their guidance and support❤❤.

