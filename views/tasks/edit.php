<?php 
$pageTitle = 'Modifier la tâche - Todo App';
require_once __DIR__ . '/../layout/header.php'; 
?>

<div class="card">
    <h2 style="margin-bottom: 20px;">✏️ Modifier la Tâche</h2>
    
    <form action="?action=update" method="POST">
        <!-- ID caché -->
        <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
        
        <!-- Titre -->
        <div class="form-group">
            <label for="title">Titre <span style="color: red;">*</span></label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($old['title'] ?? $task['title']) ?>"
                placeholder="Ex: Faire les courses"
                maxlength="255"
                required
            >
            <?php if (isset($errors['title'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['title']) ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                placeholder="Détails de la tâche (optionnel)"
                maxlength="1000"
            ><?= htmlspecialchars($old['description'] ?? $task['description']) ?></textarea>
            <?php if (isset($errors['description'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['description']) ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Statut -->
        <div class="form-group">
            <div class="checkbox-group">
                <input 
                    type="checkbox" 
                    id="is_completed" 
                    name="is_completed"
                    <?= ($task['is_completed'] ?? false) ? 'checked' : '' ?>
                >
                <label for="is_completed" style="margin-bottom: 0; cursor: pointer;">
                    Tâche terminée
                </label>
            </div>
        </div>
        
        <!-- Boutons -->
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            <a href="?action=index" class="btn btn-secondary">← Retour</a>
        </div>
    </form>
</div>

<!-- Informations -->
<div class="card" style="background-color: #f8f9fa;">
    <h4 style="margin-bottom: 10px; color: #666;">ℹ️ Informations</h4>
    <p style="color: #888; font-size: 14px; margin: 0;">
        <strong>Créée le :</strong> <?= date('d/m/Y à H:i', strtotime($task['created_at'])) ?><br>
        <strong>Dernière modification :</strong> <?= date('d/m/Y à H:i', strtotime($task['updated_at'])) ?>
    </p>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
