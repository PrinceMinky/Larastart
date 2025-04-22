# Larastart

A modern Laravel starter application featuring Livewire components with built-in user profiles, follow/unfollow functionality, and user blocking capabilities.

## Features

- User authentication and profiles
- Follow/unfollow system
- User blocking functionality
- Mutual followers detection
- Toast notifications
- Modal system

## Requirements

- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL or PostgreSQL database

## Installation

Follow these steps to get the application up and running on your local machine:

### 1. Clone the repository

```bash
git clone https://github.com/PrinceMinky/larastart.git
cd larastart
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Create environment file

Copy the example environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure database

Edit the `.env` file and set your database connection details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larastart
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run migrations

Set up the database tables:

```bash
php artisan migrate
```

### 7. Compile assets

```bash
npm run dev
```

### 8. Start the server

```bash
php artisan serve
```

Your application will be available at `http://localhost:8000`.

## Running Tests

This project includes feature tests for the user profile and blocking functionality:

```bash
php artisan test
```

## Usage

### User Profile Component

The `UserProfile` component displays user profiles and includes functionality to follow/unblock users:

```php
// Route definition example
Route::get('/user/{username}', App\Livewire\UserProfile::class);
```

### Block User Functionality

The blocking system automatically:

1. Removes mutual follow relationships
2. Prevents blocked users from viewing your profile
3. Provides toast notifications when users are blocked/unblocked

```php
// Example of manually toggling a block in your own controller
$user->toggleBlock($otherUser);
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

<<<<<<< HEAD
This project is open-sourced software licensed under the [MIT license](LICENSE.md).
=======
This project is open-sourced software licensed under the [MIT license](LICENSE.md).
>>>>>>> 943cc577c799ac23de563fb3586488fb1f7d7766
