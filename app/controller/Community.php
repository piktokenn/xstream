<?php
/**
 * Community Controller
 */
class Community extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Selected = null;
        // Orderby
        if(isset($Route->params->sort) AND $Route->params->sort == $this->translate('popular')) {
            $Selected['sorting'] = $this->translate('Most popular');
            $OrderBy = 'ORDER BY discussions.view DESC';
        } else {
            $Selected['sorting'] = $this->translate('Newest');
            $OrderBy = 'ORDER BY discussions.id DESC';
        } 

        $new    = array(isset($Selected['sorting']) ? $Selected['sorting'].' ' : null);
        $old    = array('[sort]');
        
        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.community_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.community_description','seo'))));
        $Config['page']         = $this->translate('Community');

        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(discussions.id) as total 
            FROM `discussions` 
            WHERE discussions.status = 1')
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT 
            discussions.*,
            users.username,
            users.avatar,
            users.firstname,
            users.color,
            (SELECT 
            COUNT(comments.post_id) 
            FROM comments 
            WHERE comments.type = "discussion" AND post_id = discussions.id) AS reply
            FROM `discussions`  
            LEFT JOIN users ON discussions.user_id = users.id AND discussions.user_id IS NOT NULL
            WHERE discussions.status = 1
            '.(isset($Route->params->sort) ? 'ORDER BY reply DESC' : 'ORDER BY discussions.id DESC').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/'.$this->translate('community').(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

        $Users = $this->db->from('users')->orderby('xp','DESC')->limit(0,10)->all();

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('Users', $Users);  
        if(isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == 'thread' AND isset($AuthUser['id'])) {
            $this->thread();
        } 

        $this->view("community", "app");
    }

    /**
     * thread
     */
    public function thread() { 
        $AuthUser       = $this->getVariable("AuthUser");     
        $Settings       = $this->getVariable("Settings");     
        if (empty($Notify)) { 
            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['title']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "title"             => Input::cleaner($_POST['title']),
                "self"              => $self,
                "description"       => Input::cleaner($_POST['description']),
                "user_id"           => $AuthUser['id'],
                "status"            => get($Settings,'data.discussions','general') == 1 ? 2 : 1,
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('discussions')->set($dataarray); 

            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            header('location:'.thread($this->db->lastId(),$self));
            $this->notify($Notify);
        } else {
            $this->notify($Notify);
        }
    }
}