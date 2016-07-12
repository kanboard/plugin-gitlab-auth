<?php

namespace Kanboard\Plugin\GitlabAuth\Auth;

use Kanboard\Core\Base;
use Kanboard\Core\Security\OAuthAuthenticationProviderInterface;
use Kanboard\Plugin\GitlabAuth\User\GitlabUserProvider;

/**
 * Gitlab Authentication Provider
 *
 * @package  auth
 * @author   Frederic Guillot
 */
class GitlabAuthProvider extends Base implements OAuthAuthenticationProviderInterface
{
    /**
     * User properties
     *
     * @access private
     * @var \Kanboard\Plugin\GitlabAuth\User\GitlabUserProvider
     */
    private $userInfo = null;

    /**
     * OAuth2 instance
     *
     * @access protected
     * @var \Kanboard\Core\Http\OAuth2
     */
    protected $service;

    /**
     * OAuth2 code
     *
     * @access protected
     * @var string
     */
    protected $code = '';

    /**
     * Get authentication provider name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'Gitlab';
    }

    /**
     * Authenticate the user
     *
     * @access public
     * @return boolean
     */
    public function authenticate()
    {
        $profile = $this->getProfile();

        if (! empty($profile)) {
            $this->userInfo = new GitlabUserProvider($profile, $this->isAccountCreationAllowed($profile));
            return true;
        }

        return false;
    }

    /**
     * Set Code
     *
     * @access public
     * @param  string  $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get user object
     *
     * @access public
     * @return GitlabUserProvider
     */
    public function getUser()
    {
        return $this->userInfo;
    }

    /**
     * Get configured OAuth2 service
     *
     * @access public
     * @return \Kanboard\Core\Http\OAuth2
     */
    public function getService()
    {
        if (empty($this->service)) {
            $this->service = $this->oauth->createService(
                $this->getClientId(),
                $this->getClientSecret(),
                $this->helper->url->to('OAuthController', 'handler', array('plugin' => 'GitlabAuth'), '', true),
                $this->getOAuthAuthorizeUrl(),
                $this->getOAuthTokenUrl(),
                array()
            );
        }

        return $this->service;
    }

    /**
     * Get Gitlab profile
     *
     * @access public
     * @return array
     */
    public function getProfile()
    {
        $this->getService()->getAccessToken($this->code);

        return $this->httpClient->getJson(
            $this->getApiUrl().'user',
            array($this->getService()->getAuthorizationHeader())
        );
    }

    /**
     * Unlink user
     *
     * @access public
     * @param  integer $userId
     * @return bool
     */
    public function unlink($userId)
    {
        return $this->userModel->update(array('id' => $userId, 'gitlab_id' => ''));
    }

    /**
     * Get client id
     *
     * @access public
     * @return string
     */
    public function getClientId()
    {
        if (defined('GITLAB_CLIENT_ID') && GITLAB_CLIENT_ID) {
            return GITLAB_CLIENT_ID;
        }

        return $this->configModel->get('gitlab_client_id');
    }

    /**
     * Get client secret
     *
     * @access public
     * @return string
     */
    public function getClientSecret()
    {
        if (defined('GITLAB_CLIENT_SECRET') && GITLAB_CLIENT_SECRET) {
            return GITLAB_CLIENT_SECRET;
        }

        return $this->configModel->get('gitlab_client_secret');
    }

    /**
     * Get authorize url
     *
     * @access public
     * @return string
     */
    public function getOAuthAuthorizeUrl()
    {
        if (defined('GITLAB_OAUTH_AUTHORIZE_URL') && GITLAB_OAUTH_AUTHORIZE_URL) {
            return GITLAB_OAUTH_AUTHORIZE_URL;
        }

        return $this->configModel->get('gitlab_authorize_url', 'https://gitlab.com/oauth/authorize');
    }

    /**
     * Get token url
     *
     * @access public
     * @return string
     */
    public function getOAuthTokenUrl()
    {
        if (defined('GITLAB_OAUTH_TOKEN_URL') && GITLAB_OAUTH_TOKEN_URL) {
            return GITLAB_OAUTH_TOKEN_URL;
        }

        return $this->configModel->get('gitlab_token_url', 'https://gitlab.com/oauth/token');
    }

    /**
     * Get API url
     *
     * @access public
     * @return string
     */
    public function getApiUrl()
    {
        if (defined('GITLAB_API_URL') && GITLAB_API_URL) {
            return GITLAB_API_URL;
        }

        return $this->configModel->get('gitlab_api_url', 'https://gitlab.com/api/v3/');
    }

    /**
     * Return true if the account creation is allowed according to the settings
     *
     * @access public
     * @param array $profile
     * @return bool
     */
    public function isAccountCreationAllowed(array $profile)
    {
        if ($this->configModel->get('gitlab_account_creation', 0) == 1) {
            $domains = $this->configModel->get('gitlab_email_domains');

            if (! empty($domains)) {
                return $this->validateDomainRestriction($profile, $domains);
            }

            return true;
        }

        return false;
    }

    /**
     * Validate domain restriction
     *
     * @access private
     * @param  array  $profile
     * @param  string $domains
     * @return bool
     */
    public function validateDomainRestriction(array $profile, $domains)
    {
        foreach (explode(',', $domains) as $domain) {
            $domain = trim($domain);

            if (strpos($profile['email'], $domain) > 0) {
                return true;
            }
        }

        return false;
    }
}
