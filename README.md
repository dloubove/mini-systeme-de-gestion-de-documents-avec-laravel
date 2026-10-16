🇫🇷 Français | [🇬🇧 English](README.en.md)

# GED : Gestion Électronique de Documents

Solution du **Workshop 6 (Prosit 6) : Framework Laravel**. Application web de gestion de documents réalisée avec **Laravel 12**, **Breeze** (authentification, Blade + Tailwind + Alpine) et **MySQL** (ou SQLite).

## Fonctionnalités

- Inscription, connexion, déconnexion, profil (Laravel Breeze)
- CRUD des **utilisateurs**
- CRUD des **documents** avec upload de fichier (pdf, doc, docx, txt, png, jpg, 2 Mo max)
- Un document **appartient à un utilisateur** : seul son propriétaire peut le modifier ou le supprimer
- **Recherche** de documents par titre
- Routes protégées par le middleware `auth`
- Messages de validation en français, affichés sous chaque champ
- Tableau de bord avec compteurs, tests automatisés

## Prérequis

| Outil | Version | Vérification |
|---|---|---|
| PHP | 8.2 ou plus (extensions `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `xml`, `ctype`, `curl`) | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js + npm | 18 ou plus | `node -v` |
| MySQL | 5.7+ / MariaDB (WAMP, XAMPP, Laragon) | phpMyAdmin accessible |

> SQLite est possible à la place de MySQL (voir plus bas).

## Installation

Ouvrez un terminal **dans le dossier du projet** (celui qui contient le fichier `artisan`).

**1. Installer les dépendances PHP**
```bash
composer install
```

**2. Créer le fichier d'environnement**
```bash
# Windows (cmd)
copy .env.example .env

# Linux / macOS / Git Bash
cp .env.example .env
```

**3. Générer la clé de l'application**
```bash
php artisan key:generate
```

**4. Créer la base de données**

Dans phpMyAdmin, créez une base nommée **`ged`** (interclassement `utf8mb4_unicode_ci`).
Vérifiez ensuite dans `.env` (valeurs par défaut de WAMP/XAMPP) :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ged
DB_USERNAME=root
DB_PASSWORD=
```

**5. Créer les tables et un compte de démonstration**
```bash
php artisan migrate --seed
```

**6. Rendre les fichiers uploadés accessibles**
```bash
php artisan storage:link
```

**7. Installer et compiler le front-end**
```bash
npm install
npm run build
```

**8. Lancer l'application**
```bash
php artisan serve
```
Ouvrez **http://127.0.0.1:8000**.

### Compte de démonstration

| E-mail | Mot de passe |
|---|---|
| `test@example.com` | `password` |

Vous pouvez aussi créer votre propre compte via « Register ».

## Utilisation avec SQLite (sans MySQL)

Dans `.env`, mettez en commentaire les six lignes `DB_*` de MySQL et décommentez `DB_CONNECTION=sqlite`. Puis :
```bash
# Windows (cmd)
type nul > database\database.sqlite
# Linux / macOS / Git Bash
touch database/database.sqlite

php artisan migrate --seed
```
Le reste de l'installation est identique.

## Mode développement (rechargement automatique du CSS/JS)

Dans un second terminal, à la place de `npm run build` :
```bash
npm run dev
```

## Tests automatisés

```bash
php artisan test
```
Les tests utilisent une base SQLite **en mémoire** (extension `pdo_sqlite` requise) : votre base `ged` n'est jamais touchée.

## Correspondance avec le workshop

| Étape | Où se trouve la solution |
|---|---|
| 1-2. Projet et `.env` | `.env.example` |
| 3. Migrations et modèles | `database/migrations/2026_10_16_000000_create_documents_table.php`, `app/Models/Document.php`, `app/Models/User.php` |
| 4. Authentification (Breeze) | `app/Http/Controllers/Auth/`, `routes/auth.php`, `resources/views/auth/` |
| 5. Contrôleurs CRUD | `app/Http/Controllers/UserController.php`, `DocumentController.php` |
| 6 et 9. Routes et middleware `auth` | `routes/web.php` |
| 7. Vues | `resources/views/documents/`, `resources/views/users/` |
| 8. Recherche | `DocumentController::search()`, route `documents.search`, formulaire dans `documents/index.blade.php` |
| 10. Gestion des erreurs | `lang/fr/validation.php`, `@error` / `<x-input-error>` dans les vues |

## Routes principales

| Méthode | URL | Rôle |
|---|---|---|
| GET | `/documents` | Liste des documents |
| GET | `/documents/search?query=...` | Recherche par titre |
| GET / POST | `/documents/create`, `/documents` | Formulaire et enregistrement |
| GET / PUT / DELETE | `/documents/{id}`, `/documents/{id}/edit` | Détail, modification, suppression |
| GET ... | `/users`, `/users/create`, `/users/{id}`, `/users/{id}/edit` | CRUD utilisateurs |

Liste complète : `php artisan route:list`.

## Dépannage

| Message / symptôme | Solution |
|---|---|
| `Vite manifest not found` | Lancez `npm install` puis `npm run build` (ou `npm run dev`). |
| `Unknown database 'ged'` (1049) | Créez la base `ged` dans phpMyAdmin. |
| `Access denied for user` (1045) | Corrigez `DB_USERNAME` et `DB_PASSWORD` dans `.env`. |
| `could not find driver` | Activez `pdo_mysql` (ou `pdo_sqlite`) dans `php.ini`, puis redémarrez Apache/le terminal. |
| `No application encryption key has been specified` | Lancez `php artisan key:generate`. |
| Un fichier uploadé donne une erreur 404 | Lancez `php artisan storage:link` (supprimez d'abord un éventuel dossier `public/storage` existant). |
| L'upload échoue sans message clair | Vérifiez `upload_max_filesize` et `post_max_size` dans `php.ini` (la limite de l'application est 2 Mo). |
| `.env` modifié mais sans effet | Lancez `php artisan config:clear`. |
| Erreur 419 « Page Expired » | Rechargez la page et utilisez toujours la même adresse (`127.0.0.1` ou `localhost`). |
| Le port 8000 est occupé | `php artisan serve --port=8001`. |
| `composer install` refuse à cause de la version de PHP | Passez à PHP 8.2 ou plus (menu WAMP/XAMPP). |

## Licence

Projet pédagogique. Laravel et Breeze sont sous licence MIT.
