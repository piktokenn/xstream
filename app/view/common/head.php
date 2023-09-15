<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fff">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="cleartype" content="on">
    <link rel="dns-prefetch" href="//ajax.googleapis.com" />
    <link rel="dns-prefetch" href="//www.googletagmanager.com" />
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link as="style" media="all" rel="stylesheet" href="<?php echo ASSETS.'/css/theme.css?v='.VERSION;?>" type="text/css" crossorigin="anonymous" />
    <script type="text/javascript">
    var Base = "<?php echo APP; ?>";
    var Assets = "<?php echo APP.'/public/assets'?>";
    var __ = function(msgid) {
        return window.i18n[msgid] || msgid;
    };
    window.i18n = {
        'Deletion is successful': '<?php echo $this->translate("Deletion is successful");?>'
    };
    </script>
</head>

<body class="min-vh-100 layout">
    <div class="loading-page">  
        <div class="dot-falling"></div>
    </div>