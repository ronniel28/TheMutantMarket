# Laravel E-Commerce Platform (The Mutant market)

## Description

This project is a **Laravel**-based e-commerce platform that provides a full-featured user experience with product management, cart functionality, order processing, and Stripe payment integration. Admin users have the ability to manage products and users, promote users to administrators, and oversee the overall platform.

---

## Features

- **User Authentication**: Register, login, manage user profiles.
- **Product Management**: View products, add products to the cart, and proceed to checkout.
- **Order Management**: Users can create and view orders.
- **Admin Panel**: Admin users can manage products and users.
- **Role Management**: Promote users to admins.
- **Stripe Integration**: Users can complete their purchases via **Stripe** (test mode).
- **Laravel UI**: For user authentication and basic UI elements.

---

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL or any other database supported by Laravel
- Node.js (for frontend dependencies)
- Stripe Account (for payment integration in test mode)

### Installation Steps

#### 1. Clone the repository

Clone the repository from GitHub:

```bash
git clone git@github.com:ronniel28/TheMutantMarket.git
cd your-project-name
```

#### 2. Install PHP dependencies

Clone the repository from GitHub:

```bash
composer install
```

#### 3. Install frontend dependencies (optional)
Run npm to install frontend dependencies:

```bash
npm install
```

#### 4. Set up the environment file
Copy the .env.example to .env:

```bash
cp .env.example .env
```

Update your database and Stripe credentials in the .env file:
 
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret

#### 5. Generate the application key
Generate your app’s key:

```bash
php artisan key:generate
```

#### 6.Run migrations
Create the necessary database tables by running the migrations:

```bash
php artisan migrate
```

#### 7. Install and configure Spatie Laravel Permission
To manage roles and permissions, install the Spatie Laravel Permission package:

```bash
composer require spatie/laravel-permission
```

Publish the configuration and migration files:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

```
This will create the necessary tables for handling roles and permissions.

#### 8. Set up front-end assets (optional)
If you need to compile front-end assets, run the following:

```bash
npm run dev
```
## Routes

The application has the following routes:

### Public Routes
- `GET /` – Displays the homepage.
- `GET /login` – Login page.
- `GET /register` – Registration page.
- `POST /login` – Login form submission.
- `POST /register` – Registration form submission.

### Authenticated Routes (Requires Login)
- `GET /profile` – View user's profile.
- `PUT /profile` – Update user's profile.
- `PUT /profile/password` – Change user's password.
- `GET /cart` – View cart.
- `POST /cart/add/{product}` – Add a product to the cart.
- `POST /orders` – Create a new order.
- `GET /orders/{order}` – View an order.
- `GET /checkout` – Checkout page.
- `POST /checkout` – Submit checkout details.
- `GET /products` – View all products.

### Admin Routes (Requires Admin Role)
- `GET /products` – List all products (Admin only).
- `POST /products` – Create a new product (Admin only).
- `GET /products/{product}/edit` – Edit product details (Admin only).
- `PUT /products/{product}` – Update product details (Admin only).
- `DELETE /products/{product}` – Delete a product (Admin only).
- `GET /users` – List all users (Admin only).
- `GET /users/{user}/edit` – Edit a user's profile (Admin only).
- `PUT /users/{user}` – Update user profile (Admin only).
- `DELETE /users/{user}` – Delete a user (Admin only).
- `POST /users/{user}/promote` – Promote a user to admin (Admin only).

---

## Roles and Permissions

This application uses the Spatie Laravel Permission package for role management. The following roles are defined:

- **User**: Regular users who can view products, add them to the cart, and place orders.
- **Admin**: Users with additional privileges to manage products, users, and roles.

### Assigning Roles
By default, users are assigned the user role upon registration. Admins have the ability to promote users to the admin role via the Promote User functionality.

---

## Stripe Integration

This platform integrates with Stripe to process payments:

1. Create a Stripe account and obtain your test API keys.
2. Update the `.env` file with your Stripe credentials (`STRIPE_KEY` and `STRIPE_SECRET`).
3. Users can make payments via Stripe in test mode, allowing for mock transactions during testing.

---

## Admin Panel

Admin users can access the following sections:

- **Manage Products**: Add, edit, and delete products.
- **Manage Users**: View, edit, and delete user accounts.
- **Promote Users**: Promote regular users to admins.

Admin functionalities are protected using the `role:admin` middleware, ensuring that only users with the admin role can access them.