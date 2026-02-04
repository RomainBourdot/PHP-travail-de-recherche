<?php 
$pageTitle = 'Liste des tâches - Todo App';
require_once __DIR__ . '/../layout/header.php'; 
?>

<!-- Message Flash -->
<?php if (isset($message)): ?>
    <div class="alert alert-<?= htmlspecialchars($message['type']) ?>">
        <?= htmlspecialchars($message['text']) ?>
    </div>
<?php endif; ?>

<!-- En-tête de la liste -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>📋 Mes Tâches</h2>
        <a href="?action=create" class="btn btn-primary">+ Nouvelle Tâche</a>
    </div>
    
    <!-- Liste des tâches -->
    <?php if (empty($tasks)): ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <p style="font-size: 48px; margin-bottom: 10px;">📭</p>
            <p>Aucune tâche pour le moment.</p>
            <p>Commencez par <a href="?action=create">créer une nouvelle tâche</a> !</p>
        </div>
    <?php else: ?>
        <div class="task-list">
            <?php foreach ($tasks as $task): ?>
                <div class="task-item" style="
                    display: flex;
                    align-items: center;
                    padding: 15px;
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    margin-bottom: 10px;
                    background-color: <?= $task['is_completed'] ? '#f8fff8' : '#fff' ?>;
                    <?= $task['is_completed'] ? 'opacity: 0.8;' : '' ?>
                ">
                    <!-- Checkbox pour basculer le statut -->
                    <a href="?action=toggle&id=<?= (int) $task['id'] ?>" 
                       style="margin-right: 15px; font-size: 24px; text-decoration: none;"
                       title="<?= $task['is_completed'] ? 'Marquer comme non fait' : 'Marquer comme fait' ?>">
                        <?= $task['is_completed'] ? '✅' : '⬜' ?>
                    </a>
                    
                    <!-- Contenu de la tâche -->
                    <div style="flex: 1;">
                        <h3 style="
                            margin: 0;
                            font-size: 18px;
                            <?= $task['is_completed'] ? 'text-decoration: line-through; color: #888;' : '' ?>
                        ">
                            <?= htmlspecialchars($task['title']) ?>
                        </h3>
                        
                        <?php if (!empty($task['description'])): ?>
                            <p style="
                                margin: 5px 0 0 0;
                                color: #666;
                                font-size: 14px;
                                <?= $task['is_completed'] ? 'text-decoration: line-through;' : '' ?>
                            ">
                                <?= htmlspecialchars($task['description']) ?>
                            </p>
                        <?php endif; ?>
                        
                        <small style="color: #999; font-size: 12px;">
                            Créée le <?= date('d/m/Y à H:i', strtotime($task['created_at'])) ?>
                        </small>
                    </div>
                    
                    <!-- Actions -->
                    <div style="display: flex; gap: 5px;">
                        <a href="?action=edit&id=<?= (int) $task['id'] ?>" 
                           class="btn btn-warning" 
                           title="Modifier">
                            ✏️
                        </a>
                        <a href="?action=delete&id=<?= (int) $task['id'] ?>" 
                           class="btn btn-danger"
                           title="Supprimer"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                            🗑️
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Statistiques -->
        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e0e0e0; color: #666; font-size: 14px;">
            <?php
            $total = count($tasks);
            $completed = count(array_filter($tasks, fn($t) => $t['is_completed']));
            $pending = $total - $completed;
            ?>
            <p>
                📊 <strong><?= $total ?></strong> tâche(s) au total | 
                ✅ <strong><?= $completed ?></strong> terminée(s) | 
                ⏳ <strong><?= $pending ?></strong> en cours
            </p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
