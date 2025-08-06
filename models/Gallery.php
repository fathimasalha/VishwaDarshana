<!-- =====================================================
     GALLERY MODEL
     File: models/Gallery.php
     ===================================================== -->
     <?php
class Gallery {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function createCategory($data) {
        $sql = "INSERT INTO vd_gallery_categories (gc_name, gc_slug, gc_description, gc_sort_order) 
                VALUES (:name, :slug, :description, :sort_order)";
        
        $stmt = $this->db->prepare($sql);
        
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':sort_order', $data['sort_order']);
        
        return $stmt->execute();
    }
    
    public function getCategories() {
        $sql = "SELECT * FROM vd_gallery_categories ORDER BY gc_sort_order, gc_name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getCategoryById($id) {
        $sql = "SELECT * FROM vd_gallery_categories WHERE gc_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function createItem($data) {
        $sql = "INSERT INTO vd_gallery_items (
                gi_category_id, gi_title, gi_description, gi_file_path,
                gi_file_type, gi_thumbnail_path, gi_file_size, gi_dimensions,
                gi_sort_order, gi_is_featured
            ) VALUES (
                :category_id, :title, :description, :file_path,
                :file_type, :thumbnail_path, :file_size, :dimensions,
                :sort_order, :is_featured
            )";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':category_id', $data['gi_category_id']);
        $stmt->bindParam(':title', $data['gi_title']);
        $stmt->bindParam(':description', $data['gi_description']);
        $stmt->bindParam(':file_path', $data['gi_file_path']);
        $stmt->bindParam(':file_type', $data['gi_file_type']);
        $stmt->bindParam(':thumbnail_path', $data['gi_thumbnail_path']);
        $stmt->bindParam(':file_size', $data['gi_file_size']);
        $stmt->bindParam(':dimensions', $data['gi_dimensions']);
        $stmt->bindParam(':sort_order', $data['gi_sort_order']);
        $stmt->bindParam(':is_featured', $data['gi_is_featured']);
        
        return $stmt->execute();
    }
    
    public function getItems($categoryId = null, $limit = null) {
        $sql = "SELECT gi.*, gc.gc_name as category_name 
                FROM vd_gallery_items gi
                LEFT JOIN vd_gallery_categories gc ON gi.gi_category_id = gc.gc_id";
        
        if ($categoryId) {
            $sql .= " WHERE gi.gi_category_id = :category_id";
        }
        
        $sql .= " ORDER BY gi.gi_sort_order, gi.gi_created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId);
        }
        
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getFeatured($limit = 6) {
        $sql = "SELECT gi.*, gc.gc_name as category_name 
                FROM vd_gallery_items gi
                LEFT JOIN vd_gallery_categories gc ON gi.gi_category_id = gc.gc_id
                WHERE gi.gi_is_featured = 1
                ORDER BY gi.gi_sort_order, gi.gi_created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getByCategory($categorySlug, $limit = null) {
        $sql = "SELECT gi.*, gc.gc_name as category_name 
                FROM vd_gallery_items gi
                INNER JOIN vd_gallery_categories gc ON gi.gi_category_id = gc.gc_id
                WHERE gc.gc_slug = :slug
                ORDER BY gi.gi_sort_order, gi.gi_created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $categorySlug);
        
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function deleteItem($id) {
        // Get file path first
        $sql = "SELECT gi_file_path, gi_thumbnail_path FROM vd_gallery_items WHERE gi_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $item = $stmt->fetch();
        
        if ($item) {
            // Delete files
            if ($item->gi_file_path && file_exists(UPLOAD_PATH . $item->gi_file_path)) {
                unlink(UPLOAD_PATH . $item->gi_file_path);
            }
            if ($item->gi_thumbnail_path && file_exists(UPLOAD_PATH . $item->gi_thumbnail_path)) {
                unlink(UPLOAD_PATH . $item->gi_thumbnail_path);
            }
            
            // Delete from database
            $sql = "DELETE FROM vd_gallery_items WHERE gi_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
        
        return false;
    }
    
    private function generateSlug($text) {
        $slug = strtolower(trim($text));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
?>