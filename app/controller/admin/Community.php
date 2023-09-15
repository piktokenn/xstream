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
 
        // Config
        $Config['btn']      = 'thread';
        $Config['nav']      = 'community';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Community');

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
           header("location: ".APP.'/admin/community'.$FilterSlug);
            
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
                    $Where .= 'discussions.'.$key.' = "'.$_GET[$key].'" AND '; 
                } elseif ($value == 'search') {
                    $Where .= 'discussions.title LIKE "%'.$_GET[$key].'%" AND ';
                } elseif ($value == 'order') {
                    $Orderby = 'Order by discussions.id '.$_GET[$key];
                }
            } 
        }
        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(discussions.id) as total 
            FROM `discussions` '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT discussions.*
            FROM `discussions`  
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : '').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/community'.(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('Config', $Config);  
 

        $this->view("community", "admin");
    }
}