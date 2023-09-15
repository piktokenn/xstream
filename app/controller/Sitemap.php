<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sitemap extends Controller {
    public function process() {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        
        $Posts          = $this->db->from(null,'SELECT count(posts.id) as total FROM `posts` WHERE status = 1')->total(); 
        $Episodes       = $this->db->from(null,'SELECT count(posts_episode.id) as total FROM `posts_episode` WHERE status = 1')->total(); 
        $Peoples        = $this->db->from(null,'SELECT count(peoples.id) as total FROM `peoples`')->total(); 
        $Genres         = $this->db->from(null,'SELECT count(genres.id) as total FROM `genres`')->total(); 
        $Collections    = $this->db->from(null,'SELECT count(collections.id) as total FROM `collections` WHERE privacy = "0"')->total(); 
        $Thread         = $this->db->from(null,'SELECT count(discussions.id) as total FROM `discussions`')->total(); 
       
        header("Content-Type: application/xml; charset=utf-8");
        echo '<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">';

        echo '<sitemap>';
        echo '<loc>'.APP.'/sitemap.main.xml</loc>';
        echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
        echo '</sitemap>';

        // Posts
        for ($ipost=1; $ipost <=ceil($Posts/SITEMAP_PAGE); $ipost++) { 
            echo '<sitemap>';
                echo '<loc>'.APP.'/sitemap.post_'.$ipost.'.xml</loc>';
                echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '</sitemap>';
        }

        // Episodes
        for ($iepisode=1; $iepisode <=ceil($Episodes/SITEMAP_PAGE); $iepisode++) { 
            echo '<sitemap>';
                echo '<loc>'.APP.'/sitemap.episode_'.$iepisode.'.xml</loc>';
                echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '</sitemap>';
        }

        // Peoples
        for ($ipeople=1; $ipeople <=ceil($Peoples/SITEMAP_PAGE); $ipeople++) { 
            echo '<sitemap>';
                echo '<loc>'.APP.'/sitemap.people_'.$ipeople.'.xml</loc>';
                echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '</sitemap>';
        }
        // Genres
        for ($igenre=1; $igenre <=ceil($Genres/SITEMAP_PAGE); $igenre++) { 
            echo '<sitemap>';
                echo '<loc>'.APP.'/sitemap.genre_'.$igenre.'.xml</loc>';
                echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '</sitemap>';
        }

        // Collections
        for ($icollection=1; $icollection <=ceil($Collections/SITEMAP_PAGE); $icollection++) { 
            echo '<sitemap>';
                echo '<loc>'.APP.'/sitemap.collection_'.$icollection.'.xml</loc>';
                echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '</sitemap>';
        }

        // Thread
        for ($ithread=1; $ithread <=ceil($Thread/SITEMAP_PAGE); $ithread++) { 
            echo '<sitemap>';
                echo '<loc>'.APP.'/sitemap.thread_'.$ithread.'.xml</loc>';
                echo '<lastmod>'.date("Y-m-d")."T".date("H:i:s").'+03:00</lastmod>';
            echo '</sitemap>';
        }

        echo '</sitemapindex>'; 
    }

}