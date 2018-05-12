<?php
namespace classes\business;

use classes\entity\User;
use classes\data\SubscribeManagerDB;

class SubscribeManager
{
    public static function getAllUsers(){
        return SubscribeManagerDB::getAllUsers();
    }

    public function getUserByEmail($email){
        return SubscribeManagerDB::getUserByEmail($email);
    }

    public function getUserById($id){
        return SubscribeManagerDB::getUserById($id);
    }

    // INSERT RECORD INTO TB_SUBSCRIPTION (subscribe.php, updateuserprofile.php and edituser.php)
    public function subscribe($id, $email){
        $hashkey = md5($id);
        SubscribeManagerDB::subscribe($id, $email, $hashkey);
    }
	
	// DELETE RECORD FROM TB_SUBSCRIPTION - (used in updateuserprofile.php and edituser.php)
	public function unsubscribe($id, $hashkey){
        SubscribeManagerDB::unsubscribe($id, $hashkey);
    }

	// DELETE RECORD FROM TB_SUBSCRIPTION - (used in unsubscribe.php)
	/*public function unsubscribeLink($id, $hashkey){
        SubscribeManagerDB::unsubscribe($id, $hashkey);
    }*/
}

?>