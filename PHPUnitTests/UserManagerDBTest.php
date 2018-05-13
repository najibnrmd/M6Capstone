<?php
require_once '/public/includes/autoload.php';
include 'public/includes/password.php';
use classes\business\UserManager;
use classes\data\UserManagerDB;
use classes\entity\User;
use classes\util\DBUtil;

/**
 * UserManagerDB test case.
 */
class UserManagerDBTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UserManagerDB
     */
    private $userManagerDB;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UserManagerDBTest::setUp()
        
        $this->userManagerDB = new UserManagerDB(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserManagerDBTest::tearDown()
        $this->userManagerDB = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
     * Tests UserManagerDB::fillUser()
     */
    public function testFillUser()
    {
        // TODO Auto-generated UserManagerDBTest::testFillUser()
        $this->markTestIncomplete("fillUser test not implemented");
        
        UserManagerDB::fillUser(/* parameters */);
    }

    /**
     * Tests UserManagerDB::getUserByEmailPassword()
     */
    public function testGetUserByEmailPassword()
    {
        // TODO Auto-generated UserManagerDBTest::testGetUserByEmailPassword()
        // $this->markTestIncomplete("getUserByEmailPassword test not implemented");
        
        $user = UserManagerDB::getUserByEmailPassword('najib.nrmd@gmail.com', '$2y$10$/ScLYpQEPtiFCQXdXyb4guYhpWOfAC92eHa58VPOI4l57VjH2EczS');

        $this->assertEquals('Najib', $user->firstName);
    }

    /**
     * Tests UserManagerDB::getUserByEmail()
     */
    public function testGetUserByEmail()
    {
        // TODO Auto-generated UserManagerDBTest::testGetUserByEmail()
        // $this->markTestIncomplete("getUserByEmail test not implemented");
        
        $user = UserManagerDB::getUserByEmail('FaryzDani@gmail.com');

        $this->assertEquals('Faryz', $user->firstName);
    }

    /**
     * Tests UserManagerDB::getUserById()
     */
    public function testGetUserById()
    {
        // TODO Auto-generated UserManagerDBTest::testGetUserById()
        // $this->markTestIncomplete("getUserById test not implemented");
        
        $user = UserManagerDB::getUserById(26);

        $this->assertEquals('Jack', $user->firstName);
    }

    /**
     * Tests UserManagerDB::saveUser()
     */
    public function testSaveUser()
    {
        // TODO Auto-generated UserManagerDBTest::testSaveUser()
        // $this->markTestIncomplete("saveUser test not implemented");
        $UM=new UserManager();
        $user=new User();
        $user->firstName='Alan';
        $user->lastName='Walker';
        $user->email='alanwalker999@gmail.com';
        $user->password=password_hash('Alanwalker00', PASSWORD_DEFAULT);
        $user->country='BE';;
        $user->role="user";
        
        UserManagerDB::saveUser($user);

        $existuser = UserManagerDB::getUserByEmail('alanwalker999@gmail.com');

        $this->assertEquals('Alan', $existuser->firstName);
    }

    /**
     * Tests UserManagerDB::updatePassword()
     */
    public function testUpdatePassword()
    {
        // TODO Auto-generated UserManagerDBTest::testUpdatePassword()
        // $this->markTestIncomplete("updatePassword test not implemented");
        $password = '$2y$10$7fo3ssaaIFQhMnCEojPTN.oHGyFVahOK1bfraXiH1yEp5g3vcZIUG';
        
        UserManagerDB::updatePassword('raziv.callaway@gmail.com', $password);

        $user = UserManagerDB::getUserByEmail('raziv.callaway@gmail.com');

        $this->assertEquals($password, $user->password);

    }

    /**
     * Tests UserManagerDB::deleteAccount()
     */
    public function testDeleteAccount()
    {
        // TODO Auto-generated UserManagerDBTest::testDeleteAccount()
        // $this->markTestIncomplete("deleteAccount test not implemented");
        
        UserManagerDB::deleteAccount(7);

        $user = UserManagerDB::getUserById(7);

        if ($user == NULL){
            $user = FALSE;
        } else {
            $user = TRUE;
        }

        $this->assertFalse($user);
    }

    /**
     * Tests UserManagerDB::getAllUsers()
     */
    public function testGetAllUsers()
    {
        // TODO Auto-generated UserManagerDBTest::testGetAllUsers()
        // $this->markTestIncomplete("getAllUsers test not implemented");
        
        $users = UserManagerDB::getAllUsers();

        $this->assertCount(18, $users);
    }

    /**
     * Tests UserManagerDB::searchUserFirstName()
     */
    public function testSearchUserFirstName()
    {
        // TODO Auto-generated UserManagerDBTest::testSearchUserFirstName()
        // $this->markTestIncomplete("searchUserFirstName test not implemented");
        
        $users = UserManagerDB::searchUserFirstName('l');

        $this->assertCount(4, $users);
    }

    /**
     * Tests UserManagerDB::searchUserLastName()
     */
    public function testSearchUserLastName()
    {
        // TODO Auto-generated UserManagerDBTest::testSearchUserLastName()
        // $this->markTestIncomplete("searchUserLastName test not implemented");
        
        $users = UserManagerDB::searchUserLastName('p');

        $this->assertCount(2, $users);
    }

    /**
     * Tests UserManagerDB::searchUserEmail()
     */
    public function testSearchUserEmail()
    {
        // TODO Auto-generated UserManagerDBTest::testSearchUserEmail()
        //$this->markTestIncomplete("searchUserEmail test not implemented");
        
        $users = UserManagerDB::searchUserEmail('@');

        $this->assertCount(18, $users);
    }

    /**
     * Tests UserManagerDB::getCountries()
     */
    public function testGetCountries()
    {
        // TODO Auto-generated UserManagerDBTest::testGetCountries()
        // $this->markTestIncomplete("getCountries test not implemented");
        
        $countries = UserManagerDB::getCountries();

        if ($countries = 1){
            $countries = TRUE;
        } else {
            $countries = FALSE;
        }

        $this->assertTRUE($countries);
    }

    /**
     * Tests UserManagerDB::getCountry()
     */
    public function testGetCountry()
    {
        // TODO Auto-generated UserManagerDBTest::testGetCountry()
        // $this->markTestIncomplete("getCountry test not implemented");
        
        $country = UserManagerDB::getCountry('BE');


        $this->assertEquals('Belgium', $country);
    }
}

