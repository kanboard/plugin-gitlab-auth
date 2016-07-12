<?php

use Kanboard\Plugin\GitlabAuth\User\GitlabUserProvider;

require_once 'tests/units/Base.php';

class GitlabUserProviderTest extends Base
{
    public function testIsUserCreationAllowed()
    {
        $userProvider = new GitlabUserProvider(array());
        $this->assertFalse($userProvider->isUserCreationAllowed());

        $userProvider = new GitlabUserProvider(array(), true);
        $this->assertTrue($userProvider->isUserCreationAllowed());
    }

    public function testGetEmail()
    {
        $userProvider = new GitlabUserProvider(array('email' => 'test@gmail.com'));
        $this->assertEquals('test@gmail.com', $userProvider->getEmail());
    }

    public function testGetRole()
    {
        $userProvider = new GitlabUserProvider(array('email' => 'test@gmail.com'), true);
        $this->assertSame('', $userProvider->getRole());
    }

    public function testGetName()
    {
        $userProvider = new GitlabUserProvider(array());
        $this->assertEquals('', $userProvider->getName());

        $userProvider = new GitlabUserProvider(array('name' => 'test'));
        $this->assertEquals('test', $userProvider->getName());
    }

    public function testGetUserName()
    {
        $userProvider = new GitlabUserProvider(array('username' => 'test'));
        $this->assertEquals('', $userProvider->getUsername());

        $userProvider = new GitlabUserProvider(array('username' => 'test'), true);
        $this->assertEquals('test', $userProvider->getUsername());
    }

    public function testGetExternalIdColumn()
    {
        $userProvider = new GitlabUserProvider(array('email' => 'test@gmail.com'));
        $this->assertEquals('gitlab_id', $userProvider->getExternalIdColumn());
    }

    public function testGetExtraAttribute()
    {
        $userProvider = new GitlabUserProvider(array('email' => 'test@gmail.com'));
        $this->assertSame(array(), $userProvider->getExtraAttributes());

        $userProvider = new GitlabUserProvider(array('email' => 'test@gmail.com'), true);
        $this->assertSame(array('is_ldap_user' => 1, 'disable_login_form' => 1), $userProvider->getExtraAttributes());
    }
}
