<!DOCTYPE html>
<html lang="<?php echo ACTIVE_LANG;?>">
<head>
    <title><?php echo $Config['title'];?></title>
    <meta name="description" content="<?php echo htmlspecialchars($Config['description']);?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#111113">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <?php if(isset($Config['url'])) { ?>
    <link rel="canonical" href="<?php echo $Config['url'];?>" />
    <?php } ?>
    <?php if(isset($Config['disabled']) AND $Config['disabled'] == 'on') { ?>
    <meta name="robots" content="noindex,follow" />
    <?php } else { ?>
    <meta name="robots" content="index,follow" />
    <?php } ?>
    <meta http-equiv="cleartype" content="on">
    <link rel="dns-prefetch" href="//ajax.googleapis.com" />
    <link rel="dns-prefetch" href="//www.googletagmanager.com" />
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="preload" as="font" type="font/woff2" href="<?php echo ASSETS.'/fonts/Inter-Regular.woff2?v=3.19';?>" crossorigin="anonymous">
    <link rel="preload" as="font" type="font/woff2" href="<?php echo ASSETS.'/fonts/Inter-SemiBold.woff2?v=3.19';?>" crossorigin="anonymous">
    <link rel="preload" as="font" type="font/woff2" href="<?php echo ASSETS.'/fonts/Inter-Medium.woff2?v=3.19';?>" crossorigin="anonymous">
    <link rel="preload" as="font" type="font/woff2" href="<?php echo ASSETS.'/fonts/Inter-Bold.woff2?v=3.19';?>" crossorigin="anonymous">
    <link rel="preload" as="font" type="font/woff2" href="<?php echo ASSETS.'/fonts/Inter-ExtraBold.woff2?v=3.19';?>" crossorigin="anonymous">
    <link as="style" media="all" rel="stylesheet" href="<?php echo THEME.'/css/theme.css?v='.VERSION;?>" type="text/css" crossorigin="anonymous" defer="">
    <link rel="shortcut icon" href="<?php echo LOCAL.'/'.get($Settings,'data.favicon','general').'?v='.VERSION;?>">
    <script type="text/javascript">
    var Base = "<?php echo APP; ?>";
    var Assets = "<?php echo APP.'/public/assets'?>";
    <?php if(isset($AuthUser['id'])) { ?>
    var _Auth = true;
    <?php } else { ?>
    var _Auth = false;
    <?php } ?>
    var __ = function(msgid) {
        return window.i18n[msgid] || msgid;
    };
    window.i18n = {
        'more': '<?php echo $this->translate("more");?>',
        'less': '<?php echo $this->translate("less");?>'
    };
    var ad_vast = '<?php echo ads($Ads,4,null);?>';
    </script>
    <style type="text/css">
    :root {
        --theme-color: <?php echo get($Settings, "data.color", "customize");?>;
        --background: <?php echo get($Settings, "data.background", "customize");?>;
        --movie-aspect: 150%;
        --people-aspect: 100%;
        --slide-aspect: 60vh;
    }
    <?php if(get($Settings,'data.width','customize')) { ?>
        @media (min-width: 1400px) {
            .container {
                max-width: <?php echo get($Settings,'data.width','customize');?>px !important;
            }
        }
    <?php } ?>
    </style>
    <?php echo get($Settings,'data.custom_code','general');?>
    <?php echo ads($Ads,3,null);?>
</head>

<body class="layout">
<?php 
if(get($Settings,'data.history','general') == 1) {
$Populars = $this->db->from(null,'
    SELECT DISTINCT posts.id,
    posts.title,
    posts.image,
    posts.self,
    posts.type,
    posts.view,
    posts.created
    FROM
    `posts_log`
    INNER JOIN posts ON posts_log.post_id = posts.id 
    WHERE posts.status = 1 AND posts_log.created BETWEEN SUBDATE( CURDATE(), 30 ) AND CURDATE() 
    ORDER BY posts.view DESC LIMIT 0,8')
    ->all();
} else {
    $Populars = $this->db->from(null,'
        SELECT DISTINCT posts.id,
        posts.title,
        posts.image,
        posts.self,
        posts.type,
        posts.view,
        posts.created
        FROM
        `posts` 
        WHERE posts.status = 1
        ORDER BY posts.view DESC LIMIT 0,8')
        ->all();
}
?>
<div id="loading-bar"></div>