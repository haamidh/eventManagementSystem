<?php
include '../DbConnector/DbConnector.php';

class HomePageDbh extends DbConnector
{
    public function getEvents($search)
    {
        $sql = "SELECT * FROM event";
        $params = array();

        if (!empty($search)) {
            $sql .= " WHERE event_title LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        $data = array();
        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }

        return $data;
    }


    public function saveEventInDb($event_id)
    {
        $params = array();
        $params[':user_id'] = $_SESSION['userId'];
        $params[':event_id'] = $event_id;
        $sql = "INSERT INTO user_save_events (user_id, event_id) VALUES (:user_id, :event_id);";

        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }
    }
    public function savePurchesEventInDb($event_id)
    {
        $params = array();
        $params[':user_id'] = $_SESSION['userId'];
        $params[':event_id'] = $event_id;
        $sql = "INSERT INTO user_purchase_event (purchase_id ,user_id, event_id) VALUES (null,:user_id, :event_id);";

        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }
    }
    public function removeEventFromDb($event_id)
    {
        $params = array();
        $params[':user_id'] = $_SESSION['userId'];
        $params[':event_id'] = $event_id;
        $sql = "DELETE FROM user_save_events WHERE user_id = :user_id AND event_id = :event_id;";

        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }
    }

    public function getSavedEvents()
    {
        $params = array();
        $params[':user_id'] = $_SESSION['userId'];
        $sql = "SELECT * FROM event where event_id IN 
        (SELECT event_id from user_save_events WHERE user_id=:user_id);";

        $data = array();
        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }

        return $data;
    }
    public function getEventDetails($event_id)
    {
        $params = array();
        $sql = "SELECT * FROM event where event_id = ?";

        $data = array();
        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $event_id);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }

        return $data;
    }
    public function getEventDetail($event_id)
    {
        $params = array();
        $sql = "SELECT * FROM event where event_id = ?";

        $data = array();
        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $event_id);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }

        return $data;
    }
    public function getMyEvents()
    {
        $params = array();
        $params[':user_id'] = $_SESSION['userId'];
        $sql = "SELECT * FROM event where event_id IN 
        (SELECT event_id from event WHERE organizer_id=:user_id);";

        $data = array();
        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }

        return $data;
    }
    public function getMyPaidEvents()
    {
        $params = array();
        $params[':user_id'] = $_SESSION['userId'];
        $sql = "SELECT * FROM event where event_id IN 
        (SELECT event_id from user_purchase_event WHERE user_id=:user_id);";

        $data = array();
        try {
            $conn = $this->connect();
            if ($conn) {
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
        } finally {
            $conn = null;
        }

        return $data;
    }
}
