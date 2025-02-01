<?php
include_once 'Sanitize.php';
class User
{
    private $db;
    private $table_name = "users";

    public $indexColumnKeys = [
        'name' => 'Name',
        'email' => 'Email',
        'mobile' => 'Mobile',
    ];

    public function __construct($db)
    {
        $this->db = $db;
    }

    
    public function index()
    {
        try {

            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->db->prepare($query);

            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'message' => 'Users fetched successfully',
                'status' => true,
                'users' => $users
            ];
        } catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function create($data)
    {
        try {

            // Check if the email already exists
            $check_registered_mail = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE email = :email";
            $checkStmt = $this->db->prepare($check_registered_mail);
            $checkStmt->bindParam(':email', $data['email']);
            $checkStmt->execute();

            $emailExists = $checkStmt->fetchColumn();

            if ($emailExists > 0) {
                return [
                    'message' => 'Email address already exists.',
                    'status' => false
                ];
            }

            
            // store the user in the database
            $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email, password=:password, mobile=:mobile";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':mobile', $data['mobile']);

            if ($stmt->execute()) {
                return [
                    'message' => 'User created successfully',
                    'status' => true
                ];
            }
        } catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }


    public function login($data) {
        $query = "SELECT id, password FROM " . $this->table_name . " WHERE email=:email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ($row) {
            if (password_verify($data['password'], $row['password'])) {
                return [
                    'message' => 'User login successfully',
                    'status' => true,
                    'user_id' => $row['id'],
                    'username' => $row['name'],
                    'password' => $row['password']
                ];
            }else{
                return [
                    'message' => 'Password is incorrect',
                    'status' => false,
                ];
            }
        }

        return [
            'message' => 'Your credentials are incorrect',
            'status' => false
        ];
    }

    public function checkIsUserIsAuthorized($data)
    {
    
        $id = $data['user_id'];
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($data['password'], $row['password'])) {
                return [
                    'message' => 'User is authorized',
                    'status' => true,
                    'user_id' => $row['id'],
                    'username' => $row['name']
                ];
            } else {
                return [
                    'message' => 'Password is incorrect',
                    'status' => false,
                ];
            }
        } else {
            return [
                'message' => 'User not found',
                'status' => false,
            ];
        }
    }

    public function getDashboardData($limit, $offset, $sort_by = 'name', $sort_order = 'ASC', $globalFilter = [])
    {
        try {
            $query = "SELECT id, name, email, mobile 
                      FROM " . $this->table_name;
    
            $whereClauses = [];
    
            if (!empty($globalFilter['key'])) {
                $whereClauses[] = "(name LIKE :key OR email LIKE :key OR mobile LIKE :key)";
            }
    
            if (!empty($globalFilter['key'])) {
                $query .= " WHERE " . implode(' AND ', $whereClauses);
            }
    
            $query .= " ORDER BY $sort_by $sort_order LIMIT :limit OFFSET :offset";
    
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
            if (!empty($globalFilter['key'])) {
                $stmt->bindValue(':key', '%' . $globalFilter['key'] . '%'); 
            }
    
            $stmt->execute();
    
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $events;
    
        } catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }
    

    public function getTotalUsers($globalFilter = [])
    {
        try {

            $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
          
            if (!empty($globalFilter['key'])) {
                $whereClauses[] = "(name LIKE :key OR email LIKE :key OR mobile LIKE :key)";
            }

            if (!empty($globalFilter['key'])) {
                $query .= " WHERE " . implode(' AND ', $whereClauses);
            }

            $stmt = $this->db->prepare($query);

            if (!empty($globalFilter['key'])) {
                $stmt->bindValue(':key', '%' . $globalFilter['key'] . '%');  
            }

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];

        } catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }


    public function edit($data)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $data['id']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return [
                    'message' => 'User fetched successfully',
                    'status' => true,
                    'user' => $user
                ];
            }
            return [
                'message' => 'User not found',
                'status' => false
            ];
        }catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function update($data)
    {
        try {
            
            $query = "UPDATE " . $this->table_name . " SET name=:name, email=:email, mobile=:mobile, password=:password WHERE id=:id";
            $stmt = $this->db->prepare($query);

            
            foreach ($this->indexColumnKeys as $key => $value) {
                $stmt->bindParam(':' . $key, $data[$key]);
            }

            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':id', $data['id']);

            if ($stmt->execute()) {
                return [
                    'message' => 'User updated successfully',
                    'status' => true
                ];
            }
            return [
                'message' => 'User not found',
                'status' => false
            ];
        }catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function delete($data)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id',$data['id']);
            if ($stmt->execute()) {
                return [
                    'message' => 'User deleted successfully',
                    'status' => true
                ];
            }
            return [
                'message' => 'User not found',
                'status' => false
            ];
        }catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }



}
