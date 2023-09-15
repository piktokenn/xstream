<?php
/**
 * Thread Controller
 */
class Thread extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

 
        if (isset($Route->params->id)) {
            $Listing = $this->db->from(null,'
                SELECT 
                discussions.*,
                posts.title as post_title,
                posts.self as post_self,
                posts.type as post_type,
                posts.title_sub,
                posts.image,
                users.username,
                users.firstname,
                users.avatar,
                users.color,
                (SELECT 
                COUNT(comments.post_id) 
                FROM comments 
                WHERE comments.type = "discussion" AND post_id = discussions.id) AS reply
                FROM `discussions`
                LEFT JOIN posts ON discussions.post_id = posts.id AND discussions.post_id IS NOT NULL 
            LEFT JOIN users ON discussions.user_id = users.id AND discussions.user_id IS NOT NULL
                WHERE discussions.id = "'.$Route->params->id.'"')
            ->first();
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }
        }
        
        $Users = $this->db->from(null,'
            SELECT 
            users.*
            FROM `users`  
            LIMIT 0,10')
            ->all();

        $new    = array($Listing['title']);
        $old    = array('[title]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.thread_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.thread_description','seo'))));
        $Config['url']          = thread($Listing['id'],$Listing['self']);
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'thread';

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing); 
        $this->setVariable('Users', $Users);   

        $this->view("thread", "app");
    }

}