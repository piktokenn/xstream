<?php
/**
 * Peoples Controller
 */
class Peoples extends Controller
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
        if(isset($_GET['sort']) AND $_GET['sort'] == $this->translate('popular')) {
            $Selected['sorting'] = $this->translate('Most popular');
            $OrderBy = 'ORDER BY peoples.view DESC';
        } else {
            $Selected['sorting'] = $this->translate('Newest');
            $OrderBy = 'ORDER BY peoples.id DESC';
        } 
        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(peoples.id) as total 
            FROM `peoples`')
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT 
            peoples.*,
            (SELECT 
            COUNT(posts_people.people_id) 
            FROM posts_people 
            WHERE people_id = peoples.id) AS acting
            FROM `peoples`  
            '.(isset($_GET['sort']) ? 'ORDER BY acting DESC' : 'ORDER BY peoples.id DESC').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/'.$this->translate('peoples').(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

        

        $new    = array(isset($Selected['sorting']) ? $Selected['sorting'].' ' : null);
        $old    = array('[sort]');
        
        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.peoples_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.peoples_description','seo'))));

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination);  

        $this->view("peoples", "app");
    }

}