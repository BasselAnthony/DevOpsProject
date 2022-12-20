<?php
//These are the defined authentication environment in the db service

// The MySQL service named in the docker-compose.yml.
$host = 'db';

// Database use name
$user = 'root';

//database user password
$pass = 'root';

// database dbname 
$dbname = 'Devops';

// check the MySQL connection status
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL server successfully!";

    $sql = 'SELECT * FROM messages WHERE message = "Hello World"';
    if ($result = $conn->query($sql)) {
        while ($data = $result->fetch_object()) {
            $messages[] = $data;
        }
    }
    
    foreach ($messages as $message) {
        if($message->message = "Hello World"){
            echo "<br>";
            echo $message->message ;
            echo "<br>";
        }
    }
      return $message->message;
      mysqli_close($conn);
}
?>