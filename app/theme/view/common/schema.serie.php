<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "TVSeries",
    "name": "<?php echo $Listing['title'];?>",
    "image": "<?php echo UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image'];?>",
    "datePublished": "<?php echo date('Y-m-d');?>T23:04:34+03:00",
    <?php if(count($Peoples) > 0) { ?>
    "actor": [
    <?php 
    $ii = 1;
    foreach ($Peoples as $People) { ?>
      {
        "@type": "Person",
        "name": "<?php echo $People['name'];?>",
        "url": "<?php echo people($People['id'],$People['self']);?>"
    }
    <?php if($ii < count($Peoples)) echo ',';?>
    <?php $ii++; } ?>],
    <?php } ?>
    "description": "<?php echo $Listing['overview'];?>",
    "potentialAction": {
        "@type": "WatchAction",
        "target": "<?php echo post($Listing['id'],$Listing['self'],$Listing['type']);?>"
    },
    <?php if($Listing['country_name']) { ?>
    "countryOfOrigin": {
        "@type": "Country",
        "name": "<?php echo $Listing['country_name'];?>"
    },
    <?php } ?>
    <?php if($Listing['trailer']) { ?>
    "trailer": {
        "@type": "VideoObject",
        "name": "<?php echo $Listing['title'];?>",
        "description": "<?php echo $Listing['overview'];?>",
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
        "interactionCount": "<?php echo $Listing['view'];?>"
    },
    <?php } ?>
    "timeRequired": "PT<?php echo $Listing['runtime'];?>M",
    "containsSeason": [
        <?php 
			$ii = 0;
			foreach ($Seasons as $Season) { ?> 
        	{
            "@type": "TVSeason",
            "seasonNumber": "<?php echo $Season['name'];?>",
            "episode": [
        	<?php 
			$Episodes = $this->db->from('posts_episode')
			->where('status',1)
            ->where('season_id',$Season['id'])
			->where('post_id',$Listing['id'])
			->orderby('cast(title_number as unsigned)','ASC')
			->all();
			$iii = 0;
			foreach ($Episodes as $Episode) { ?>
            {
                "@type": "TVEpisode",
                "episodeNumber": "<?php echo $Episode['title_number'];?>",
                "name": "<?php echo ($Episode['title'] ? $Episode['title'] : $Episode['title_number']);?>",
                "datePublished": "2020-05-21T00:00:00+03:00",
                "url": "<?php echo episode($Listing['id'],$Listing['self'],$Season['name'],$Episode['title_number']);?>"
            }<?php if(++$iii != count($Episodes)) { echo ',';}?>
        	<?php } ?>
            ]
        }<?php if(++$ii != count($Seasons)) { echo ',';}?>
        <?php } ?>
    ],
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?php echo $Listing['vote_average'];?>",
        "bestRating": "10.0",
        "worstRating": "1.0",
        "ratingCount": "<?php echo $Listing['view'];?>"
    },
    "director": {
        "@type": "Person",
        "name": "<?php echo get($Settings,'data.company','general');?>"
    },
    "review": {
        "@type": "Review",
        "author": {
            "@type": "Person",
            "name": "<?php echo get($Settings,'data.company','general');?>"
        },
        "datePublished": "<?php echo date('Y-m-d');?>:04:34+03:00",
        "reviewBody": "<?php echo $Listing['overview'];?>"
    }
}
</script>