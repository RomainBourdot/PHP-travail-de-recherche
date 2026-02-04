<?php 
$pageTitle = 'Nouvelle tâche - Todo App';
require_once __DIR__ . '/../layout/header.php'; 
?>

<div class="card">
    <h2 style="margin-bottom: 20px;">➕ Nouvelle Tâche</h2>
    
    <form action="?action=store" method="POST">
        <!-- Titre -->
        <div class="form-group">
            <label for="title">Titre <span style="color: red;">*</span></label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($old['title'] ?? '') ?>"
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
            ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            <?php if (isset($errors['description'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['description']) ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Boutons -->
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            <a href="?action=index" class="btn btn-secondary">← Retour</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
