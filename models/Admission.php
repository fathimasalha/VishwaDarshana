<?php
class Admission {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    public function create($data) {
        try {
            $sql = "INSERT INTO vd_student_admissions (
                sa_form_number, sa_name, sa_address, sa_city, sa_state,
                sa_pincode, sa_phone, sa_dob, sa_aadhar_number, sa_category,
                sa_mother_name, sa_father_name, sa_course, sa_subject_combination,
                sa_first_language, sa_second_language, sa_marks_obtained,
                sa_percentage, sa_facilities, sa_other_activities,
                sa_payment_mobile, sa_transaction_number, sa_receipt_path,
                sa_terms_accepted, sa_ip_address, sa_browser_info
            ) VALUES (
                :form_number, :name, :address, :city, :state,
                :pincode, :phone, :dob, :aadhar, :category,
                :mother_name, :father_name, :course, :subjects,
                :first_lang, :second_lang, :marks, :percentage,
                :facilities, :activities, :payment_mobile,
                :transaction, :receipt, :terms, :ip, :browser
            )";
            
            $stmt = $this->db->prepare($sql);
            
            // Format Aadhar for storage
            $data['sa_aadhar_number'] = str_replace(' ', '', $data['sa_aadhar_number']);
            
            $params = [
                ':form_number' => $data['sa_form_number'],
                ':name' => $data['sa_name'],
                ':address' => $data['sa_address'],
                ':city' => $data['sa_city'] ?? null,
                ':state' => $data['sa_state'] ?? null,
                ':pincode' => $data['sa_pincode'] ?? null,
                ':phone' => $data['sa_phone'],
                ':dob' => $data['sa_dob'],
                ':aadhar' => $data['sa_aadhar_number'],
                ':category' => $data['sa_category'],
                ':mother_name' => $data['sa_mother_name'],
                ':father_name' => $data['sa_father_name'],
                ':course' => $data['sa_course'],
                ':subjects' => $data['sa_subject_combination'],
                ':first_lang' => $data['sa_first_language'],
                ':second_lang' => $data['sa_second_language'],
                ':marks' => $data['sa_marks_obtained'] ?? null,
                ':percentage' => $data['sa_percentage'] ?? null,
                ':facilities' => $data['sa_facilities'] ?? null,
                ':activities' => $data['sa_other_activities'] ?? null,
                ':payment_mobile' => $data['sa_payment_mobile'],
                ':transaction' => $data['sa_transaction_number'],
                ':receipt' => $data['sa_receipt_path'],
                ':terms' => 1,
                ':ip' => $data['sa_ip_address'],
                ':browser' => $data['sa_browser_info']
            ];
            
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log('Admission creation error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getByFormNumber($formNumber) {
        $sql = "SELECT * FROM vd_student_admissions WHERE sa_form_number = :form_number";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':form_number' => $formNumber]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}