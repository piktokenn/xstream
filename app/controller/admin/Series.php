<?php
/**
 * Series Controller
 */
class Series extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

        $AuthUser       = $this->getVariable("AuthUser");
        $Route          = $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'serie';
        $Config['nav']      = 'series';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Series');


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
           header("location: ".APP.'/admin/'.$Config['nav'].$FilterSlug); 
        }

        $Filter = array (
            'type'      => 'filter',
            'q'         => 'search',
            'status'    => 'filter',
            'genre'     => 'join',
            'sorting'   => 'order'
        );

        $Where          = 'WHERE posts.type = "serie" AND ';
        $CategoryWhere  = null;
        $Orderby        = null;
        foreach($Filter as $key => $value) {
            if (isset($_GET[$key])) {
                if ($i == 0) {
                    $FilterSlug .= '?'.$key.'='.$_GET[$key];
                } else {
                    $FilterSlug .= '&'.$key.'='.$_GET[$key];
                }

                $i++;

                if($value == 'filter') {
                    $Where .= 'posts.'.$key.' = "'.$_GET[$key].'" AND '; 
                } elseif ($value == 'join') {
                    $Where          .= 'posts_genre.genre_id = '.$_GET['genre'].' AND'; 
                    $CategoryWhere  = ' WHERE genre_id = '.$_GET['genre'].' ';
                } elseif ($value == 'search') {
                    $Where .= 'posts.title LIKE "%'.$_GET[$key].'%" AND ';
                } elseif ($value == 'order') {
                    $Orderby = 'Order by posts.id '.$_GET[$key];
                }
            } 
        }

        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(posts.id) as total 
            FROM `posts` 
            LEFT JOIN (
                  SELECT
                    post_id, 
                    genre_id 
                  FROM `posts_genre`   
                  '.$CategoryWhere.' 
                  GROUP BY posts_genre.post_id
                  ORDER BY posts_genre.genre_id DESC
                ) posts_genre ON posts.id = posts_genre.post_id
            LEFT JOIN genres ON genres.id = posts_genre.genre_id
            '.(isset($Where) ? rtrim($Where,' AND ') : ''))
            ->total(); 
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        $Listings = $this->db->from(null,'
            SELECT posts.*
            FROM `posts`  
            LEFT JOIN (
                  SELECT
                    post_id, 
                    genre_id 
                  FROM `posts_genre`   
                  '.$CategoryWhere.' 
                  GROUP BY posts_genre.post_id
                  ORDER BY posts_genre.genre_id DESC
                ) posts_genre ON posts.id = posts_genre.post_id
            LEFT JOIN genres ON genres.id = posts_genre.genre_id
            '.(isset($Where) ? rtrim($Where,' AND ') : '').'
            '.(isset($Orderby) ? $Orderby : 'ORDER BY posts.id DESC').'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $Pagination         = $this->db->showPagination(APP.'/admin/'.$Config['nav'].(isset($FilterSlug) ? $FilterSlug : '?').'page=[page]');

  
        $Genres = $this->db->from('genres')->orderby('name','ASC')->all();

        $this->setVariable('Listings', $Listings); 
        $this->setVariable('Pagination', $Pagination); 
        $this->setVariable('Genres', $Genres); 
        $this->setVariable('Config', $Config); 

        $this->view("posts", "admin");
    }
}