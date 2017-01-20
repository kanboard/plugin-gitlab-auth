<h3><i class="fa fa-gitlab fa-fw" aria-hidden="true"></i><?= t('GitLab Account') ?></h3>

<div class="panel">
    <?php if ($this->user->isCurrentUser($user['id'])): ?>
        <?php if (empty($user['gitlab_id'])): ?>
            <?= $this->url->link(t('Link my GitLab Account'), 'OAuthController', 'handler', array('plugin' => 'GitlabAuth'), true) ?>
        <?php else: ?>
            <?= $this->url->link(t('Unlink my GitLab Account'), 'OAuthController', 'unlink', array('backend' => 'Gitlab'), true) ?>
        <?php endif ?>
    <?php else: ?>
        <?= empty($user['gitlab_id']) ? t('No account linked.') : t('Account linked.') ?>
    <?php endif ?>
</div>
