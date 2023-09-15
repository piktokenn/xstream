<?php
/**
 * Main Controller
 */
class Main extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");

        // Config
        $Config['nav']  = 'main';
        $Config['search']  = true;


        $Total['movies']     = $this->db->from(null,'SELECT count(posts.id) as total FROM `posts` WHERE type = "movie"')->total(); 
        $Total['series']     = $this->db->from(null,'SELECT count(posts.id) as total FROM `posts` WHERE type = "serie"')->total(); 
        $Total['users']      = $this->db->from(null,'SELECT count(users.id) as total FROM `users`')->total(); 
        $Total['comments']      = $this->db->from(null,'SELECT count(comments.id) as total FROM `comments`')->total(); 
        $Total['reports']      = $this->db->from(null,'SELECT count(reports.id) as total FROM `reports`')->total(); 

        $Users     = $this->db->from(null,'
            SELECT    
            users.created,
            DATE(created) as DATE, count(`id`) total
            FROM users
            WHERE created >= CAST(NOW() - INTERVAL 1 WEEK AS DATE) AND created <= CAST(NOW() AS DATE)
            GROUP BY  DATE(created)
            ')->all(); 

        $Posts     = $this->db->from(null,'
            SELECT    
            posts.created,
            DATE(created) as DATE, count(`id`) total
            FROM posts
            WHERE created >= CAST(NOW() - INTERVAL 1 WEEK AS DATE) AND created <= CAST(NOW() AS DATE)
            GROUP BY DATE(created)
            ')->all(); 


        $Listings = $this->db->from(null,'
            SELECT posts.*
            FROM `posts`  
            LEFT JOIN (
                  SELECT
                    post_id, 
                    genre_id 
                  FROM `posts_genre`   

                  GROUP BY posts_genre.post_id
                  ORDER BY posts_genre.genre_id DESC
                ) posts_genre ON posts.id = posts_genre.post_id
            LEFT JOIN genres ON genres.id = posts_genre.genre_id
            ORDER BY posts.id DESC
            LIMIT 0,10')
            ->all();
        $this->setVariable("Config", $Config);  
        $this->setVariable("Total", $Total);  
        $this->setVariable("Users", $Users);  
        $this->setVariable("Listings", $Listings);  
        $this->setVariable("Posts", $Posts);  
        
        $this->view("main", "admin");
    }
}