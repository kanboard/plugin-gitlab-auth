<ul class="no-bullet">
    <li>
        <img src="<?= $this->url->dir() ?>plugins/GitlabAuth/gitlab-icon.png"/>&nbsp;
        <?= $this->url->link(t('Login with my Gitlab Account'), 'OAuth', 'handler', array('plugin' => 'GitlabAuth')) ?>
    </li>
</ul>