<?php
/**
 * Episodes Controller
 */
class Episodes extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'episode';
        $Config['nav']      = 'series';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Episodes');

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
           header("location: ".APP.'/admin/episodes'.$FilterSlug);
            
        }

        $Filter = array (
            'q'             => 'search',
            'sorting'       => 'order'
        );

        $Where      = null;
        $Orderby    = null;
        $FilterSlug = null;
        foreach($Filter as $key => $value) {
            if (isset($_GET[$key])) {
                if ($i == 0) {
                    $FilterSlug .= '?'.$key.'='.$_GET[$key];
                } else {
                    $FilterSlug .= '&'.$key.'='.$_GET[$key];
                }
                $i++;
                if($value == 'filter') {
                    $Where .= 'posts_episode.'.$key.' = "'.$_GET[$key].'" AND '; 
                } elseif ($value == 'search') {
                    $Where .= 'posts_episode.name LIKE "%'.$_GET[$key].'%" AND ';
                } elseif ($value == 'order') {
                    $Orderby = 'Order by posts_episode.id '.$_GET[$key];
                }
            } 
        }
        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(posts_episode.id) as total 
            FROM `posts_episode` '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT posts_episode.*,
            posts.title as post_title,
            posts.image as post_image,
            posts_season.name
            FROM `posts_episode`   
            LEFT JOIN posts ON posts_episode.post_id = posts.id AND posts_episode.post_id IS NOT NULL 
            LEFT JOIN posts_season ON posts_season.id = posts_episode.season_id AND posts_episode.season_id IS NOT NULL 
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : '').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/genres'.(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');


        $Total['all']       = $this->db->from(null,'SELECT count(posts_episode.id) as total FROM `posts_episode`')->total(); 
        $Total['publish']   = $this->db->from(null,'SELECT count(posts_episode.id) as total FROM `posts_episode` WHERE posts_episode.status = 1')->total(); 
        $Total['disable']   = $this->db->from(null,'SELECT count(posts_episode.id) as total FROM `posts_episode` WHERE posts_episode.status = 2')->total(); 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination); 
        $this->setVariable('Total', $Total); 
        $this->setVariable('Config', $Config);  
 

        $this->view("episodes", "admin");
    }
}