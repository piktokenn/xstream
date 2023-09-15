<?php
/**
 * Pages Controller
 */
class Pages extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'page';
        $Config['nav']      = 'settings';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Pages');

        // Filter
        $i              = 0;
        $FilterSlug     = null;

        $Listings = $this->db->from(null,'
            SELECT pages.*
            FROM `pages`')
            ->all();

 
  
        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Config', $Config);  
 

        $this->view("pages", "admin");
    }
}