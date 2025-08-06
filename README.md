# Mail Tracker

A Laravel + Vue.js application for tracking outgoing and incoming mail correspondence.

## Features

- 📮 **Sent Mail Tracking** - Track mail that has been sent
- ❤️ **Offers Management** - Manage pending mail offers before sending
- 🎯 **Interactive Status Updates** - Click buttons to update thanked and sent status
- 👤 **User Authentication** - Secure user accounts with Laravel Breeze
- 🌙 **Dark Mode Support** - Built-in light/dark theme switching
- 📱 **Responsive Design** - Works on desktop and mobile devices

## Tech Stack

- **Backend**: Laravel 11.x + PHP 8.1+
- **Frontend**: Vue.js 3 + TypeScript + Inertia.js
- **Styling**: Tailwind CSS + shadcn/ui components
- **Icons**: Lucide Vue
- **Build Tool**: Vite 7.x
- **Database**: SQLite (default) or MySQL/PostgreSQL

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.1 or higher**
- **Composer** (PHP dependency manager)
- **Node.js 18.x or higher**
- **npm** (Node package manager)

### Check Your Versions
```bash
php --version
composer --version
node --version
npm --version
```

## Installation

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd mail-tracker
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Environment Setup
```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup
```bash
# Run database migrations
php artisan migrate

# (Optional) Seed the database with sample data
php artisan db:seed
```

### 6. Generate Frontend Routes
```bash
# Generate Ziggy routes for frontend
php artisan ziggy:generate
```

### 7. Build Frontend Assets
```bash
# For development
npm run dev

# For production
npm run build
```

## Running the Application

### Development Mode

**Terminal 1** - Start the Laravel development server:
```bash
php artisan serve
```

**Terminal 2** - Start the Vite development server (for hot reloading):
```bash
npm run dev
```

Visit: `http://localhost:8000`

### Production Mode
```bash
# Build assets for production
npm run build

# Start the Laravel server
php artisan serve
```

## Usage

### Getting Started

1. **Register/Login** - Create an account or log in
2. **Dashboard** - View your mail tracking overview
3. **Offers** - Manage pending mail (not yet sent)
4. **Sent** - View mail that has been sent
5. **Settings** - Manage your profile and preferences

### Adding Mail Records

1. Click **"Add outgoing mail"** button on any page
2. Fill in the form:
   - **Username**: Recipient's username/handle
   - **Name**: Recipient's full name (optional)
   - **Date**: Date of correspondence
   - **Country**: Recipient's country (required)
   - **Region/State**: Recipient's state/region (optional)
   - **City**: Recipient's city (optional)
   - **Occasion**: Special occasion (optional)
   - **Description**: Details about the mail
   - **Link**: Related URL (optional)
   - **Thanked**: Whether they've thanked you
   - **Has Been Sent**: Whether the mail has been sent

### Managing Records

#### Offers Page
- View mail that hasn't been sent yet (`has_been_sent = false`)
- **📮 Send Button**: Click to mark as sent and move to Sent page
- **Thanked Button**: Toggle between ✗ No (red) and ✓ Yes (green)

#### Sent Page  
- View mail that has been sent (`has_been_sent = true`)
- **✓ Sent Badge**: Shows the item has been sent (non-clickable)
- **Thanked Button**: Toggle between ✗ No (red) and ✓ Yes (green)

## Database Schema

### Users Table
- Standard Laravel authentication fields

### Outgoing Table
- `user_id` - Foreign key to users
- `username` - Recipient username
- `name` - Recipient full name
- `date` - Date of mail
- `country` - Recipient country
- `region` - Recipient state/region  
- `city` - Recipient city
- `occasion` - Special occasion
- `description` - Mail description
- `link` - Related URL
- `thanked` - Boolean for thank status
- `has_been_sent` - Boolean for sent status

## API Endpoints

### Authentication
- `GET /login` - Login page
- `POST /login` - Authenticate user
- `POST /logout` - Logout user
- `GET /register` - Registration page
- `POST /register` - Create account

### Mail Management
- `GET /dashboard` - Dashboard page
- `GET /outgoing` - Sent mail page (has_been_sent = true)
- `GET /offers` - Offers page (has_been_sent = false)
- `POST /outgoing` - Create new mail record
- `PATCH /outgoing/{id}/thanked` - Toggle thanked status
- `PATCH /outgoing/{id}/has-been-sent` - Toggle sent status

### Settings
- `GET /settings/profile` - Profile settings
- `GET /settings/password` - Password settings
- `GET /settings/appearance` - Theme settings

## Development

### File Structure
```
mail-tracker/
├── app/
│   ├── Http/Controllers/     # Laravel controllers
│   └── Models/              # Eloquent models
├── database/
│   └── migrations/          # Database migrations
├── resources/
│   ├── js/
│   │   ├── components/      # Vue components
│   │   ├── layouts/         # Page layouts
│   │   ├── pages/          # Inertia pages
│   │   └── types/          # TypeScript types
│   └── css/                # Stylesheets
├── routes/                 # Laravel routes
└── public/                # Public assets
```

### Key Components
- `TopNavigation.vue` - Main navigation bar
- `AddOutgoing.vue` - Modal form for adding records
- `Outgoing.vue` - Sent mail page
- `Offers.vue` - Offers management page

### Commands

```bash
# Laravel commands
php artisan route:list          # View all routes
php artisan tinker             # Laravel REPL
php artisan migrate:fresh      # Fresh migration
php artisan ziggy:generate     # Generate frontend routes

# Node commands  
npm run dev                    # Development build
npm run build                  # Production build
npm run lint                   # Lint code
```

## Troubleshooting

### Common Issues

**1. Crypto.hash Error During Build**
```bash
# The project includes a Node.js 18 compatibility polyfill
# If you still get errors, ensure you're using Node.js 18+
node --version
```

**2. Authorization Errors**
- Ensure you're logged in
- Check that `user_id` matches in database
- Clear browser cache and try again

**3. Routes Not Found**
```bash
# Regenerate routes
php artisan ziggy:generate
npm run build
```

**4. Database Issues**
```bash
# Reset database
php artisan migrate:fresh
php artisan db:seed
```

**5. Permission Errors**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

### Environment Issues

**PHP Version**
- Requires PHP 8.1 or higher
- Check with `php --version`

**Node.js Version**
- Requires Node.js 18.x or higher  
- Check with `node --version`

**Database**
- Default uses SQLite (no setup needed)
- For MySQL/PostgreSQL, update `.env` file

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For issues and questions:
1. Check the troubleshooting section above
2. Search existing issues
3. Create a new issue with detailed information

---

**Happy mail tracking!** 📮✨ 