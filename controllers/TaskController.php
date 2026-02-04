<?php
/**
 * Controller Task - Gère la logique métier des tâches
 */
class TaskController
{
    private Task $taskModel;
    
    public function __construct()
    {
        $this->taskModel = new Task();
    }
    
    /**
     * Affiche la liste des tâches
     */
    public function index(): void
    {
        // Récupération des tâches via le Model
        $tasks = $this->taskModel->findAll();
        
        // Message flash
        $message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        
        // Chargement de la vue
        require_once __DIR__ . '/../views/tasks/index.php';
    }
    
    /**
     * Affiche le formulaire de création
     */
    public function create(): void
    {
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);
        
        require_once __DIR__ . '/../views/tasks/create.php';
    }
    
    /**
     * Enregistre une nouvelle tâche
     */
    public function store(): void
    {
        // Vérification de la méthode HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }
        
        // Récupération et nettoyage des données
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($title)) {
            $errors['title'] = 'Le titre est obligatoire.';
        } elseif (strlen($title) > 255) {
            $errors['title'] = 'Le titre ne doit pas dépasser 255 caractères.';
        }
        
        if (strlen($description) > 1000) {
            $errors['description'] = 'La description ne doit pas dépasser 1000 caractères.';
        }
        
        // S'il y a des erreurs, retour au formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['title' => $title, 'description' => $description];
            $this->redirect('?action=create');
            return;
        }
        
        // Création de la tâche via le Model
        $this->taskModel
            ->setTitle($title)
            ->setDescription($description)
            ->setCompleted(false);
        
        if ($this->taskModel->create()) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Tâche créée avec succès !'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la création de la tâche.'
            ];
        }
        
        $this->redirect('?action=index');
    }
    
    /**
     * Affiche le formulaire de modification
     */
    public function edit(?int $id): void
    {
        if (!$id) {
            $this->redirect('?action=index');
            return;
        }
        
        $task = $this->taskModel->findById($id);
        
        if (!$task) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Tâche non trouvée.'
            ];
            $this->redirect('?action=index');
            return;
        }
        
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);
        
        require_once __DIR__ . '/../views/tasks/edit.php';
    }
    
    /**
     * Met à jour une tâche existante
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?action=index');
            return;
        }
        
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isCompleted = isset($_POST['is_completed']);
        
        // Validation
        $errors = [];
        
        if (empty($title)) {
            $errors['title'] = 'Le titre est obligatoire.';
        } elseif (strlen($title) > 255) {
            $errors['title'] = 'Le titre ne doit pas dépasser 255 caractères.';
        }
        
        if (strlen($description) > 1000) {
            $errors['description'] = 'La description ne doit pas dépasser 1000 caractères.';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['title' => $title, 'description' => $description];
            $this->redirect("?action=edit&id={$id}");
            return;
        }
        
        // Mise à jour via le Model
        $this->taskModel
            ->setTitle($title)
            ->setDescription($description)
            ->setCompleted($isCompleted);
        
        if ($this->taskModel->update($id)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Tâche modifiée avec succès !'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la modification de la tâche.'
            ];
        }
        
        $this->redirect('?action=index');
    }
    
    /**
     * Bascule le statut d'une tâche
     */
    public function toggle(?int $id): void
    {
        if (!$id) {
            $this->redirect('?action=index');
            return;
        }
        
        if ($this->taskModel->toggleStatus($id)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Statut de la tâche modifié !'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la modification du statut.'
            ];
        }
        
        $this->redirect('?action=index');
    }
    
    /**
     * Supprime une tâche
     */
    public function delete(?int $id): void
    {
        if (!$id) {
            $this->redirect('?action=index');
            return;
        }
        
        if ($this->taskModel->delete($id)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Tâche supprimée avec succès !'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression de la tâche.'
            ];
        }
        
        $this->redirect('?action=index');
    }
    
    /**
     * Redirige vers une URL
     */
    private function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
