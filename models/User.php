<!-- =====================================================
     USER MODEL
     File: models/User.php
     ===================================================== -->
     <?php
class User {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function authenticate($username, $password) {
        $sql = "SELECT * FROM vd_users WHERE u_username = :username AND u_status = 'active'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user->u_password)) {
            // Update last login
            $this->updateLastLogin($user->u_id);
            return $user;
        }
        
        return false;
    }
    
    private function updateLastLogin($userId) {
        $sql = "UPDATE vd_users SET u_last_login = NOW() WHERE u_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }
    
    public function create($data) {
        $sql = "INSERT INTO vd_users (u_username, u_email, u_password, u_full_name, u_role) 
                VALUES (:username, :email, :password, :full_name, :role)";
        
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':role', $data['role']);
        
        return $stmt->execute();
    }
    
    public function getAll() {
        $sql = "SELECT * FROM vd_users ORDER BY u_created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM vd_users WHERE u_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE vd_users SET 
                u_username = :username,
                u_email = :email,
                u_full_name = :full_name,
                u_role = :role,
                u_status = :status
                WHERE u_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE vd_users SET u_password = :password WHERE u_id = :id";
        $stmt = $this->db->prepare($sql);
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $sql = "DELETE FROM vd_users WHERE u_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>