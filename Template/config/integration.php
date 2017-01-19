<h3><i class="fa fa-gitlab fa-fw" aria-hidden="true"></i><?= t('Gitlab Authentication') ?></h3>
<div class="panel">

    <?= $this->form->label(t('GitLab OAuth callback URL'), 'gitlab_oauth_url') ?>
    <input type="text" class="auto-select" readonly="readonly" value="<?= $this->url->href('OAuthController', 'handler', array('plugin' => 'GitlabAuth'), false, '', true) ?>"/>

    <?= $this->form->label(t('GitLab Client Id'), 'gitlab_client_id') ?>
    <?= $this->form->text('gitlab_client_id', $values) ?>

    <?= $this->form->label(t('GitLab Client Secret'), 'gitlab_client_secret') ?>
    <?= $this->form->password('gitlab_client_secret', $values) ?>

    <?= $this->form->label(t('GitLab Authorize URL'), 'gitlab_authorize_url') ?>
    <?= $this->form->text('gitlab_authorize_url', $values) ?>
    <p class="form-help"><?= t('Leave blank to use the default URL.') ?></p>

    <?= $this->form->label(t('GitLab Token URL'), 'gitlab_token_url') ?>
    <?= $this->form->text('gitlab_token_url', $values) ?>

    <?= $this->form->label(t('GitLab API URL'), 'gitlab_api_url') ?>
    <?= $this->form->text('gitlab_api_url', $values) ?>

    <?= $this->form->hidden('gitlab_account_creation', array('gitlab_account_creation' => 0)) ?>
    <?= $this->form->checkbox('gitlab_account_creation', t('Allow Account Creation'), 1, isset($values['gitlab_account_creation']) && $values['gitlab_account_creation'] == 1) ?>

    <?= $this->form->label(t('Allow account creation only for those domains'), 'gitlab_email_domains') ?>
    <?= $this->form->text('gitlab_email_domains', $values) ?>
    <p class="form-help"><?= t('Use a comma to enter multiple domains: domain1.tld, domain2.tld') ?></p>

    <p class="form-help"><a href="https://kanboard.net/plugin/gitlab-auth"><?= t('Help on GitLab authentication') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
