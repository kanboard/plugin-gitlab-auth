<h3><i class="fa fa-gitlab fa-fw" aria-hidden="true"></i><?= t('Gitlab Account') ?></h3>

<p class="listing">
<?php if ($this->user->isCurrentUser($user['id'])): ?>
    <?php if (empty($user['gitlab_id'])): ?>
        <?= $this->url->link(t('Link my Gitlab Account'), 'OAuth', 'handler', array('plugin' => 'GitlabAuth'), true) ?>
    <?php else: ?>
        <?= $this->url->link(t('Unlink my Gitlab Account'), 'oauth', 'unlink', array('backend' => 'Gitlab'), true) ?>
    <?php endif ?>
<?php else: ?>
    <?= empty($user['gitlab_id']) ? t('No account linked.') : t('Account linked.') ?>
<?php endif ?>
</p>
