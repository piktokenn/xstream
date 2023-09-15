<?php
/**
 * Platforms Controller
 */
class Platforms extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");
        $isValid        = $this->getVariable("isValid");

        $Config['title']        = get($Settings,'data.platforms_title','seo');
        $Config['description']  = get($Settings,'data.platforms_description','seo');
        $Config['cache']        = 'true';

        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(platforms.id) as total 
            FROM `platforms` 
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT 
            platforms.*,
            (SELECT 
            COUNT(posts.platform) 
            FROM posts
            WHERE platform = platforms.id) AS posts
            FROM `platforms`  
            '.(isset($Where) ? 'Where '.rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : 'ORDER BY platforms.id DESC').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/'.$this->translate('platforms').(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');
 
        $this->setVariable("Config", $Config);   
        $this->setVariable("Listings", $Listings);   
        $this->setVariable("Pagination", $Pagination);   

        $this->view("platforms", "app");
    }
}