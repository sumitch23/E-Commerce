<?php

class Signup extends Dbhandler {
  protected function setUser($username, $pwd, $email, $privilegeLevel=0, $attempt=3) {
    $sql = "INSERT INTO Members (Username, Password, Email, PrivilegeLevel, Attempt, RegisteredDate)
      VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = $this->conn()->prepare($sql);

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $registerDate = date("Y-m-d"); 
    
    
    $stmt->bind_param("sssiis", $username, $hashedPwd, $email, $privilegeLevel, $attempt, $registerDate);
    if (!$stmt->execute()) {
      $stmt->close();
      header("location: ../signup.php?error=stmtfailed");
      exit();
    }

   
    $sql = "SELECT MemberID FROM Members where Username = ?";
    $stmt = $this->conn()->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $memberID = $row["MemberID"];

    
    $sql = "INSERT INTO Orders(MemberID) VALUES (?)";
    $stmt = $this->conn()->prepare($sql);
    $stmt->bind_param("i", $memberID);
    $stmt->execute() or die("<p>*Cart creation error, please try again!</p>");

    $stmt->close();
  }

  protected function checkUser($username, $email) {
    $sql = "SELECT Username FROM Members WHERE Username = ? OR Email = ?";
    $stmt = $this->conn()->prepare($sql);

    if (!$stmt) {
      header("location: ../login.php?error=stmtfailed");
      exit();
    }

    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) return $row;
    else return false;

    $stmt->close();
  }
}
?>
