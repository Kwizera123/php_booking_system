<?php

class Database {
    private string $servername = "localhost";
    private string $dbname = "php_booking_system";
    private string $username = "root";
    private string $password = "";

    private PDO $conn; 

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit("Database Connection failed: " . $e->getMessage());
        }
    }

    public function createUser(string $email, string $hashedPassword): bool {
        $sql = "INSERT INTO users (email, password) VALUES (:e, :hp)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'e' => $email,
            'hp' => $hashedPassword
            ]);
    }

    public function fetchUserByemail(string $email){
        $sql = "SELECT * FROM users WHERE email = :e";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'e' => $email
            ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getBookingByDateTime(string $bookingTime) {
        $sql = "SELECT * FROM bookings WHERE datetime = :bt";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'bt' => $bookingTime
            ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createNewBooking(string $user_id, string $email, string $fullName, string $bookingTime) {
        $sql = 'INSERT INTO bookings (user_id, email, fullname, datetime, status) VALUES (:uid, :e, :fn, :dt, "schedule")';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':uid' => $user_id,
            ':e' => $email,
            ':fn' => $fullName,
            'dt' => $bookingTime
            ]);
    }
}