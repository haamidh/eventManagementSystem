<?php
class AddEvent
{
    private $event_title;
    private $event_description;
    private $startDate;
    private $endDate;
    private $startTime;
    private $endTime;
    private $venue;
    private $maxParticipant;
    private $ticketPrice;
    private $organizer_id;
    private $file_name;

    function __construct($event_title, $event_description, $startDate, $endDate, $startTime, $endTime, $venue, $maxParticipant, $organizer_id, $ticketPrice, $file_name)
    {
        $this->event_title = htmlspecialchars($event_title);
        $this->event_description = htmlspecialchars($event_description);
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->venue = htmlspecialchars($venue);
        $this->maxParticipant = (int)$maxParticipant;
        $this->organizer_id = (int)$organizer_id; // Corrected this line
        $this->ticketPrice = (float)$ticketPrice;
        $this->file_name = $file_name;
    }

    public function addEvent($con)
    {
        $query = "INSERT INTO event (event_title, event_description, start_date, end_date, start_time, end_time, venue, max_count, organizer_id, ticket_price, status, img_url) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', ?)";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindParam(1, $this->event_title);
            $pstmt->bindParam(2, $this->event_description);
            $pstmt->bindParam(3, $this->startDate);
            $pstmt->bindParam(4, $this->endDate);
            $pstmt->bindParam(5, $this->startTime);
            $pstmt->bindParam(6, $this->endTime);
            $pstmt->bindParam(7, $this->venue);
            $pstmt->bindParam(8, $this->maxParticipant);
            $pstmt->bindParam(9, $this->organizer_id);
            $pstmt->bindParam(10, $this->ticketPrice);
            $pstmt->bindParam(11, $this->file_name);

            return $pstmt->execute();
        } catch (PDOException $exc) {
            error_log("Error occurred when adding event: " . $exc->getMessage());
            return false;
        }
    }

    public function update($con, $uevent_id)
    {
        $query = "UPDATE event SET event_title=?, event_description=?, start_date=?, end_date=?, start_time=?, end_time=?, venue=?, max_count=?, ticket_price=? WHERE event_id=?";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindParam(1, $this->event_title);
            $pstmt->bindParam(2, $this->event_description);
            $pstmt->bindParam(3, $this->startDate);
            $pstmt->bindParam(4, $this->endDate);
            $pstmt->bindParam(5, $this->startTime);
            $pstmt->bindParam(6, $this->endTime);
            $pstmt->bindParam(7, $this->venue);
            $pstmt->bindParam(8, $this->maxParticipant);
            $pstmt->bindParam(9, $this->ticketPrice);
            $pstmt->bindParam(10, $uevent_id);

            return $pstmt->execute();
        } catch (PDOException $exc) {
            error_log("Error occurred when updating event: " . $exc->getMessage());
            return false;
        }
    }
}
