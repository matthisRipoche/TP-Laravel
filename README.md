## Pint

```bash
./vendor/bin/pint
```

## Delete old locations

```bash
php artisan app:delete-old-locations
```

## Schedule

```bash
php artisan schedule:work
```

## Database

## OAuth avec Google

1. Installer Laravel Socialite
composer require laravel/socialite

2. Creer les credentials Google
- Aller sur console.cloud.google.com
- Creer un projet > API & Services > Credentials > OAuth 2.0 Client ID
- URI de redirection a mettre : http://localhost/auth/google/callback
- Recuperer client_id et client_secret

3. Ajouter les variables dans .env
GOOGLE_CLIENT_ID=xxx
GOOGLE_CLIENT_SECRET=xxx
GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback

4. Configurer config/services.php
- Ajouter le bloc google avec les variables d'env

5. Ajouter une migration
- Ajouter les colonnes google_id (nullable) et rendre password nullable dans la table users

6. Creer le SocialiteController
- Methode redirectToGoogle() : redirige vers Google
- Methode handleGoogleCallback() : recoit le retour, cree ou connecte l'utilisateur

7. Ajouter les routes dans web.php
- GET /auth/google → redirectToGoogle
- GET /auth/google/callback → handleGoogleCallback

8. Ajouter le bouton dans login.blade.php
- Bouton "Se connecter avec Google" qui pointe vers /auth/google