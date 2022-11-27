<?php

class Connection
{
    private $servername = "167.114.115.118";
    private $database = "auditoria";
    private $username = "aladino";
    private $password = "a12345";
    // Create connection
    private static $conn;

    // Check connection
    public function getConnection()
    {
        if (is_null(self::$conn) || !self::$conn->ping()) {
            self::$conn =  mysqli_connect(
                $this->servername,
                $this->username,
                $this->password,
                $this->database
            );
            if (!self::$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            self::$conn->set_charset("utf8");
        }
        return self::$conn;
    }

    public function closeConnection()
    {
        if (self::$conn->ping()):
            self::$conn->close();
        endif; 
    }
}
