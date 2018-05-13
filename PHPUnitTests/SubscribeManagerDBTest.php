<?php
require_once '/public/includes/autoload.php';
use classes\business\SubscribeManager;
use classes\data\SubscribeManagerDB;
use classes\entity\User;
use classes\util\DBUtil;

/**
 * SubscribeManagerDB test case.
 */
class SubscribeManagerDBTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var SubscribeManagerDB
     */
    private $subscribeManagerDB;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SubscribeManagerDBTest::setUp()
        
        $this->subscribeManagerDB = new SubscribeManagerDB(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SubscribeManagerDBTest::tearDown()
        $this->subscribeManagerDB = null;
        
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
     * Tests SubscribeManagerDB::fillUser()
     */
    public function testFillUser()
    {
        // TODO Auto-generated SubscribeManagerDBTest::testFillUser()
        $this->markTestIncomplete("fillUser test not implemented");
        
        SubscribeManagerDB::fillUser();
    }

    /**
     * Tests SubscribeManagerDB::getUserByEmail()
     */
    public function testGetUserByEmail()
    {
        // TODO Auto-generated SubscribeManagerDBTest::testGetUserByEmail()
        // $this->markTestIncomplete("getUserByEmail test not implemented");
        
        $user = SubscribeManagerDB::getUserByEmail('najib.nrmd@gmail.com');

        $this->assertEquals(6, $user->id);
    }

    /**
     * Tests SubscribeManagerDB::getUserById()
     */
    public function testGetUserById()
    {
        // TODO Auto-generated SubscribeManagerDBTest::testGetUserById()
        // $this->markTestIncomplete("getUserById test not implemented");
        
        $user = SubscribeManagerDB::getUserById(10);

        $this->assertEquals('StevieG@gmail.com', $user->email);
    }

    /**
     * Tests SubscribeManagerDB::subscribe()
     */
    public function testSubscribe()
    {
        // TODO Auto-generated SubscribeManagerDBTest::testSubscribe()
        // $this->markTestIncomplete("subscribe test not implemented");
        
        SubscribeManagerDB::subscribe(24, 'FaryzDani@gmail.com', '1ff1de774005f8da13f42943881c655f');

        $user = SubscribeManagerDB::getUserByEmail('Faryzdani@gmail.com');

        if ($user == NULL){
            $user = FALSE;
        } else {
            $user = TRUE;
        }

        $this->assertTrue($user);
    }

    /**
     * Tests SubscribeManagerDB::unsubscribe()
     */
    public function testUnsubscribe()
    {
        // TODO Auto-generated SubscribeManagerDBTest::testUnsubscribe()
        // $this->markTestIncomplete("unsubscribe test not implemented");
        
        SubscribeManagerDB::unsubscribe(12, 'c20ad4d76fe97759aa27a0c99bff6710');

        $user = SubscribeManagerDB::getUserById(12);

        if ($user == NULL){
            $user = FALSE;
        } else {
            $user = TRUE;
        }

        $this->assertFalse($user);
    }

    /**
     * Tests SubscribeManagerDB::getAllUsers()
     */
    public function testGetAllUsers()
    {
        // TODO Auto-generated SubscribeManagerDBTest::testGetAllUsers()
        // $this->markTestIncomplete("getAllUsers test not implemented");
        
        $users = SubscribeManagerDB::getAllUsers();

        $this->assertCount(7, $users);
    }
}

