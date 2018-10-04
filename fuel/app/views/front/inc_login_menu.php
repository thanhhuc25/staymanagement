<ul>
<?php if($is_login): ?>
<li class="loginId"><?php echo __('lbl_welcome') ?> <?php echo $name ?><?php echo __('lbl_sama') ?>（<?php echo __('lbl_logout2') ?><a href="<?php echo $logout_url ?>"><?php echo __('lbl_here') ?></a>）</li>
<?php else: ?>
<li class="loginId"><?php echo __('lbl_welcome') ?> <?php echo $name ?><?php echo __('lbl_sama') ?>（<?php echo __('lbl_login2') ?><a href="<?php echo $login_url ?>"><?php echo __('lbl_here') ?></a>）</li>
<?php endif; ?>
<li><a href="<?php echo $mypage_url ?>"><?php echo __('lbl_tomypage') ?></a></li>
</ul>
