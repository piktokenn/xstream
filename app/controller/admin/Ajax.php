<?php
/**
 * Ajax Controller
 */
class Ajax extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        $this->{$Route->params->ajax}();
    }

    public function upload() {   
            
        $ImageName = randomcode();
        $image      = uploader($_FILES['file'],$ImageName,UPLOADPATH.'/'.MEDIA_FOLDER.'/',MEDIA_X,'png');
        uploader($_FILES['file'],$ImageName,UPLOADPATH.'/'.MEDIA_FOLDER.'/',MEDIA_X,'webp');
        uploader($_FILES['file'],'thumb-'.$ImageName,UPLOADPATH.'/'.MEDIA_FOLDER.'/',MEDIA_THUMB_X.','.MEDIA_THUMB_Y,'png');
        uploader($_FILES['file'],'thumb-'.$ImageName,UPLOADPATH.'/'.MEDIA_FOLDER.'/',MEDIA_THUMB_X.','.MEDIA_THUMB_Y,'webp');
            
        echo json_encode(array(
                'file_name' => $image,
                'file_path' => UPLOADPATH.'/'.MEDIA_FOLDER.'/'.$image
        ));
    }
    public function seasons() {
        $Route      = $this->getVariable("Route");  
        if($_POST['id']) {
            $Listings = $this->db->from(null,'
                SELECT *
                FROM `posts_season`   
                WHERE post_id = '.$_POST['id'].'
                ORDER BY sortable ASC')
                ->all();
            $seasons = null;
            foreach ($Listings as $Listing) {
                $seasons[] = [
                    'id'            => $Listing['id'],
                    'name'          => $Listing['name']
                ];  
            } 
        }
        echo json_encode(array(
            "data"   => $seasons
        ));
    }
    public function peoples() {
        $Route      = $this->getVariable("Route");  
        if($_GET['q']) {
            $Listings = $this->db->from(null,'
                SELECT *
                FROM `peoples`   
                WHERE name LIKE "%'.$_GET['q'].'%"
                ORDER BY id DESC
                LIMIT 0,4')
                ->all();
            $posts = null;
            foreach ($Listings as $Listing) {
                $posts[] = [
                    'id'            => $Listing['id'],
                    'name'          => $Listing['name'],
                    'department'    => $Listing['department'],
                    'image'         => UPLOAD.'/'.PEOPLE_FOLDER.'/'.$Listing['image']
                ];  
            } 
        }
        echo json_encode(array(
            "data"   => $posts
        ));
    }
    public function people() {
        $Route      = $this->getVariable("Route"); 
        if($_GET['id']) {
            $Listing = $this->db->from(null,'
                SELECT *
                FROM `peoples`   
                WHERE peoples.id = '.$_GET['id'])
                ->first();  

            $result[] = [
                'id'                => $Listing['id'],  
                'api'               => false,
                'name'              => $Listing['name'],
                'department'        => $Listing['department'],
                'image'             => UPLOAD.'/'.PEOPLE_FOLDER.'/'.$Listing['image']
            ];  
          
        }
        echo json_encode(array( 
            "data"      => $result
        ));
    }

    public function posts() {
        $Route      = $this->getVariable("Route");  
        if($_GET['q']) {
            $Listings = $this->db->from(null,'
                SELECT *
                FROM `posts`   
                WHERE title LIKE "%'.$_GET['q'].'%"
                ORDER BY id DESC
                LIMIT 0,4')
                ->all();
            $posts = null;
            foreach ($Listings as $Listing) {
                $posts[] = [
                    'id'            => $Listing['id'],
                    'title'         => $Listing['title'], 
                    'type'          => $Listing['type'], 
                    'image'         => UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image']
                ];  
            } 
        }
        echo json_encode(array(
            "data"   => $posts
        ));
    }
    public function post() {
        $Route      = $this->getVariable("Route"); 
        if($_GET['id']) {
            $Listing = $this->db->from(null,'
                SELECT *
                FROM `posts`   
                WHERE posts.id = '.$_GET['id'])
                ->first();  

            $result = [
                'id'                => $Listing['id'],   
                'type'              => $Listing['type'], 
                'title'             => $Listing['title'], 
                'overview'          => $Listing['overview'], 
                'image'             => UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image']
            ];  
          
        }
        echo json_encode(array( 
            "data"      => $result
        ));
    }
}