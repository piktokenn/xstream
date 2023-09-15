<?php require PATH . '/config/array.config.php'; ?>
<?php $HomeGenres = $this->db->from('genres')->where('featured',1)->orderby('name','ASC')->limit(0,8)->all(); ?>
<?php if(get($Settings, 'data.header', 'customize') == 'v2') { ?>
<?php require PATH . '/theme/view/common/headerv2.php'; ?>
<?php } else { ?>
<?php require PATH . '/theme/view/common/headerv1.php'; ?>
<?php } ?>