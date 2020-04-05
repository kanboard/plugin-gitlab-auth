GitLab Authentication
=====================

Link a GitLab account to a Kanboard user profile.

Author
------

- Frédéric Guillot
- License MIT

Requirements
------------

- Kanboard >= 1.0.37
- Account on [GitLab.com](https://gitlab.com) or you own self-hosted GitLab instance
- Have Kanboard registered as application in GitLab (**Settings > Applications**)
- Kanboard application URL is defined properly

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/GitlabAuth`
3. Clone this repository into the folder `plugins/GitlabAuth`

Note: Plugin folder is case-sensitive.

Documentation
-------------

### How does this work?

The GitLab authentication in Kanboard uses the [OAuth 2.0](http://oauth.net/2/) protocol, so any user of Kanboard can be linked to a GitLab account.

That means you can use your GitLab account to login on Kanboard.

### Installation instructions

#### Setting up OAuth 2.0

- On GitLab, register a new application by following the [official documentation](http://doc.gitlab.com/ce/integration/oauth_provider.html)
- In Kanboard, you can get the **callback url** in **Settings > Integrations > GitLab Authentication**, just copy and paste the url

#### Setting up Kanboard

![GitLab Auth Settings](https://cloud.githubusercontent.com/assets/323546/16753427/ea8c94e4-47b7-11e6-8e6e-d9f1bf02a6bf.png)

1. The easiest way is to copy and paste the GitLab OAuth2 credentials in the form **Settings > Integrations > GitLab Authentication**.
2. Or add the credentials in your custom config file

If you use the second method, use these parameters in your `config.php`:

```php
// GitLab application id
define('GITLAB_CLIENT_ID', 'YOUR_APPLICATION_ID');

// GitLab application secret
define('GITLAB_CLIENT_SECRET', 'YOUR_APPLICATION_SECRET');
```

#### Custom endpoints for self-hosted GitLab

Change the default values if you use a self-hosted instance of GitLab:

- GitLab Authorize URL: `http://YOUR_GITLAB_HOSTNAME:CUSTOM_PORT/oauth/authorize` (example: `http://192.168.99.100:8080/oauth/authorize`)
- GitLab Token URL: `http://YOUR_GITLAB_HOSTNAME:CUSTOM_PORT/oauth/token`
- GitLab API URL: `http://YOUR_GITLAB_HOSTNAME:CUSTOM_PORT/api/v3/` (don't forget the trailing slash)


### How to link an existing GitLab account

![GitLab Link Account](https://cloud.githubusercontent.com/assets/323546/16753479/3d65a048-47b8-11e6-9112-a53e433dd73d.png)

1. Go to your user profile
2. Click on **External accounts**
3. Click on the link **Link my GitLab Account**
4. You are redirected to the **GitLab authorization form**
5. Authorize Kanboard by clicking on the button **Accept**
6. Your account is now linked

Now, on the login page you can be authenticated in one click with the link **Login with my GitLab Account**.

Your name and email are automatically updated from your GitLab Account if defined.


### How to create automatically users during the first login

![GitLab Account Creation](https://cloud.githubusercontent.com/assets/323546/16753428/ea8e4302-47b7-11e6-894b-d31b696b4357.png)

1. On the settings page, check the box **Allow Account Creation**
2. If you would like to apply a restriction based on the email domain name enter the correct value in the second field

New users will have the same username as the one in GitLab and they will be tagged as remote user.

**Important Note**: If you use the public GitLab and don't apply any domain restriction, everybody in the world will be able to sign in.


### Notes

Kanboard uses these information from your GitLab profile:

- Username
- Full name
- Email address
- GitLab unique id

The GitLab unique id is used to link the local user account and the GitLab account.

### Known issues

GitLab OAuth will work only with url rewrite enabled.
At the moment, GitLab doesn't support callback url with query string parameters. See [GitLab issue](https://gitlab.com/gitlab-org/gitlab-ce/issues/2443).
