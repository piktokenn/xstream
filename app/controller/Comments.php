<?php
/**
 * Comments Controller
 */
class Comments extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        $Settings   = $this->getVariable("Settings");
        if(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'comments') {
            $this->getcomments();
        } elseif(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'post') {
            $this->comment();
        } elseif(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'vote') {
            $this->vote();
        } elseif(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'update') {
            $this->comment();
        }
    }


    public function getcomments() {  
        $AuthUser   = $this->getVariable("AuthUser");
        $Settings   = $this->getVariable("Settings");

        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");

        $Page = Input::cleaner($_GET['page']); 
        $Sort = Input::cleaner($_GET['sort']); 

        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(comments.id) as total 
            FROM `comments`
            WHERE comments.parent_id = "0" AND comments.post_id = "'.Input::cleaner($_GET['post_id']).'" AND comments.status = "1" AND comments.type = "'.Input::cleaner($_GET['type']).'"')
            ->total();
        if($Sort == 1) {
            $Order = 'comments.created DESC';
        }elseif($Sort == 2) {
            $Order = 'likes DESC';
        }elseif($Sort == 3) {
            $Order = 'comments.created ASC';
        }else{
            $Order = 'comments.created DESC';
        }
        $LimitPage  = $this->db->pagination($TotalRecord, COMMENT_LIMIT,'page');  
        $Comments   = $this->db->from(null,'
            SELECT 
            comments.id,
            comments.comment,
            comments.post_id,
            comments.created,
            comments.status,
            comments.parent_id,
            comments.user_id,
            comments.spoiler,
            comments.created,
            u.username,
            u.avatar,
            u.color,
            u.email,
            u.username,
            (SELECT 
            COUNT(comments_reaction.comment_id) 
            FROM comments_reaction 
            WHERE comments_reaction.reaction = "up" AND comment_id = comments.id) AS likes, 
            (SELECT 
            COUNT(comments_reaction.comment_id) 
            FROM comments_reaction 
            WHERE comments_reaction.reaction = "down" AND comment_id = comments.id) AS dislikes
            FROM `comments`  
            LEFT JOIN users AS u ON comments.user_id = u.id AND comments.user_id IS NOT NULL
            WHERE comments.parent_id = "0" AND comments.post_id = "'.Input::cleaner($_GET['post_id']).'" AND comments.status = "1" AND comments.type = "'.Input::cleaner($_GET['type']).'"
            ORDER BY '.$Order.'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all();
        $commentsArray = array();
        foreach ($Comments as $Comment) {  

            if(isset($AuthUser['id'])) {
                $Vote = $this->db->from('comments_reaction')->where('user_id',$AuthUser['id'])->where('comment_id',$Comment['id'])->first();
            }


            $commentsArray[] = [
                'id'            => $Comment['id'],
                'comment'       => $Comment['comment'],
                'parent_id'     => $Comment['parent_id'],
                'likes'         => $Comment['likes'],
                'dislikes'      => $Comment['dislikes'],
                'voted'         => (isset($Vote['id']) ? $Vote['reaction'] : null),
                'edit'          => (isset($AuthUser['id']) AND $AuthUser['id'] == $Comment['user_id'] ? true : null),
                'author'        => array(
                    'name'      => $Comment['username'],
                    'email'     => $Comment['email'],
                    'avatar'    => gravatar($Comment['user_id'],$Comment['username'],$Comment['avatar'],'avatar rounded-circle text-white fs-sm',$Comment['color']),
                    'url'       => user($Comment['user_id'],$Comment['username']),
                ),
                'spoiler'       => $Comment['spoiler'],
                'created'       => timeago($Comment['created']),
                'status'        => $Comment['status'],
                'replies'       => $this->getreplies($Comment['id'])
            ]; 
        } 
        $pagination = [
            'total'                     => $TotalRecord,
            'per_page'                  => (int)$LimitPage['limit'],
            'current_page'              => (int)$Page,
            'last_page'                 => $LimitPage['page_count'],
            'next_page'                 => ($Page + 1 < $LimitPage['page_count'] ? $Page + 1 : $LimitPage['page_count']),
            'prev_page'                 => ($Page - 1 > 0 ? $Page - 1 : 1),
            'first_adjacent_page'       => 1,
            'last_adjacent_page'        => ceil($TotalRecord / COMMENT_LIMIT),
        ];
      
        echo json_encode(array(
            "total"         => $TotalRecord,
            "comments"      => $commentsArray,
            "pagination"    => $pagination
        ));
    }

    public function getreplies($comment_id = null) {  
        $AuthUser   = $this->getVariable("AuthUser"); 
        $Settings   = $this->getVariable("Settings");
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(comments.id) as total 
            FROM `comments`
            WHERE comments.parent_id = "'.$comment_id.'" AND comments.status = "1"')
            ->total();
   
        $Comments   = $this->db->from(null,'
            SELECT 
            comments.id,
            comments.comment,
            comments.post_id,
            comments.created,
            comments.status,
            comments.parent_id,
            comments.spoiler,
            comments.user_id,
            comments.created,
            u.username,
            u.avatar,
            u.color,
            u.email,
            u.username,
            (SELECT 
            COUNT(comments_reaction.comment_id) 
            FROM comments_reaction 
            WHERE comments_reaction.reaction = "up" AND comment_id = comments.id) AS likes, 
            (SELECT 
            COUNT(comments_reaction.comment_id) 
            FROM comments_reaction 
            WHERE comments_reaction.reaction = "down" AND comment_id = comments.id) AS dislikes
            FROM `comments`  
            LEFT JOIN users AS u ON comments.user_id = u.id AND comments.user_id IS NOT NULL
            WHERE comments.parent_id = '.$comment_id.' AND comments.status = 1
            ORDER BY comments.created ASC')
            ->all();

        $commentsArray = array();
        foreach ($Comments as $Comment) {  

            if($AuthUser['id']) {
                $Vote = $this->db->from('comments_reaction')->where('user_id',$AuthUser['id'])->where('comment_id',$Comment['id'])->first();
            }

            $commentsArray[] = [
                'id'            => $Comment['id'],
                'comment'       => $Comment['comment'],
                'parent_id'     => $Comment['parent_id'],
                'likes'         => $Comment['likes'],
                'dislikes'      => $Comment['dislikes'],
                'voted'         => (isset($Vote['id']) ? $Vote['reaction'] : null),
                'edit'          => ($AuthUser['id'] == $Comment['user_id'] ? true : null),
                'author'        => array(
                    'name'      => $Comment['username'],
                    'email'     => $Comment['email'],
                    'avatar'    => gravatar($Comment['user_id'],$Comment['username'],$Comment['avatar'],'avatar rounded-circle text-white fs-sm',$Comment['color']),
                    'url'       => user($Comment['user_id'],$Comment['username']),
                ),
                'spoiler'       => $Comment['spoiler'],
                'created'       => timeago($Comment['created']),
                'status'        => $Comment['status'],
            ]; 
        } 
        return $commentsArray;
    }


    public function comment() {  
        $AuthUser   = $this->getVariable("AuthUser");
        $Settings   = $this->getVariable("Settings"); 
        if(isset($_POST['id']) AND isset($_POST['comment']) AND isset($AuthUser['id'])) {
            $dataarray          = array(
                "comment"        => htmlspecialchars(Input::cleaner($_POST['comment']))
            );   
            $this->db->update('comments')->where('id',Input::cleaner($_POST['id']))->where('user_id',$AuthUser['id'])->set($dataarray);  
            $Listing = $this->db->from('comments')->where('user_id',$AuthUser['id'])->where('id',Input::cleaner($_POST['id']))->first();
            $comment = [
                'id'            => Input::cleaner($Listing['id']),
                'comment'       => Input::cleaner($Listing['comment']), 
                'parent_id'     => $Listing['parent_id'],
                'likes'         => 0,
                'dislikes'      => 0,
                'voted'         => null,
                'edit'          => true,
                'author'        => array(
                    'name'      => $AuthUser['username'],
                    'email'     => $AuthUser['email'],
                    'avatar'    => gravatar($AuthUser['id'],$AuthUser['username'],$AuthUser['avatar'],'avatar rounded-circle text-white fs-sm',$AuthUser['color']),
                    'url'       => user($AuthUser['id'],$AuthUser['username']),
                ),
                'created'       => timeago($Listing['created']),
                'spoiler'       => isset($_POST['spoiler']) ? 1 : 0,
                'status'        => (get($Settings,'data.comment','general') == 1 ? 2 : 1),
                'replies'       => $this->getreplies($Listing['id'])
            ];  
        }else{

            header('Access-Control-Allow-Origin: *');
            header("Content-type: application/json; charset=utf-8");

            if(empty($_POST['comment']) || Input::cleaner(mb_strlen($_POST['comment'])) < 10) {
                header('X-PHP-Response-Code: 404', true, 404);
                $comment[] = $this->translate('Comment must be at least 10 characters.');
            }else {
                $dataarray          = array(
                    "user_id"        => $AuthUser['id'],
                    "post_id"        => Input::cleaner($_POST['post_id']),
                    "parent_id"      => (int)Input::cleaner($_POST['parent_id'],0),
                    "type"           => Input::cleaner($_POST['type']),
                    "comment"        => Input::cleaner($_POST['comment']),
                    "spoiler"        => isset($_POST['spoiler']) ? 1 : 0,
                    "status"         => (get($Settings,'data.comment','general') == 1 ? 2 : 1),
                    "created"        => date('Y-m-d H:i:s')
                );   
                $this->db->insert('comments')->set($dataarray);   
                if(isset($_POST['parent_id']) AND $_POST['parent_id'] > 0 AND isset($_POST['post_id']) AND Input::cleaner($_POST['type']) == 'post') {
                    $Content = $this->db->from('comments')->where('id',Input::cleaner($_POST['parent_id']))->first();
                    if(isset($Content['user_id']) AND isset($AuthUser['id']) AND $AuthUser['id'] != $Content['user_id']) {
                        $dataarray = array(
                            'user_id'           => $Content['user_id'],
                            'type'              => 'comment',
                            'icon'              => 'comment',
                            'action_id'         => $Content['post_id'],
                            'action_user'       => $AuthUser['id'],
                            'created'           => date('Y-m-d H:i:s'),
                            "status"            => '2'
                        );
                        $this->db->insert('notifications')->set($dataarray);
                    }

                } elseif(isset($_POST['type']) AND empty($_POST['parent_id']) AND Input::cleaner($_POST['type']) == 'discussion') {
                    $Content = $this->db->from('discussions')->where('id',Input::cleaner($_POST['post_id']))->first();
                    if(isset($Content['user_id']) AND isset($AuthUser['id']) AND $AuthUser['id'] != $Content['user_id']) {
                        $dataarray = array(
                            'user_id'           => $Content['user_id'],
                            'type'              => 'discussion',
                            'icon'              => 'comment',
                            'action_id'         => $Content['post_id'],
                            'action_user'       => $AuthUser['id'],
                            'created'           => date('Y-m-d H:i:s'),
                            "status"            => '2'
                        );
                        $this->db->insert('notifications')->set($dataarray);
                    }

                }
                $comment = [
                    'id'            => $this->db->lastId(),
                    'comment'       => Input::cleaner($_POST['comment']), 
                    'parent_id'     => (int)$_POST['parent_id'],
                    'reply'         => (int)$_POST['parent_id'],
                    'likes'         => 0,
                    'dislikes'      => 0,
                    'voted'         => null,
                    'edit'          => true,
                    'author'        => array(
                        'name'      => $AuthUser['username'],
                        'email'     => $AuthUser['email'],
                        'avatar'    => gravatar($AuthUser['id'],$AuthUser['username'],$AuthUser['avatar'],'avatar rounded-circle text-white fs-sm',$AuthUser['color']),
                        'url'       => user($AuthUser['id'],$AuthUser['username']),
                    ),
                    'spoiler'       => isset($_POST['spoiler']) ? 1 : 0,
                    'created'       => timeago(date('Y-m-d H:i:s')),
                    'status'        => (get($Settings,'data.comment','general') == 1 ? 2 : 1),
                ]; 
            }
        }
        echo json_encode($comment);
    }

    public function vote() { 
        $AuthUser   = $this->getVariable("AuthUser");
        if(isset($AuthUser['id'])) {
            $Vote = $this->db->from('comments_reaction')->where('user_id',$AuthUser['id'])->where('comment_id',$_POST['id'])->first();
            if(Input::cleaner($_POST['type']) == '-up' || Input::cleaner($_POST['type']) == '-down') {
                $this->db->delete('comments_reaction')->where('id',$Vote['id'],'=')->done(); 
            } elseif($Vote['id']) {
                $dataarray          = array(
                    "reaction"          => Input::cleaner($_POST['type'])
                );   
                $this->db->update('comments_reaction')->where('id',$Vote['id'])->set($dataarray);  
            } elseif(!$Vote['id']) {
                $dataarray          = array(
                    "user_id"           => $AuthUser['id'],
                    "comment_id"        => Input::cleaner($_POST['id']),
                    "reaction"          => Input::cleaner($_POST['type'])
                );   
                $this->db->insert('comments_reaction')->set($dataarray);  
            }
        }
        return true;
    }
}