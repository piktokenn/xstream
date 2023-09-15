<?php
/**
 * Settings Controller
 */
class Settings extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['nav']      = 'settings';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Settings');

        $TabNav = array(
            'general'   =>  $this->translate('General'),
            'customize' =>  $this->translate('Customize'),
            'seo'       =>  $this->translate('SEO'),
            'email'     =>  $this->translate('Email'),
            'api'       =>  $this->translate('Api')
        ); 

        $SeoNav = array(
            'main'      =>  $this->translate('Main'),
            'movie'     =>  $this->translate('Movie'),
            'series'    =>  $this->translate('TV Show'),
            'category'  =>  $this->translate('Category'),
            'people'    =>  $this->translate('People')
        ); 


        $Languages      = $this->db->from('languages')->orderby('name','ASC')->all();
        $Modules        = $this->db->from('modules')->where('page','home')->orderby('sortable','ASC')->all();

        $this->setVariable("Config", $Config);  
        $this->setVariable("TabNav", $TabNav);  
        $this->setVariable("SeoNav", $SeoNav);  
        $this->setVariable("Languages", $Languages); 
        $this->setVariable("Modules", $Modules); 

        if(isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == 'save') {
            $this->save();
        } 

        $this->view("settings", "admin");
    }
    public function save() { 
        $Settings              = $this->getVariable("Settings");
        if (empty($Notify)) { 

            
            foreach ($_POST['data'] as $key => $value) { 
                if($value) { 
                    if($key == 'footer_text') {
                        $SettingsJson['data'][$key] = htmlspecialchars(Input::cleaner($value));
                    }else{
                        $SettingsJson['data'][$key] = $value;
                    }
                }
            } 


            $foo = new \Verot\Upload\Upload($_FILES['logo']);
            if ($foo->uploaded) {

                unlink(ROOTPATH.'/public/static/'.get($Settings,'data.logo','general'));
                $foo->allowed               = array('image/*');
                $foo->file_auto_rename      = true;
                $foo->file_new_name_body    = 'logo';
                $foo->jpeg_quality          = 100;
                $foo->Process(ROOTPATH.'/public/static/');
                if ($foo->processed) {
                    $SettingsJson['data']['general']['logo'] = $foo->file_dst_name;
                }
            }else{
                $SettingsJson['data']['general']['logo'] = get($Settings,'data.logo','general');
            }

            $foo = new \Verot\Upload\Upload($_FILES['favicon']);
            if ($foo->uploaded) {

                unlink(ROOTPATH.'/public/static/'.get($Settings,'data.favicon','general'));
                $foo->allowed               = array('image/*');
                $foo->file_auto_rename      = true;
                $foo->file_new_name_body    = 'favicon';
                $foo->jpeg_quality          = 100;
                $foo->Process(ROOTPATH.'/public/static/');
                if ($foo->processed) {
                    $SettingsJson['data']['general']['favicon'] = $foo->file_dst_name;
                }

            }else{
                $SettingsJson['data']['general']['favicon'] = get($Settings,'data.favicon','general');
            }

            foreach ($SettingsJson['data'] as $key => $value) {  
                $Setting   = $this->db->from('settings')->where('name',$key)->first();
                if(isset($Setting['id'])) {

                    $dataarray          = array(
                        "name"          => Input::cleaner($key),
                        "data"          => json_encode($SettingsJson['data'][$key],JSON_UNESCAPED_UNICODE)
                    );
                    $this->db->update('settings')->where('name',$key)->set($dataarray);  

                } elseif(empty($Setting['id'])) {

                    $dataarray          = array(
                        "name"          => Input::cleaner($key),
                        "data"          => json_encode($SettingsJson['data'][$key],JSON_UNESCAPED_UNICODE)
                    );
                    $this->db->insert('settings')->set($dataarray);  

                }
            }

            foreach ($_POST['module'] as $Module) {  
                $dataarray          = array(
                    "name"              => Input::cleaner($Module['name']),
                    "data"              => json_encode($Module['data'],JSON_UNESCAPED_UNICODE),
                    "data_limit"        => Input::cleaner($Module['data_limit'],0),
                    "sortable"          => Input::cleaner($Module['sortable']),
                    "status"            => Input::cleaner($Module['status'],2)
                );
                $this->db->update('modules')->where('id',$Module['id'])->set($dataarray);  
            }
            removefolder(PATH.'/cache');
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/settings');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}