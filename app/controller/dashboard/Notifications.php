<?php
/**
 * Notifications Controller
 */
class Notifications extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Notifications');
        $Config['description']  = get($Settings,'data.description','seo');  
        $Config['disabled']     = 'on';
 
        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(notifications.id) as total 
            FROM `notifications` 
            WHERE notifications.user_id = '.$AuthUser['id'])
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT 
                notifications.*,  
                posts.title,  
                posts.type as post_type,  
                posts.self,  
                users.avatar,
                users.color,
                users.username,
                n_user.username as n_username
            FROM `notifications` 
            LEFT JOIN users ON users.id = notifications.action_user
            LEFT JOIN posts ON posts.id = notifications.action_id AND notifications.action_id IS NOT NULL AND (notifications.type = "follow" OR notifications.type = "comment")
            LEFT JOIN users as n_user ON n_user.id = notifications.action_id AND notifications.action_id IS NOT NULL AND notifications.type = "follow"
            WHERE notifications.user_id ='.$AuthUser['id'].'
            ORDER BY notifications.id DESC
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/dashboard/'.$this->translate('notifications').(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('TotalRecord', $TotalRecord);  
        $this->view("notifications", "dashboard");
    }

}