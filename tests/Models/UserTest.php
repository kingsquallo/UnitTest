<?php
namespace Tests\Models;
use PHPUnit\Framework\TestCase;
use App\Models\User;
class UserTest extends TestCase
{
    public function testSetPasswordReturnsTrueWhenPasswordCompletedSet()
    {
        $details = array();

        $user = new User($details);

        $password = 'thanhtv';

        $result = $user->setPassword($password);

        $this->assertTrue($result);
    }

    public function testGetReturnsUserWithExpectedValues()
    {
        $details = array();

        $user = new User($details);

        $password = 'thanhtv';

        $user->setPassword($password);

        $expectedPasswordResult  = '5f133db68b1f13b29ee85337829de400bf4918bf';

        $currentUser = $user->get();

        $this->assertEquals($expectedPasswordResult, $currentUser['password']);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testSetPasswordReturnsFalseWhenPasswordLengthIsTooShort()
    {
        $details = array();

        $user = new User($details);

        $password = 'thanh';

        $result = $user->setPassword($password);

        $this->assertFalse($result);
    }

    public function testPrivateCryptFunction()
    {
        $user =  new User([]);
        $password = $this->invokeMethod($user, 'crypt',['password' => 'thanhtv']);
        $this->assertEquals($password , '5f133db68b1f13b29ee85337829de400bf4918bf');
    }

    public function testSetEmailReturnsFalseWhenEmailLengthIsTooLong()
    {
        $details = array();

        $user = new User($details);

        $password = 'thanh5f133db68b1f13b29ee85337829de400bf4918bf5f133db68b1f13b29ee85337829de400bf4918bf5f133db68b1f13b29ee85337829de400bf4918bf5f133db68b1f13b29ee85337829de400bf4918bf5f133db68b1f13b29ee85337829de400bf4918bf5f133db68b1f13b29ee85337829de400bf4918bf@gmail.com';

        $result = $user->setEmail($password);

        $this->assertFalse($result);
    }

    public function testSetEmailReturnsTrueWhenEmailCompletedSet()
    {
        $details = array();

        $user = new User($details);

        $email = 'thanhtv@gmail.com';

        $result = $user->setEmail($email);

        $this->assertTrue($result);
    }

    /**
     * @param string email
     * 
     * @dataProvider providerEmailExpectedValues
     */
    public function testSetEmailReturnsExpectedResult($email , $expectedResult)
    {
        $details = array();

        $user = new User($details);

        $result = $user->setEmail($email);

        $this->assertEquals($result, $expectedResult);
    }

    public function providerEmailExpectedValues()
    {
        return [
            ['thanhtv', false],
            ['thanhtv(@cowell.com', false],    
            ['thanhtv@gmail.com', true],    
        ];
    }

    /**
     * @param string email
     * 
     * @dataProvider providerEmailWrong
     */
    public function testSetEmailReturnsFalseWhenEmailIsWrong($email)
    {
        $details = array();

        $user = new User($details);

        $email = 'thanhtv';

        $result = $user->setEmail($email);

        $this->assertFalse($result);
    }

    public function providerEmailWrong()
    {
        return [
            ['thanhtv'],
            ['thanhtv(@cowell.com'],    
            ['thanhtvthanh5f133db68b1f13b29ee85337829de400bf4918bf5f133db68b1f13b29ee85337829de400bf4918bf@gmail.com'],    
        ];
    }

    // vendor/bin/phpunit --coverage-html report

}