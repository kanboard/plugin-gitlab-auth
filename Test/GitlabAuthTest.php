<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\GitlabAuth\Auth\GitlabAuthProvider;
use Kanboard\Model\UserModel;

class GitlabAuthTest extends Base
{
    public function testGetName()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEquals('Gitlab', $provider->getName());
    }

    public function testGetClientId()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEmpty($provider->getClientId());

        $this->assertTrue($this->container['configModel']->save(array('gitlab_client_id' => 'my_id')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my_id', $provider->getClientId());
    }

    public function testGetClientSecret()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEmpty($provider->getClientSecret());

        $this->assertTrue($this->container['configModel']->save(array('gitlab_client_secret' => 'secret')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('secret', $provider->getClientSecret());
    }

    public function testGetOAuthAuthorizeUrl()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEquals('https://gitlab.com/oauth/authorize', $provider->getOAuthAuthorizeUrl());

        $this->assertTrue($this->container['configModel']->save(array('gitlab_authorize_url' => 'my auth url')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my auth url', $provider->getOAuthAuthorizeUrl());
    }

    public function testGetOAuthTokenUrl()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEquals('https://gitlab.com/oauth/token', $provider->getOAuthTokenUrl());

        $this->assertTrue($this->container['configModel']->save(array('gitlab_token_url' => 'my token url')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my token url', $provider->getOAuthTokenUrl());
    }

    public function testGetApiUrl()
    {
        $provider = new GitlabAuthProvider($this->container);
        $this->assertEquals('https://gitlab.com/api/v3/', $provider->getApiUrl());

        $this->assertTrue($this->container['configModel']->save(array('gitlab_api_url' => 'my api url')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my api url', $provider->getApiUrl());
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
        $userModel = new UserModel($this->container);
        $provider = new GitlabAuthProvider($this->container);

        $this->assertEquals(2, $userModel->create(array('username' => 'test', 'gitlab_id' => '1234')));
        $this->assertNotEmpty($userModel->getByExternalId('gitlab_id', 1234));

        $this->assertTrue($provider->unlink(2));
        $this->assertEmpty($userModel->getByExternalId('gitlab_id', 1234));
    }
}
