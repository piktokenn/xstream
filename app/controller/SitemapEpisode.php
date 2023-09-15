<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SitemapEpisode extends Controller {
    public function process() {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        if($Route->params->page == 1) {
            $PageStart = 0;
        } elseif($Route->params->page > 1) {
            $PageStart = ceil(($Route->params->page-1) * SITEMAP_PAGE);
        }
        $Listings = $this->db->from(null,'
            SELECT 
            posts.id, 
            posts.self, 
            posts_season.name,
            posts_episode.title_number
            FROM `posts_episode` 
            LEFT JOIN posts_season ON posts_episode.season_id = posts_season.id AND posts_season.id IS NOT NULL
            LEFT JOIN posts ON posts.id = posts_season.post_id AND posts_season.post_id IS NOT NULL
            WHERE posts_episode.status = 1
            LIMIT '.$PageStart.','.SITEMAP_PAGE)
            ->all(); 
        header("Content-Type: application/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($Listings as $Listing) {
            echo '<url>';
            echo '<loc>'.episode($Listing['id'],$Listing['self'],$Listing['name'],$Listing['title_number']).'</loc>';
            echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '<changefreq>hourly</changefreq>';
            echo '<priority>1.0</priority>';
            echo '</url>';
        }
        echo '</urlset>'; 
       

    }

}