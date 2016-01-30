<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\GitlabAuth\Auth\GitlabAuthProvider;
use Kanboard\Model\User;

class GitlabAuthTest extends Base
{
    public function testGetName()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEquals('Gitlab', $provider->getName());
    }

    public function testAuthenticationSuccessful()
    {
        $profile = array(
            'id' => 1234,
            'email' => 'test@localhost',
            'name' => 'Test',
        );

        $provider = $this
            ->getMockBuilder('\Kanboard\Plugin\GitlabAuth\Auth\GitlabAuthProvider')
            ->setConstructorArgs(array($this->container))
            ->setMethods(array(
                'getProfile',
            ))
            ->getMock();

        $provider->expects($this->once())
            ->method('getProfile')
            ->will($this->returnValue($profile));

        $this->assertInstanceOf('Kanboard\Plugin\GitlabAuth\Auth\GitlabAuthProvider', $provider->setCode('1234'));

        $this->assertTrue($provider->authenticate());

        $user = $provider->getUser();
        $this->assertInstanceOf('Kanboard\Plugin\GitlabAuth\User\GitlabUserProvider', $user);
        $this->assertEquals('Test', $user->getName());
        $this->assertEquals('', $user->getInternalId());
        $this->assertEquals(1234, $user->getExternalId());
        $this->assertEquals('', $user->getRole());
        $this->assertEquals('', $user->getUsername());
        $this->assertEquals('test@localhost', $user->getEmail());
        $this->assertEquals('gitlab_id', $user->getExternalIdColumn());
        $this->assertEquals(array(), $user->getExternalGroupIds());
        $this->assertEquals(array(), $user->getExtraAttributes());
        $this->assertFalse($user->isUserCreationAllowed());
    }

    public function testAuthenticationFailed()
    {
        $provider = $this
            ->getMockBuilder('\Kanboard\Plugin\GitlabAuth\Auth\GitlabAuthProvider')
            ->setConstructorArgs(array($this->container))
            ->setMethods(array(
                'getProfile',
            ))
            ->getMock();

        $provider->expects($this->once())
            ->method('getProfile')
            ->will($this->returnValue(array()));

        $this->assertFalse($provider->authenticate());
        $this->assertEquals(null, $provider->getUser());
    }

    public function testGetService()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertInstanceOf('Kanboard\Core\Http\OAuth2', $provider->getService());
    }

    public function testUnlink()
    {
        $userModel = new User($this->container);
        $provider = new GitlabAuthProvider($this->container);

        $this->assertEquals(2, $userModel->create(array('username' => 'test', 'gitlab_id' => '1234')));
        $this->assertNotEmpty($userModel->getByExternalId('gitlab_id', 1234));

        $this->assertTrue($provider->unlink(2));
        $this->assertEmpty($userModel->getByExternalId('gitlab_id', 1234));
    }
}
