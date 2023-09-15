<?php
/**
 * Ads Controller
 */
class Ads extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'ad';
        $Config['nav']      = 'settings';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Ads');

        // Filter 

        $Where      = null;
        $Orderby    = null;
        $FilterSlug = null;
        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(ads.id) as total 
            FROM `ads` '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT ads.*
            FROM `ads`  
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : '').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/ads'.(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('Config', $Config);  
 

        $this->view("ads", "admin");
    }
}