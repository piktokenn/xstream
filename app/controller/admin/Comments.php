<?php
/**
 * Comments Controller
 */
class Comments extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config 
        $Config['btn']      = 'comment';
        $Config['nav']      = 'comments';
        $Config['page']     = $this->translate('Comments');


        // Filter
        $i              = 0;
        $FilterSlug     = null;
        if(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'filter') {
            foreach ($_POST as $key => $value) {
                if ($i == 0 AND !empty($_POST[$key])) {
                    $FilterSlug .= '?'.$key.'='.$_POST[$key];
                } elseif(!empty($_POST[$key])) {
                    $FilterSlug .= '&'.$key.'='.$_POST[$key];
                }
                $i++;
            }
           header("location: ".APP.'/admin/comments'.$FilterSlug);
            
        }

        $Filter = array (
            'q'             => 'search',
            'sorting'       => 'order'
        );

        $Where      = null;
        $Orderby    = null;
        foreach($Filter as $key => $value) {
            if (isset($_GET[$key])) {
                if ($i == 0) {
                    $FilterSlug .= '?'.$key.'='.$_GET[$key];
                } else {
                    $FilterSlug .= '&'.$key.'='.$_GET[$key];
                }
                $i++;
                if($value == 'filter') {
                    $Where .= 'comments.'.$key.' = "'.$_GET[$key].'" AND '; 
                } elseif ($value == 'search') {
                    $Where .= 'comments.title LIKE "%'.$_GET[$key].'%" AND ';
                } elseif ($value == 'order') {
                    $Orderby = 'Order by comments.id '.$_GET[$key];
                }
            } 
        }

        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(comments.id) as total 
            FROM `comments` 
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT comments.*,
            users.username,
            users.avatar,
            posts.title as post_title,
            posts.title_sub,
            posts.image,
            posts.type,
            posts_episode.title_number,
            posts_season.name
            FROM `comments`  
            LEFT JOIN users ON comments.user_id = users.id AND comments.user_id IS NOT NULL
            LEFT JOIN posts ON comments.post_id = posts.id AND (comments.type = "post" OR comments.type = "episode")
            LEFT JOIN posts_episode ON comments.post_id = posts_episode.id AND comments.type = "episode" AND comments.post_id IS NOT NULL 
            LEFT JOIN posts_season ON posts_episode.season_id = posts_season.id AND posts_episode.season_id IS NOT NULL 
            LEFT JOIN discussions ON comments.post_id = discussions.id AND comments.type = "discussion" AND comments.post_id IS NOT NULL 
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : '').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/comments'.(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');
 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination); 
        $this->setVariable('Config', $Config);  
 

        $this->view("comments", "admin");
    }
}