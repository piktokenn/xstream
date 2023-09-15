<?php
/**
 * Report Controller
 */
class Report extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config 
        $Config['nav']  = 'reports';

        if (isset($Route->params->id)) {
            $Listing = $this->db->from(null,'
            SELECT 
            reports.id,
            reports.report,
            reports.report_id,
            reports.body,
            reports.created,
            reports.status,
            reports.type,
            posts.title,
            posts.title_sub,
            posts.image,
            posts_season.name as season_name,
            posts_episode.title_number,
            p.title as serie_title,
            p.title_sub as serie_titlesub,
            p.image as serie_image
            FROM `reports`
            LEFT JOIN posts ON reports.report_id = posts.id AND reports.type = "movie" AND reports.report_id IS NOT NULL 
            LEFT JOIN posts_episode ON reports.report_id = posts_episode.id AND reports.type = "episode" AND reports.report_id IS NOT NULL 
            LEFT JOIN posts_season ON posts_episode.season_id = posts_season.id
            LEFT JOIN posts as p ON posts_episode.post_id = p.id AND reports.type = "episode" AND reports.report_id IS NOT NULL 
            WHERE reports.id = "'.$Route->params->id.'"')
            ->first();
        } else {
            header('location:'.APP.'/admin/reports');
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("report", "admin");
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {
            $dataarray          = array(
                "status"          => (int)Input::cleaner($_POST['status'],'2')
            );   
            $this->db->update('reports')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/reports');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}