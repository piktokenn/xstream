<?php
/**
 * Users Controller
 */
class Users extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'user';
        $Config['nav']      = 'users';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Users');


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
           header("location: ".APP.'/admin/users'.$FilterSlug);
            
        }

        $Filter = array (
            'department'    => 'filter',
            'gender'        => 'filter',
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
                    $Where .= 'users.'.$key.' = "'.$_GET[$key].'" AND '; 
                } elseif ($value == 'search') {
                    $Where .= 'users.username LIKE "%'.$_GET[$key].'%" AND ';
                } elseif ($value == 'order') {
                    $Orderby = 'Order by users.id '.$_GET[$key];
                }
            } 
        }

        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(users.id) as total 
            FROM `users` 
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT users.*
            FROM `users`  
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : '').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/users'.(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

        $Total['all']       = $this->db->from(null,'SELECT count(users.id) as total FROM `users`')->total(); 
        $Total['acting']    = $this->db->from(null,'SELECT count(users.id) as total FROM `users`')->total(); 
        $Total['director']  = $this->db->from(null,'SELECT count(users.id) as total FROM `users`')->total(); 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination); 
        $this->setVariable('Total', $Total); 
        $this->setVariable('Config', $Config);  
 

        $this->view("users", "admin");
    }
}