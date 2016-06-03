<?php

namespace Kanboard\Plugin\GitlabAuth\User;

use Kanboard\User\OAuthUserProvider;

/**
 * Gitlab OAuth User Provider
 *
 * @package  user
 * @author   Frederic Guillot
 */
class GitlabUserProvider extends OAuthUserProvider
{
    /**
     * @var bool
     */
    protected $allowUserCreation;
    /**
     * Constructor
     *
     * @access public
     * @param  array $user
     * @param  bool   $allowUserCreation
     */
    public function __construct(array $user, $allowUserCreation = false)
    {
        $this->user = $user;
        $this->allowUserCreation = $allowUserCreation;
    }
    /**
     * Get username
     *
     * @access public
     * @return string
     */
    public function getUsername()
    {
        if ($this->allowUserCreation) {
            return $this->user['username'];
        }

        return '';
    }
    /**
     * Get name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        if ($this->allowUserCreation) {
            return $this->user['name'];
        }

        return '';
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function getEmail()
    {
        if ($this->allowUserCreation) {
            return $this->user['email'];
        }

        return '';
    }
    /**
     * Get Avatar image url from Google profile
     *
     * @access public
     * @return string
     */
    public function getAvatarUrl()
    {
        return !empty($this->user['avatar_url']) ? $this->user['avatar_url'] : '';
    }
    /**
     * Return true to allow automatic user creation
     *
     * @access public
     * @return boolean
     */
    public function isUserCreationAllowed()
    {
        return $this->allowUserCreation;
    }

    /**
     * Get external id column name
     *
     * @access public
     * @return string
     */
    public function getExternalIdColumn()
    {
        return 'gitlab_id';
    }

    
}
