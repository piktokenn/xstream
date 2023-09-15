<?php
/**
 * Requests Controller
 */
class Requests extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'request';
        $Config['nav']      = 'requests';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Requests');

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
           header("location: ".APP.'/admin/requests'.$FilterSlug);
            
        }

        $Filter = array (
            'q'             => 'search',
            'sorting'       => 'order'
        );
  
        // Query 
        $TotalRecord    = $this->db->from(null,'
            SELECT 
            COUNT(DISTINCT tmdb_id) AS total
            FROM `requests`')
            ->total(); 


        $LimitPage      = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
        $Listings       = $this->db->from(null,'
            SELECT *
            FROM `requests` 
            GROUP BY tmdb_id
            ORDER BY requests.id DESC
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/requests'.(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('Config', $Config);  
 

        $this->view("requests", "admin");
    }
}