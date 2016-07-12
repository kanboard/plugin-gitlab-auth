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
    protected $allowUserCreation = false;

    /**
     * Constructor
     *
     * @access public
     * @param  array $user
     * @param  bool  $allowUserCreation
     */
    public function __construct(array $user, $allowUserCreation = false)
    {
        $this->user = $user;
        $this->allowUserCreation = $allowUserCreation;
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
     * Get external id column name
     *
     * @access public
     * @return string
     */
    public function getExternalIdColumn()
    {
        return 'gitlab_id';
    }

    /**
     * Get extra user attributes
     *
     * @access public
     * @return array
     */
    public function getExtraAttributes()
    {
        if ($this->allowUserCreation) {
            return array(
                'is_ldap_user' => 1,
                'disable_login_form' => 1,
            );
        }

        return array();
    }
}
