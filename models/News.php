<!-- =====================================================
     NEWS MODEL
     File: models/News.php
     ===================================================== -->
     <?php
class News {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function create($data) {
        $sql = "INSERT INTO vd_news_articles (
                na_title, na_slug, na_category, na_excerpt, na_content,
                na_featured_image, na_author_id, na_status, na_published_at,
                na_seo_title, na_seo_description
            ) VALUES (
                :title, :slug, :category, :excerpt, :content,
                :featured_image, :author_id, :status, :published_at,
                :seo_title, :seo_description
            )";
        
        $stmt = $this->db->prepare($sql);
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':excerpt', $data['excerpt']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':author_id', $_SESSION['admin_id']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':published_at', $data['published_at']);
        $stmt->bindParam(':seo_title', $data['seo_title']);
        $stmt->bindParam(':seo_description', $data['seo_description']);
        
        return $stmt->execute();
    }
    
    public function getAll($status = null) {
        $sql = "SELECT n.*, u.u_full_name as author_name 
                FROM vd_news_articles n
                LEFT JOIN vd_users u ON n.na_author_id = u.u_id";
        
        if ($status) {
            $sql .= " WHERE n.na_status = :status";
        }
        
        $sql .= " ORDER BY n.na_created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT n.*, u.u_full_name as author_name 
                FROM vd_news_articles n
                LEFT JOIN vd_users u ON n.na_author_id = u.u_id
                WHERE n.na_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getBySlug($slug) {
        $sql = "SELECT n.*, u.u_full_name as author_name 
                FROM vd_news_articles n
                LEFT JOIN vd_users u ON n.na_author_id = u.u_id
                WHERE n.na_slug = :slug AND n.na_status = 'published'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        // Increment views
        $article = $stmt->fetch();
        if ($article) {
            $this->incrementViews($article->na_id);
        }
        
        return $article;
    }
    
    public function getLatest($limit = 3) {
        $sql = "SELECT * FROM vd_news_articles 
                WHERE na_status = 'published' 
                AND na_published_at <= NOW()
                ORDER BY na_published_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE vd_news_articles SET 
                na_title = :title,
                na_slug = :slug,
                na_category = :category,
                na_excerpt = :excerpt,
                na_content = :content,
                na_featured_image = :featured_image,
                na_status = :status,
                na_published_at = :published_at,
                na_seo_title = :seo_title,
                na_seo_description = :seo_description
                WHERE na_id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':excerpt', $data['excerpt']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':featured_image', $data['featured_image']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':published_at', $data['published_at']);
        $stmt->bindParam(':seo_title', $data['seo_title']);
        $stmt->bindParam(':seo_description', $data['seo_description']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $sql = "DELETE FROM vd_news_articles WHERE na_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    private function incrementViews($id) {
        $sql = "UPDATE vd_news_articles SET na_views = na_views + 1 WHERE na_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    
    private function generateSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Check if slug exists
        $count = 1;
        $originalSlug = $slug;
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }
    
    private function slugExists($slug) {
        $sql = "SELECT COUNT(*) FROM vd_news_articles WHERE na_slug = :slug";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>