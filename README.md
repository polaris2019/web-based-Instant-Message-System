# Web-based Instant Messaging System

A real-time instant messaging system built with ThinkPHP 6, featuring user authentication, real-time messaging, and a clean Bootstrap UI.

## Features

- User registration and authentication
- Real-time messaging between users
- Message history
- Online users list
- Clean and responsive UI using Bootstrap 5
- SQLite database for easy setup

## Requirements

- PHP >= 7.4
- Composer
- SQLite 3
- Web browser with JavaScript enabled

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd Web-based-IM
```

2. Install dependencies:
```bash
composer install
```

3. Configure the environment:
```bash
cp .example.env .env
```

4. Create the SQLite database:
```bash
mkdir -p database
touch database/database.sqlite
```

5. Run database migrations:
```bash
php think migrate:run
```

## Configuration

### Database Configuration
The system uses SQLite by default. The configuration is already set in `config/database.php`. If you need to modify any settings, you can edit this file.

### Environment Variables
Edit the `.env` file with your preferred settings:
```env
APP_DEBUG = true
APP_TRACE = false

[DATABASE]
TYPE = sqlite
DATABASE = database/database.sqlite
PREFIX = think_
```

## Running the Application

1. Start the development server:
```bash
php think run
```

2. Access the application:
- Registration: `http://localhost:8000/user/register`
- Login: `http://localhost:8000/user/login`
- Chat Interface: `http://localhost:8000/chat`

## System Structure

### Controllers
- `UserController`: Handles user registration, login, and profile management
- `MessageController`: Manages message sending and retrieval
- `ChatController`: Manages chat sessions and real-time updates

### Models
- `User`: User data model with authentication methods
- `Message`: Message data model with relationships

### Views
- `view/user/login.html`: User login interface
- `view/user/register.html`: User registration interface
- `view/chat/index.html`: Main chat interface

### Routes
All routes are defined in `route/app.php`:
- User routes (`/user/*`)
- Message routes (`/message/*`)
- Chat routes (`/chat/*`)

## Usage

1. Register a new account at `/user/register`
2. Log in with your credentials at `/user/login`
3. Once logged in, you'll be redirected to the chat interface
4. Select a user from the list to start chatting
5. Messages are sent in real-time and stored in the database

## Security Features

- Password hashing using PHP's built-in password_hash()
- Session-based authentication
- Input validation and sanitization
- CSRF protection (built into ThinkPHP 6)

## Development

### Adding New Features
1. Create new controllers in `app/controller/`
2. Add routes in `route/app.php`
3. Create corresponding views in `view/`

### Database Modifications
1. Create new migrations in `database/migrations/`
2. Run migrations: `php think migrate:run`

## Troubleshooting

### Common Issues

1. Database Connection Error
```bash
# Check database file permissions
chmod 666 database/database.sqlite
```

2. Server Not Starting
```bash
# Check if port 8000 is already in use
netstat -ano | findstr :8000
# Use a different port
php think run -p 8001
```

3. Composer Dependencies
```bash
# Clear composer cache
composer clear-cache
# Update dependencies
composer update
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the Apache License 2.0 - see the LICENSE.txt file for details.
