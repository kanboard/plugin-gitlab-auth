Gitlab Authentication
=====================

[![Build Status](https://travis-ci.org/kanboard/plugin-gitlab-auth.svg?branch=master)](https://travis-ci.org/kanboard/plugin-gitlab-auth)

Link a Gitlab account to a Kanboard user profile.

Author
------

- Frédéric Guillot
- License MIT

Requirements
------------

- Account on [Gitlab.com](https://gitlab.com) or you own self-hosted Gitlab instance
- Have Kanboard registered as application in Gitlab

Installation
------------

- Decompress the archive in the `plugins` folder

or

- Create a folder **plugins/GitlabAuth**
- Copy all files under this directory

Documentation
-------------

### How does this work?

The Gitlab authentication in Kanboard uses the [OAuth 2.0](http://oauth.net/2/) protocol, so any user of Kanboard can be linked to a Gitlab account.

That means you can use your Gitlab account to login on Kanboard.

### How to link a Gitlab account

1. Go to your user profile
2. Click on **External accounts**
3. Click on the link **Link my Gitlab Account**
4. You are redirected to the **Gitlab authorization form**
5. Authorize Kanboard by clicking on the button **Accept**
6. Your account is now linked

Now, on the login page you can be authenticated in one click with the link **Login with my Gitlab Account**.

Your name and email are automatically updated from your Gitlab Account if defined.

### Installation instructions

#### Setting up OAuth 2.0

- On Gitlab, register a new application by following the [official documentation](http://doc.gitlab.com/ce/integration/oauth_provider.html)
- In Kanboard, you can get the **callback url** in **Settings > Integrations > Gitlab Authentication**, just copy and paste the url

#### Setting up Kanboard

1. The easiest way is to copy and paste the Gitlab OAuth2 credentials in the form **Settings > Integrations > Gitlab Authentication**.
2. Or add the credentials in your custom config file

![Gitlab Auth Settings](https://cloud.githubusercontent.com/assets/323546/12696079/90da18f4-c72e-11e5-856c-eda54e53b274.png)

If you use the second method, use these parameters in your `config.php`:

```php
// Gitlab application id
define('GITLAB_CLIENT_ID', 'YOUR_APPLICATION_ID');

// Gitlab application secret
define('GITLAB_CLIENT_SECRET', 'YOUR_APPLICATION_SECRET');
```

#### Custom endpoints for self-hosted Gitlab

Change these default values if you use a self-hosted instance of Gitlab:

```php
// Gitlab oauth2 authorize url
define('GITLAB_OAUTH_AUTHORIZE_URL', 'https://gitlab.com/oauth/authorize');

// Gitlab oauth2 token url
define('GITLAB_OAUTH_TOKEN_URL', 'https://gitlab.com/oauth/token');

// Gitlab API url endpoint (don't forget the slash at the end)
define('GITLAB_API_URL', 'https://gitlab.com/api/v3/');
```

### Notes

Kanboard uses these information from your Gitlab profile:

- Full name
- Email address
- Gitlab unique id

The Gitlab unique id is used to link the local user account and the Gitlab account.

### Known issues

Gitlab OAuth will work only with url rewrite enabled. At the moment, Gitlab doesn't support callback url with query string parameters. See [Gitlab issue](https://gitlab.com/gitlab-org/gitlab-ce/issues/2443)
