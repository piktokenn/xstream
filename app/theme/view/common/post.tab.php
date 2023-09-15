<div class="post-toolbar">
    <ul data-ajax-tab="">
        <li>
            <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']);?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/overview?ajax=true';?>" class="<?php echo (empty($Route->params->tab) ? 'active' : '');?>">Overview</a>
        </li>
        <li>
            <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/casting';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/casting?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'casting') ? 'active' : '');?>">Casting</a>
        </li>
        <?php if(empty($Data['comment']) OR (isset($Data['comment']) AND $Data['comment'] != 1)) { ?>
        <li>
            <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/comments';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/comments?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'comments') ? 'active' : '');?>">Comment<span class="ms-2 fs-xs opacity-50"><?php echo $Listing['comments'];?></span></a>
        </li>
        <?php } ?>
        <li class="mx-xl-3"></li>
        <li>
            <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/subtitle';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/subtitle?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'subtitle') ? 'active' : '');?>">Subtitle</a>
        </li>
        <li>
            <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/multimedia';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/multimedia?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'multimedia') ? 'active' : '');?>">Multimedia</a>
        </li>
        <li>
            <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/download';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/download?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'download') ? 'active' : '');?>">Download</a>
        </li>
    </ul>
</div>
<div class="layout-section pt-2">
    <div class="layout-tab-content">

            <?php if(empty($Route->params->tab)) { ?>
            <?php require PATH . '/theme/view/common/post.overview.php'; ?>
            <?php } elseif(isset($Route->params->tab) AND in_array($Route->params->tab,array('comments','multimedia','casting','download','subtitle'))) { ?>
            <?php require PATH . '/theme/view/common/post.'.$Route->params->tab.'.php'; ?>
            <?php } else { ?>
            <?php header('location:'.APP.'/404');?>
            <?php } ?>
    </div>
     
</div>