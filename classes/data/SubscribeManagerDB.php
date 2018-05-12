<?php
namespace classes\data;

use classes\entity\User;
use classes\util\DBUtil;

class SubscribeManagerDB
{
    public static function fillUser($row){
        $user=new User();
        $user->id=$row["id"];
        $user->email=$row["email"];
        $user->hashkey=$row["hashkey"];
        return $user;
    }

    public static function getUserByEmail($email){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $sql="select * from tb_subscription where Email='$email'";
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
        $sql="select * from tb_subscription where id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }

    public static function subscribe($id, $email, $hashkey){
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $email=mysqli_real_escape_string($conn,$email);
        $sql="INSERT INTO tb_subscription (id, email, hashkey) VALUES ('$id', '$email', '$hashkey')";
        $conn->query($sql);
        $conn->close();
    }
	
    public static function unsubscribe($id, $hashkey){
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $sql="DELETE FROM tb_subscription WHERE id='$id' AND hashkey='$hashkey'";
        $conn->query($sql);
        $conn->close();

    }		
    public static function getAllUsers(){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_subscription";
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
}

?>