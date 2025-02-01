<?php
class EventRegistration
{
    private $db;
    private $table_name = "registrations";

    public $indexColumnKeys = [
        'name' => 'Attendee Name',
        'email' => 'Email',
        'mobile' => 'Mobile',
        'registrationdate' => 'Registration Date',
        'address' => 'Address',
    ];

    public function __construct($db)
    {
        $this->db = $db;
    }

    
    public function index()
    {
        try {

            $query = "SELECT ER.* FROM " . $this->table_name ." AS ER JOIN EVENTS E ON ER.event_id = E.id";
            $stmt = $this->db->prepare($query);

            $stmt->execute();
            $eventRegistrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'message' => 'EventRegistrations fetched successfully',
                'status' => true,
                'eventRegistrations' => $eventRegistrations
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

            $emailExists = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE email = :email AND event_id = :event_id";
            $statement = $this->db->prepare($emailExists);
            $statement->bindParam(':email', $data['email']);
            $statement->bindParam(':event_id', $data['event_id']);
            $statement->execute();

            $emailExists = $statement->fetchColumn();

            if ($emailExists > 0) {
                return [
                    'message' => 'You have already registered for this event',
                    'status' => false
                ];
            }

            
            // store the user in the database
            $query = "INSERT INTO " . $this->table_name . " SET event_id=:event_id, name=:name, email=:email,  mobile=:mobile, address=:address, registrationdate=:registrationdate";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':event_id', $data['event_id']);

            foreach($this->indexColumnKeys as $key => $value) {
                if($key == 'registrationdate') {
                    $data[$key] = date('Y-m-d H:i:s');
                }
                $stmt->bindParam(':' . $key, $data[$key]);
            }


            if ($stmt->execute()) {
                return [
                    'message' => 'Event Registration created successfully',
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



    
    // public function getDashboardData($limit, $offset, $sort_by = 'registrationdate', $sort_order = 'ASC', $globalFilter = [])
    // {
    //     try {
            
    //         $query = "SELECT id, name, email, mobile , registrationdate, address
    //                   FROM " . $this->table_name;

    //         $whereClauses = [];
                                
    //         if (!empty($globalFilter['key'])) {
    //             $whereClauses[] = "(name LIKE :key OR email LIKE :key OR mobile LIKE :key OR registrationdate LIKE :key OR address LIKE :key)";
    //         }

    //         if (!empty($globalFilter['key'])) {
    //             $query .= " WHERE " . implode(' AND ', $whereClauses);
    //         }

    //         $query .= " ORDER BY $sort_by $sort_order LIMIT :limit OFFSET :offset";

    //         $stmt = $this->db->prepare($query);

    //         $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    //         $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    //         if (!empty($globalFilter['key'])) {
    //             $stmt->bindValue(':key', '%' . $globalFilter['key'] . '%');  
    //         }

    //         $stmt->execute();

    //         $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         return $events;

    //     } catch (PDOException $exception) {
    //         return [
    //             'message' => $exception->getMessage(),
    //             'status' => false
    //         ];
    //     }
    // }

   public function getDashboardData($limit, $offset, $sort_by = 'registrationdate', $sort_order = 'ASC', $globalFilter = [])
{
    try {
        $query = "SELECT r.id, r.name, r.email, r.mobile, r.registrationdate, r.address ,e.name as eventname
                  FROM ". $this->table_name. " AS r 
                  LEFT JOIN events AS e ON r.event_id = e.id";

        $whereClauses = [];

        if (!empty($globalFilter['key'])) {
            $whereClauses[] = "(r.name LIKE :key OR r.email LIKE :key OR r.mobile LIKE :key OR r.address LIKE :key OR e.name like :key)";
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $query .= " ORDER BY $sort_by $sort_order LIMIT :limit OFFSET :offset";


        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

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


    public function getTotalEventRegistrations($globalFilter = [])
    {
        try {

            // $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
          
            $query = "SELECT COUNT(*) as total
                  FROM ". $this->table_name. " AS r 
                  LEFT JOIN events AS e ON r.event_id = e.id";

            $whereClauses = [];

            if (!empty($globalFilter['key'])) {
                $whereClauses[] = "(r.name LIKE :key OR r.email LIKE :key OR r.mobile LIKE :key OR r.address LIKE :key OR e.name like :key)";
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

    public function delete($data)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id',$data['id']);
            if ($stmt->execute()) {
                return [
                    'message' => 'Attendee information deleted successfully',
                    'status' => true
                ];
            }
            return [
                'message' => 'Attendee Information not found',
                'status' => false
            ];
        }catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function singleItem($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function getEventDetails($event_id)
    {
        try {
            $query = "SELECT r.* , e.name as eventname, e.description FROM ". $this->table_name. " AS r 
                  LEFT JOIN events AS e ON r.event_id = e.id". " WHERE e.id = :event_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':event_id', $event_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }
}
