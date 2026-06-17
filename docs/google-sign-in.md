# Google Sign-In Implementation Guide

Step-by-step guide for implementing "Sign in with Google" using Laravel Socialite + Inertia.js.

---

## Prerequisites

- Laravel 11+ project with Jetstream / Fortify
- Inertia.js (Vue 3) frontend
- Composer & Node.js installed

---

## Step 1: Google Cloud Console Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Navigate to **APIs & Services** → **Credentials**
4. Click **Create Credentials** → **OAuth 2.0 Client ID**
5. Set **Application type** → **Web application**
6. Add **Authorized redirect URIs**:
   - `https://your-app.com/auth/google/callback`
   - `http://localhost:8000/auth/google/callback` (for local dev)
7. Copy the **Client ID** and **Client Secret**

---

## Step 2: Install Laravel Socialite

```bash
composer require laravel/socialite
```

---

## Step 3: Add Environment Variables

In `.env`:
```
GOOGLE_CLIENT_ID=your-client-id-here
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT=${APP_URL}/auth/google/callback
```

In `.env.example` (for other developers):
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT="${APP_URL}/auth/google/callback"
```

---

## Step 4: Configure Services (`config/services.php`)

Add the Google provider config:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT'),
],
```

---

## Step 5: Create Database Migration

```bash
php artisan make:migration add_google_id_to_users_table --table=users
```

```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('google_id')->nullable()->unique()->after('password');
        $table->text('avatar')->nullable()->after('google_id');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['google_id', 'avatar']);
    });
}
```

Run the migration:
```bash
php artisan migrate
```

---

## Step 6: Update User Model (`app/Models/User.php`)

Add `google_id` and `avatar` to the fillable attributes:

```php
#[Fillable(['name', 'email', 'password', 'role', 'position', 'google_id', 'avatar'])]
```

---

## Step 7: Create Socialite Controller

`app/Http/Controllers/Auth/SocialiteController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link existing account
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Create new account
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Str::random(60),
                    'email_verified_at' => now(),
                ]);
            }
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
```

---

## Step 8: Add Routes (`routes/web.php`)

Add at the top of `web.php` before other routes:

```php
use App\Http\Controllers\Auth\SocialiteController;

Route::controller(SocialiteController::class)->prefix('auth')->group(function () {
    Route::get('/google', 'redirect')->name('auth.google');
    Route::get('/google/callback', 'callback')->name('auth.google.callback');
});
```

> Place these **outside** any auth/verified middleware — they must be accessible to guests.

---

## Step 9: Generate TypeScript Routes (Wayfinder)

```bash
php artisan wayfinder:generate
```

This generates typed route helpers in `resources/js/routes/auth/` and `resources/js/routes/auth/google/`.

---

## Step 10: Update Login Page

`resources/js/pages/auth/Login.vue`:

Add the Google button **outside** the `<Form>` component, after the closing `</Form>` tag:

```vue
<div class="relative my-6">
    <div class="absolute inset-0 flex items-center">
        <span class="w-full border-t" />
    </div>
    <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">Or continue with</span>
    </div>
</div>

<a href="/auth/google" class="w-full">
    <Button variant="outline" class="w-full">
        <svg class="mr-2 h-4 w-4" aria-hidden="true" viewBox="0 0 24 24">
            <path
                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"
                fill="#4285F4"
            />
            <path
                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                fill="#34A853"
            />
            <path
                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                fill="#FBBC05"
            />
            <path
                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                fill="#EA4335"
            />
        </svg>
        Sign in with Google
    </Button>
</a>
```

> Use a plain `<a>` tag (not Inertia `<Link>`) because navigation leaves the SPA for Google's consent screen.

---

## Step 11: (Optional) Update Register Page

Repeat the same pattern in `resources/js/pages/auth/Register.vue`, changing button text to "Sign up with Google".

---

## Authentication Flow

```
User clicks "Sign in with Google"
    → GET /auth/google
    → Laravel redirects to Google consent screen
    → User authorizes
    → Google redirects to /auth/google/callback?code=...
    → Socialite exchanges code for access token + user info
    → Controller logic:

    ┌─ google_id exists? ──→ Login
    │
    └─ email exists? ──→ Link account (update google_id, avatar) → Login
        │
        └─ Create new user (auto-verify email, random password) → Login

    → session()->regenerate()
    → Redirect to dashboard
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| `419 PAGE EXPIRED` when returning from Google | Regenerate session in callback (already handled) |
| `Invalid credentials` error | Verify `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` in `.env` |
| Redirect URI mismatch | Check the exact URI in Google Cloud Console matches `GOOGLE_REDIRECT` |
| User already exists with email | The controller auto-links the account — no duplicate errors |
| `Socialite` class not found | Run `composer dump-autoload` |
