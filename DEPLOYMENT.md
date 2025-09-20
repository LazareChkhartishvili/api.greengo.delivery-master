# 🚀 Railway Deployment Guide

## Admin Users Setup

### 📋 Commands to run on Railway

After deployment, run these commands in Railway's terminal:

```bash
# 1. Run migrations
php artisan migrate --force

# 2. Create admin users (Production seeder)
php artisan db:seed --class=ProductionAdminSeeder --force

# 3. Or run individual seeders if needed:
php artisan db:seed --class=UserRoleSeeder --force
php artisan db:seed --class=UserStatusSeeder --force
php artisan db:seed --class=AdminUserSeeder --force
```

### 🔐 Admin Accounts Created

After running the seeder, you'll have these admin accounts:

1. **Primary Admin:**

    - Email: `admin@greengo.delivery`
    - Password: `admin123`

2. **Super Admin:**

    - Email: `superadmin@greengo.delivery`
    - Password: `admin2024!`

3. **Deploy Admin:**
    - Email: `deploy@greengo.delivery`
    - Password: `deploy2024!`

### 🛠️ Railway Environment Variables

Make sure these are set in Railway:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-domain.up.railway.app

# Database will be auto-configured by Railway
```

### 🔧 If Admin Users Don't Work

If you can't login, run this in Railway terminal:

```bash
# Check if users exist
php artisan tinker --execute="print_r(App\Models\User::where('role_id', 1)->get(['id', 'name', 'email'])->toArray()); exit;"

# Recreate admin users
php artisan db:seed --class=ProductionAdminSeeder --force
```

### 📝 Manual User Creation (if needed)

If seeders fail, create admin manually in Railway terminal:

```bash
php artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;
User::firstOrCreate(['email' => 'admin@greengo.delivery'], [
    'name' => 'Admin User',
    'password' => Hash::make('admin123'),
    'role_id' => 1,
    'status_id' => 1,
    'email_verified_at' => now()
]);
echo 'Admin created!';
exit;
"
```

## 🔄 Files Changed for Deployment

-   `database/seeders/AdminUserSeeder.php` - Updated with firstOrCreate
-   `database/seeders/ProductionAdminSeeder.php` - New production seeder
-   `app/Http/Controllers/API/AdminCompanyController.php` - Fixed Company_id → category_id bug

## ✅ Testing

Test admin login on Railway:

1. Go to your Railway app URL
2. Navigate to admin login
3. Use any of the admin accounts listed above
4. Should work without 404 errors now

## 🧪 Deploy Test - 2025-09-20
Testing if Railway auto-seeding is fixed - only admin users should be preserved, deleted data should NOT return.
