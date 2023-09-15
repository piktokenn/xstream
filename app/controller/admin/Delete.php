<?php
/**
 * Delete Controller
 */
class Delete extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        $this->{$Route->params->page}();
    }

    public function movie() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['image']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['image']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));

            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['cover']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['cover']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['cover']));
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['cover']));

            $this->db->delete('posts')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_people')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_genre')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_media')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_subtitle')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_video')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_log')->where('post_id',$Listing['id'],'=')->done(); 
            header("location: ".APP.'/admin/movies');
        } else {
            header("location: ".APP.'/admin/movies');
        }
    }

    public function serie() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['image']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['image']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));

            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['cover']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['cover']);
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['cover']));
            unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['cover']));

            $this->db->delete('posts')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_people')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_genre')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_media')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_subtitle')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_video')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_episode')->where('post_id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_log')->where('post_id',$Listing['id'],'=')->done(); 
            header("location: ".APP.'/admin/series');
        } else {
            header("location: ".APP.'/admin/series');
        }
    }

    public function episode() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts_episode')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) { 
            $this->db->delete('posts_episode')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_log')->where('episode_id',$Listing['id'],'=')->done(); 
            header("location: ".APP.'/admin/episodes');
        } else {
            header("location: ".APP.'/admin/episodes');
        }
    }

    public function people() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('peoples')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/'.$Listing['image']);
            unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/thumb-'.$Listing['image']);
            unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
            unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));
            $this->db->delete('peoples')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_people')->where('id',$Listing['id'],'=')->done(); 
            header("location: ".APP.'/admin/peoples');
        } else {
            header("location: ".APP.'/admin/peoples');
        }
    }

    public function platform() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('platforms')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            unlink(UPLOADPATH . '/'.PLATFORM_FOLDER.'/'.$Listing['image']);
            unlink(UPLOADPATH . '/'.PLATFORM_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));   
            $this->db->update('posts')->where('platform_id',$Listing['id'])->set(array("platform" => null));
            $this->db->delete('platforms')->where('id',$Listing['id'],'=')->done();  
            header("location: ".APP.'/admin/platforms');
        } else {
            header("location: ".APP.'/admin/platforms');
        }
    }

    public function genre() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('genres')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            unlink(UPLOADPATH . '/icon/'.$Listing['icon']);
            $this->db->delete('genres')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('posts_genre')->where('genre_id',$Listing['id'],'=')->done(); 
            header("location: ".APP.'/admin/genres');
        } else {
            header("location: ".APP.'/admin/genres');
        }
    }
    
    public function report() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('reports')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('reports')->where('id',$Listing['id'],'=')->done();  
            header("location: ".APP.'/admin/reports');
        } else {
            header("location: ".APP.'/admin/reports');
        }
    }

    public function collections() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('collections')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('collections')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('collections_post')->where('collection_id',$Listing['id'],'=')->done();
            header("location: ".APP.'/admin/collections');
        } else {
            header("location: ".APP.'/admin/collections');
        }
    }

    public function comment() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('comments')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('comments')->where('id',$Listing['id'],'=')->done(); 
            $this->db->delete('comments_reaction')->where('comment',$Listing['id'],'=')->done();
            header("location: ".APP.'/admin/comments');
        } else {
            header("location: ".APP.'/admin/comments');
        }
    }

    public function page() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('pages')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('pages')->where('id',$Listing['id'],'=')->done();  
            header("location: ".APP.'/admin/pages');
        } else {
            header("location: ".APP.'/admin/pages');
        }
    }

    public function language() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('languages')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('languages')->where('id',$Listing['id'],'=')->done();  
            header("location: ".APP.'/admin/languages');
        } else {
            header("location: ".APP.'/admin/languages');
        }
    }
    
    public function country() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('countries')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('countries')->where('id',$Listing['id'],'=')->done();  
            header("location: ".APP.'/admin/countries');
        } else {
            header("location: ".APP.'/admin/countries');
        }
    }
    
    public function collection() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('collections_post')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('collections_post')->where('id',$Listing['id'],'=')->done();
        }
    }

    public function subtitle() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts_subtitle')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('posts_subtitle')->where('id',$Listing['id'],'=')->done();
        }
    }


    public function cast() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts_people')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('posts_people')->where('id',$Listing['id'],'=')->done(); 
        } 
    }


    public function media() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts_media')->where('id',$Route->params->id)->first();

        unlink(UPLOADPATH . '/'.MEDIA_FOLDER.'/'.$Listing['image']);
        unlink(UPLOADPATH . '/'.MEDIA_FOLDER.'/thumb-'.$Listing['image']);
        unlink(UPLOADPATH . '/'.MEDIA_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
        unlink(UPLOADPATH . '/'.MEDIA_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));
        if(isset($Listing['id'])) {
            $this->db->delete('posts_media')->where('id',$Listing['id'],'=')->done(); 
        } 
    }


    public function video() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts_video')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('posts_video')->where('id',$Listing['id'],'=')->done(); 
        } 
    }

    public function season() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('posts_season')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('posts_season')->where('id',$Listing['id'],'=')->done(); 
        } 
    }

    public function option() {   
        $Route      = $this->getVariable("Route");
        $Listing    = $this->db->from('options')->where('id',$Route->params->id)->first();
        if(isset($Listing['id'])) {
            $this->db->delete('options')->where('id',$Listing['id'],'=')->done();  
            header("location: ".APP.'/admin/options');
        } else {
            header("location: ".APP.'/admin/options');
        }
    }
}