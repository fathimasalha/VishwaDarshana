<!-- =====================================================
     CONTACT MODEL
     File: models/Contact.php
     ===================================================== -->
     <?php
class Contact {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function create($data) {
        $sql = "INSERT INTO vd_contact_messages (
                cm_name, cm_email, cm_phone, cm_subject, cm_message,
                cm_course_interest, cm_source, cm_ip_address
            ) VALUES (
                :name, :email, :phone, :subject, :message,
                :course_interest, :source, :ip_address
            )";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':subject', $data['subject']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':course_interest', $data['course_interest']);
        $stmt->bindParam(':source', $data['source']);
        
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $stmt->bindParam(':ip_address', $ipAddress);
        
        return $stmt->execute();
    }
    
    public function getAll($isRead = null) {
        $sql = "SELECT * FROM vd_contact_messages";
        
        if ($isRead !== null) {
            $sql .= " WHERE cm_is_read = :is_read";
        }
        
        $sql .= " ORDER BY cm_created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if ($isRead !== null) {
            $stmt->bindParam(':is_read', $isRead);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM vd_contact_messages WHERE cm_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Mark as read
        $message = $stmt->fetch();
        if ($message && !$message->cm_is_read) {
            $this->markAsRead($id);
        }
        
        return $message;
    }
    
    public function markAsRead($id) {
        $sql = "UPDATE vd_contact_messages SET cm_is_read = 1 WHERE cm_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function markAsReplied($id, $userId) {
        $sql = "UPDATE vd_contact_messages 
                SET cm_is_replied = 1, cm_replied_at = NOW(), cm_replied_by = :user_id 
                WHERE cm_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function addNote($id, $note) {
        $sql = "UPDATE vd_contact_messages SET cm_notes = :notes WHERE cm_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':notes', $note);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $sql = "DELETE FROM vd_contact_messages WHERE cm_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function getUnreadCount() {
        $sql = "SELECT COUNT(*) FROM vd_contact_messages WHERE cm_is_read = 0";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }
}
?>