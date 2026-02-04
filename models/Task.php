<?php

class Task
{
    private PDO $db;
    private ?int $id = null;
    private string $title = '';
    private string $description = '';
    private bool $is_completed = false;
    private ?string $created_at = null;
    private ?string $updated_at = null;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function isCompleted(): bool
    {
        return $this->is_completed;
    }
    
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
    
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
    
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    
    public function setCompleted(bool $is_completed): self
    {
        $this->is_completed = $is_completed;
        return $this;
    }
    
    public function findAll(): array
    {
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        
        return $stmt->fetchAll();
    }
    
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    public function create(): bool
    {
        $sql = "INSERT INTO tasks (title, description, is_completed, created_at, updated_at) 
                VALUES (:title, :description, :is_completed, NOW(), NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'title' => $this->title,
            'description' => $this->description,
            'is_completed' => $this->is_completed ? 1 : 0
        ]);
    }
    
    public function update(int $id): bool
    {
        $sql = "UPDATE tasks 
                SET title = :title, 
                    description = :description, 
                    is_completed = :is_completed,
                    updated_at = NOW()
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'id' => $id,
            'title' => $this->title,
            'description' => $this->description,
            'is_completed' => $this->is_completed ? 1 : 0
        ]);
    }
    
    public function toggleStatus(int $id): bool
    {
        $sql = "UPDATE tasks 
                SET is_completed = NOT is_completed,
                    updated_at = NOW()
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
    }
    
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
    }
    
    public function hydrate(array $data): self
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        if (isset($data['title'])) {
            $this->title = $data['title'];
        }
        if (isset($data['description'])) {
            $this->description = $data['description'];
        }
        if (isset($data['is_completed'])) {
            $this->is_completed = (bool) $data['is_completed'];
        }
        if (isset($data['created_at'])) {
            $this->created_at = $data['created_at'];
        }
        if (isset($data['updated_at'])) {
            $this->updated_at = $data['updated_at'];
        }
        
        return $this;
    }
}
