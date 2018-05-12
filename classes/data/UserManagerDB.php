<?php
namespace classes\data;

use classes\entity\User;
use classes\util\DBUtil;

class UserManagerDB
{
    public static function fillUser($row){
        $user=new User();
        $user->id=$row["id"];
        $user->firstName=$row["firstname"];
        $user->lastName=$row["lastname"];
        $user->email=$row["email"];
        $user->password=$row["password"];
        $user->country=$row["country_code"];
        $user->role=$row["role"];
		$user->account_creation_time = $row["account_creation_time"];
        return $user;
    }

    public static function getUserByEmailPassword($email,$password){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $password=mysqli_real_escape_string($conn,$password);
        $sql="select * from tb_user where email='$email' and password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
    public static function getUserByEmail($email){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $sql="select * from tb_user where Email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }

	public static function getUserById($id){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $sql="select * from tb_user where id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }

    public static function saveUser(User $user){
        $conn=DBUtil::getConnection();
        $sql="call procSaveUser(?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $user->id,$user->firstName, $user->lastName, $user->email,$user->password, $user->country, $user->account_creation_time, $user->role); 
        $stmt->execute();
        if($stmt->errno!=0){
            printf("Error: %s.\n",$stmt->error);
        }
        $stmt->close();
        $conn->close();
    }
    public static function updatePassword($email,$password){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET password='$password' WHERE email='$email';";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();

    }	
	
    public static function deleteAccount($id){
        $conn=DBUtil::getConnection();
        $sql="DELETE from tb_user WHERE id='$id';";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record deleted successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();

    }		
    public static function getAllUsers(){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
    
    public static function searchUserFirstName($firstname) {
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="SELECT * FROM tb_user WHERE firstname LIKE '%$firstname%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;   
    }
    
    public static function searchUserLastName($lastname) {
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="SELECT * FROM tb_user WHERE lastname LIKE '%$lastname%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;  
    }
    
    public static function searchUserEmail($email) {
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="SELECT * FROM tb_user WHERE email LIKE '%$email%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;  
    }

    public static function getCountries(){
        $options = "";
        $conn=DBUtil::getConnection();
        $sql="select * from tb_country";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $options = $options."<option value=$row[code]>$row[name]</option>";
            }
        }
        $conn->close();
        return $options;
    }

    public static function getCountry($countrycode){
        $country = "";
        $conn=DBUtil::getConnection();
        $sql="select * from tb_country where code='$countrycode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $country = $country."$row[name]";
                //<input type="text" name="email" value=$row[code] size="50"
            }
        }
        $conn->close();
        return $country;
    }
}

?>