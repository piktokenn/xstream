<?php
/**
 * Comment Controller
 */
class Comment extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config 
        $Config['nav']  = 'comments';

        if (isset($Route->params->id)) {
            $Listing = $this->db->from(null,'
            SELECT comments.*,
            users.username,
            users.avatar,
            users.color,
            users.firstname,
            users.lastname,
            users.email,
            posts.title as post_title,
            posts.title_sub,
            posts.image,
            posts.type,
            posts_episode.title_number,
            posts_season.name
            FROM `comments`  
            LEFT JOIN users ON comments.user_id = users.id AND comments.user_id IS NOT NULL
            LEFT JOIN posts ON comments.post_id = posts.id AND (comments.type = "post" OR comments.type = "episode")
            LEFT JOIN posts_episode ON comments.episode_id = posts_episode.id AND comments.type = "episode" AND comments.episode_id IS NOT NULL 
            LEFT JOIN posts_season ON posts_episode.season_id = posts_season.id AND posts_episode.season_id IS NOT NULL 
            LEFT JOIN discussions ON comments.post_id = discussions.id AND comments.type = "discussion" AND comments.post_id IS NOT NULL 
            WHERE comments.id = "'.$Route->params->id.'"')
            ->first();
        } else {
            header('location:'.APP.'/admin/comments');
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("comment", "admin");
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {
            $dataarray          = array(
                "comment"       => Input::cleaner($_POST['comment']),
                "spoiler"       => (int)Input::cleaner($_POST['spoiler'],2),
                "status"        => (int)Input::cleaner($_POST['status'],2)
            );   
            $this->db->update('comments')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/comments');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}