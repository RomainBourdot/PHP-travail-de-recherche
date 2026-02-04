-- ============================================
-- Script de création de la base de données
-- Todo App MVC - PHP Pur
-- ============================================

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS todo_app
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Utilisation de la base de données
USE todo_app;

-- ============================================
-- Table des tâches
-- ============================================
CREATE TABLE IF NOT EXISTS tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    is_completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Index pour optimiser les requêtes
    INDEX idx_is_completed (is_completed),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Données de test (optionnel)
-- ============================================
INSERT INTO tasks (title, description, is_completed) VALUES
('Apprendre le PHP', 'Étudier les concepts de base : variables, fonctions, classes...', 1),
('Comprendre le MVC', 'Model-View-Controller : séparation des responsabilités', 1),
('Créer la Todo App', 'Implémenter le CRUD complet avec architecture MVC', 0),
('Sécuriser l''application', 'Utiliser les requêtes préparées et htmlspecialchars()', 0),
('Tester l''application', 'Vérifier toutes les fonctionnalités CRUD', 0);
