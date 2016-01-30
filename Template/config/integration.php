<h3><img src="<?= $this->url->dir() ?>plugins/GitlabAuth/gitlab-icon.png"/>&nbsp;<?= t('Gitlab Authentication') ?></h3>
<div class="listing">

    <?= $this->form->label(t('Gitlab OAuth callback URL'), 'gitlab_oauth_url') ?>
    <input type="text" class="auto-select" readonly="readonly" value="<?= $this->url->href('OAuth', 'handler', array('plugin' => 'GitlabAuth'), false, '', true) ?>"/>

    <?= $this->form->label(t('Gitlab Client Id'), 'gitlab_client_id') ?>
    <?= $this->form->text('gitlab_client_id', $values) ?>

    <?= $this->form->label(t('Gitlab Client Secret'), 'gitlab_client_secret') ?>
    <?= $this->form->password('gitlab_client_secret', $values) ?>

    <?= $this->form->label(t('Gitlab Authorize URL'), 'gitlab_authorize_url') ?>
    <?= $this->form->text('gitlab_authorize_url', $values) ?>
    <p class="form-help"><?= t('Leave blank to use the default URL.') ?></p>

    <?= $this->form->label(t('Gitlab Token URL'), 'gitlab_token_url') ?>
    <?= $this->form->text('gitlab_token_url', $values) ?>

    <?= $this->form->label(t('Gitlab API URL'), 'gitlab_api_url') ?>
    <?= $this->form->text('gitlab_api_url', $values) ?>

    <p class="form-help"><a href="https://github.com/kanboard/plugin-gitlab-auth/blob/master/README.md"><?= t('Help on Gitlab authentication') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>