<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "TVEpisode",
    "name": "<?php echo $Listing['title'].' '.$Listing['season_name'].'.'.$this->translate('Season').' '.$Listing['season_name'].' '.$this->translate('Episode').' '.$Listing['episode_name'];?>",
    "image": "<?php echo UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image'];?>",
    "datePublished": "<?php echo date('Y-m-d');?>T00:00:00+03:00",
    "description": "<?php echo htmlspecialchars($Listing['overview']);?>",
    "potentialAction": {
        "@type": "WatchAction",
        "target": "<?php echo episode($Listing['id'],$Listing['self'],$Listing['season_name'],$Listing['title_number']);?>"
    },
    <?php if($Listing['trailer']) { ?>
    "trailer": {
        "@type": "VideoObject",
        "name": "<?php echo $Listing['title'].' '.$Listing['season_name'].'. '.$this->translate('Season').' '.$Listing['title_number'].'. '.$this->translate('Episode');?>",
        "description": "<?php echo htmlspecialchars($Listing['overview']);?>",
        "thumbnailUrl": "<?php echo UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image'];?>",
        "thumbnail": {
            "@type": "ImageObject",
            "contentUrl": "<?php echo UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image'];?>"
        },
        "uploadDate": "<?php echo date('Y-m-d');?>T00:00:00+03:00",
        "embedUrl": "<?php echo $Listing['trailer'];?>",
        "duration": "PT<?php echo $Listing['runtime'];?>M",
        "timeRequired": "PT<?php echo $Listing['runtime'];?>M",
        "publisher": {
            "@type": "Organization",
            "name": "<?php echo get($Settings,'data.company','general');?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?php echo LOCAL.'/'.get($Settings,'data.logo','general');?>"
            }
        },
        "interactionCount": "<?php echo $Listing['episode_view'];?>"
    },
    <?php } ?>
    "timeRequired": "PT<?php echo $Listing['runtime'];?>M",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?php echo $Listing['vote_average'];?>",
        "bestRating": "10.0",
        "worstRating": "1.0",
        "ratingCount": "<?php echo $Listing['view'];?>"
    }
}
</script>