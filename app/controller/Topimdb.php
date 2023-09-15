<?php
/**
 * Topimdb Controller
 */
class Topimdb extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Top IMDb').' – '.get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['cache']        = 'true';

     
     
        $Listings = $this->db->from(null,'
            SELECT 
            posts.id, 
            posts.title,  
            posts.title_sub,  
            posts.self, 
            posts.image, 
            posts.type,
            posts.release_date,
            posts.upcoming,
            posts.vote_average,
            genres.name
            FROM `posts` 
            LEFT JOIN posts_genre ON posts_genre.post_id = posts.id  
            LEFT JOIN genres ON genres.id = posts_genre.genre_id  
            WHERE posts.status = 1
            GROUP BY posts.id
            ORDER BY posts.vote_average DESC
            LIMIT 0,100')
            ->all();
        $this->setVariable("Config", $Config);   
        $this->setVariable("Listings", $Listings);   

        $this->view("topimdb", "app");
    }
}