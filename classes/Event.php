<?php

class Event
{
    private $db;
    private $table_name = "events";

    public $indexColumnKeys = [
        'name' => 'Name',
        'description' => 'Description',
        'startdate' => 'Start Date',
        'enddate' => 'End Date',
        'location' => 'Location',
        'status' => 'Status',
    ];

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " SET name=:name, description=:description, startdate=:startdate, enddate=:enddate, location=:location, status=:status";
            $stmt = $this->db->prepare($query);

            foreach ($this->indexColumnKeys as $key => $value) {
                $stmt->bindParam(':' . $key, $data[$key]);
            }

            if ($stmt->execute()) {
                return [
                    'message' => 'Event created successfully',
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

    public function index()
    {
        try {

            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->db->prepare($query);

            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'message' => 'Events fetched successfully',
                'status' => true,
                'events' => $events
            ];
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
                    'message' => 'Event deleted successfully',
                    'status' => true
                ];
            }
            return [
                'message' => 'Event not found',
                'status' => false
            ];
        }catch (PDOException $exception) {
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
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($event) {
                return [
                    'message' => 'Event fetched successfully',
                    'status' => true,
                    'event' => $event
                ];
            }
            return [
                'message' => 'Event not found',
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
            $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, startdate=:startdate, enddate=:enddate, location=:location, status=:status WHERE id=:id";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':id', $data['id']);

            foreach ($this->indexColumnKeys as $key => $value) {
                $stmt->bindParam(':' . $key, $data[$key]);
            }

            if ($stmt->execute()) {
                return [
                    'message' => 'Event updated successfully',
                    'status' => true
                ];
            }
            return [
                'message' => 'Event not found',
                'status' => false
            ];
        }catch (PDOException $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function getDashboardData($limit, $offset, $sort_by = 'startdate', $sort_order = 'ASC', $globalFilter = [])
    {
        try {
            $query = "SELECT id, name, description, startdate, enddate, location, status 
                      FROM " . $this->table_name;

            $whereClauses = [];
                
            if (!empty($globalFilter['key'])) {
                $whereClauses[] = "(name LIKE :key OR description LIKE :key OR startdate LIKE :key OR enddate LIKE :key OR location LIKE :key OR status LIKE :key)";
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

    public function getTotalEvents($globalFilter = [])
    {
        try {

            $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
          
            if (!empty($globalFilter['key'])) {
                $whereClauses[] = "(name LIKE :key OR description LIKE :key OR startdate LIKE :key OR enddate LIKE :key OR location LIKE :key OR status LIKE :key)";
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


}
