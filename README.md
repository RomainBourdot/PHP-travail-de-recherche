# 📝 Todo App MVC - PHP Pur

Application de gestion de tâches (Todo List) développée en PHP pur avec une architecture MVC stricte.

## 📁 Structure du Projet

```
PHP-travail-de-recherche/
├── index.php                 # Front Controller (point d'entrée unique)
├── .htaccess                 # Configuration Apache (réécriture d'URL)
├── README.md                 # Documentation
│
├── config/
│   └── Database.php          # Connexion PDO (Pattern Singleton)
│
├── controllers/
│   └── TaskController.php    # Logique métier des tâches
│
├── models/
│   └── Task.php              # Opérations SQL (CRUD)
│
├── views/
│   ├── layout/
│   │   ├── header.php        # En-tête HTML + CSS
│   │   └── footer.php        # Pied de page HTML
│   └── tasks/
│       ├── index.php         # Liste des tâches
│       ├── create.php        # Formulaire de création
│       └── edit.php          # Formulaire de modification
│
└── database/
    └── schema.sql            # Script SQL de création
```

## 🏗️ Architecture MVC

### Model (Modèle)
- **Responsabilité** : Gère les données et les interactions avec la base de données
- **Fichier** : `models/Task.php`
- **Contient** : Requêtes SQL préparées (SELECT, INSERT, UPDATE, DELETE)

### View (Vue)
- **Responsabilité** : Affichage des données à l'utilisateur
- **Dossier** : `views/`
- **Contient** : Uniquement du HTML/PHP pour l'affichage (pas de logique métier)

### Controller (Contrôleur)
- **Responsabilité** : Traite les requêtes, coordonne Model et View
- **Fichier** : `controllers/TaskController.php`
- **Contient** : Logique métier, validation, redirections

## 🔧 Patterns et Concepts Utilisés

### Pattern Singleton (Database.php)
```php
// Une seule instance de connexion PDO dans toute l'application
$db = Database::getInstance()->getConnection();
```

### Front Controller (index.php)
- Point d'entrée unique de l'application
- Routage des requêtes vers les actions du contrôleur

### Requêtes Préparées (Sécurité SQL)
```php
$stmt = $this->db->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);
```

### Protection XSS
```php
<?= htmlspecialchars($task['title']) ?>
```

## 🚀 Installation

### 1. Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Apache avec mod_rewrite activé

### 2. Base de données
```bash
# Importer le schéma SQL
mysql -u root -p < database/schema.sql
```

### 3. Configuration
Modifier les paramètres de connexion dans `config/Database.php` :
```php
private const DB_HOST = 'localhost';
private const DB_NAME = 'todo_app';
private const DB_USER = 'root';
private const DB_PASS = '';
```

### 4. Lancement
- Placer le projet dans le dossier `htdocs` (XAMPP) ou `www` (WAMP)
- Accéder à : `http://localhost/PHP-travail-de-recherche/`

## 📋 Fonctionnalités CRUD

| Action | URL | Méthode | Description |
|--------|-----|---------|-------------|
| Lister | `?action=index` | GET | Affiche toutes les tâches |
| Créer (form) | `?action=create` | GET | Affiche le formulaire |
| Créer (save) | `?action=store` | POST | Enregistre la tâche |
| Modifier (form) | `?action=edit&id=X` | GET | Affiche le formulaire |
| Modifier (save) | `?action=update` | POST | Met à jour la tâche |
| Basculer statut | `?action=toggle&id=X` | GET | Change fait/non fait |
| Supprimer | `?action=delete&id=X` | GET | Supprime la tâche |

## 🔒 Sécurité

1. **Injection SQL** : Requêtes préparées avec PDO
2. **XSS** : `htmlspecialchars()` sur tous les affichages
3. **CSRF** : Sessions PHP pour les messages flash
4. **Headers** : Protection via `.htaccess`

## 📚 Concepts Clés pour l'Examen

### Singleton
> Pattern qui garantit qu'une classe n'a qu'une seule instance et fournit un point d'accès global.

### MVC
> Architecture séparant les données (Model), l'affichage (View) et la logique (Controller).

### Front Controller
> Point d'entrée unique qui centralise le traitement des requêtes HTTP.

### PDO
> PHP Data Objects : interface d'accès aux bases de données avec support des requêtes préparées.

---

**Auteur** : Projet PHP YNOV  
**Date** : 2025-2026
