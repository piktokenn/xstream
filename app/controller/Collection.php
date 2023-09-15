<?php
/**
 * Collection Controller
 */
class Collection extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

 
        if (isset($Route->params->id)) {
            $Listing = $this->db->from(null,'
                SELECT 
                collections.*,
                users.username,
                users.firstname,
                users.avatar,
                users.color,
                (SELECT 
                COUNT(collections_post.post_id) 
                FROM collections_post 
                WHERE collection_id = collections.id) AS total
                FROM `collections`
                LEFT JOIN users ON collections.user_id = users.id AND collections.user_id IS NOT NULL
                WHERE collections.id = "'.$Route->params->id.'"')
            ->first();

            $Posts = $this->db->from(null,'
                SELECT 
                    posts.id, 
                    posts.title,  
                    posts.title_sub,  
                    posts.self, 
                    posts.overview,  
                    posts.image, 
                    posts.type,
                    posts.upcoming,
                    posts.release_date,
                    posts.vote_average, 
                    collections_post.id as collection_post_id, 
                    genres.name as name,
                    genres.self as genre_self
                FROM `collections_post` 
                LEFT JOIN posts ON posts.id = collections_post.post_id  
                LEFT JOIN (
                      SELECT
                        post_id, 
                        genre_id 
                      FROM `posts_genre`   
                      GROUP BY posts_genre.post_id
                      ORDER BY posts_genre.genre_id DESC
                    ) posts_genre ON posts.id = posts_genre.post_id
                LEFT JOIN genres ON genres.id = posts_genre.genre_id
                WHERE posts.status = "1" AND collections_post.collection_id = '.$Listing['id'].'
                ORDER BY collections_post.id DESC
                LIMIT 0,100')
            ->all();
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }
        }
         

        $Config['title']        = get($Settings,'data.collection_title','seo');
        $Config['description']  = get($Settings,'data.collection_description','seo');
        $Config['url']          = thread($Listing['id'],$Listing['self']);
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'collection';

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing);  
        $this->setVariable('Posts', $Posts); 

        if (isset($Route->params->id)) {
            if(isset($_GET['_ACTION']) AND $_GET['_ACTION'] == 'edit' AND (isset($AuthUser['id']) AND $AuthUser['id'] != $Listing['user_id'] OR  empty($AuthUser['id']))) {
                header('location:'.APP.'/404');
            } elseif(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'save' AND isset($AuthUser['id']) AND $AuthUser['id'] == $Listing['user_id']) {
                $this->update();
            }
        }

        $this->view("collection", "app");
    }
    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {

            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "privacy"           => Input::cleaner($_POST['privacy'],'0')
            );   
            $this->db->update('collections')->where('id',$Listing['id'])->set($dataarray);
 

            // Collection    
            foreach ($_POST['collection'] as $Key => $Value) {
                $Collection    = $this->db->from('collections_post')->where('id',$Value)->first();
                if(isset($Collection['id'])) {
                    $this->db->delete('collections_post')->where('id',$Collection['id'],'=')->done();
                }
            }


            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".collection($Listing['id'],$Listing['self']));
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }

}