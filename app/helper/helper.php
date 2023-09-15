<?php 

/**
 *
 * @param  Nav
 * @return mixed
 */
function nav($nav = null, $active = null, $count = null)
{
    $i = 0;
    $html = null;
    foreach ($nav as $row) {
        if (isset($row['header'])) {

            $html .= '<li class="nav-header hidden-folded ' . (isset($row['class']) ? $row['class'] : '') . '">' . $row['header'] . '</span></li>';

        } else {

            $html .= '<li class="' . (isset($row['margin']) ? $row['margin'] : '');
            if (isset($active) AND $active == $row['main']) {
                $html .= ' active ';
            } elseif (empty($active) AND $row['main'] == 'main') {
                $html .= ' active ';
            }
            $html .= '">';
            
            $html .= '<a href="';
            if (empty($row['sub'])) {
                $html .= APP . '/' . $row['url'];
            } else {
                $html .= 'javascript:;';
            }
            $html .= '">';
            $html .= '<span class="nav-icon"><svg width="20" height="20" fill="currentColor"><use xlink:href="'.ASSETS.'/sprite/sprite.svg#'.(isset($row['icon']) ? $row['icon'] : '').'" /></svg></span>';
            if (isset($count[$row['main']])) {
                $html .= '<div class="nav-text">';
                $html .= '<div class="fw-semibold">' . $row['name'] . '</div>';
                $html .= '<div class="fs-xs text-muted">' . (isset($count[$row['main']]) ? $count[$row['main']] : '') . ' ' . (isset($row['subtext']) ? $row['subtext'] : '') . '</div>';
                $html .= '</div>';
            } else {
                $html .= '<div class="nav-text fw-semibold">' . $row['name'] . '</div>';
            }
            
            if (isset($row['sub'])) {
                $html .= '<span class="nav-arrow"></span>';
            }
            $html .= '</a>';
            if (isset($row['sub'])) {
                $html .= '<ul class="nav-sub">';
                foreach ($row['sub'] as $SubCategory) {
                    $html .= '<li><a href=\'' . APP . '/' . $SubCategory['url'] . '\'>' . $SubCategory['name'] . '</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        $i++;
    }
    return $html;
}

/**
 *
 * @param getRandomColor
 * @return mixed
 */  
function getRandomColor() { 
    $rand = array('55E4DB', '66D78C', '68CF6C', '6ABEE2', '706DE4', '7391F8', 'D34949', 'D760D2', 'F06868', 'F6A963');
    return $rand[rand(0,9)];
}
/**
 *
 * @param  Json Get
 * @return mixed
 */

function get($data = array(), $field = null, $name = null, $parse = true)
{
    if ($name) {
        foreach ($data  as $key => $val) {
            if ($val['name'] == $name) {
                $data = $data[$key];
            }
        }
    }
    if (is_string($field) && $field) {
        if ($parse) {
            $fields = explode(".", $field);
        }
        
        if (!empty($fields) && count($fields) > 1) {
            $column = $fields[0];
            
            if (isset($data[$column]) && is_string($column) && $column) {
                $parsedjson = @json_decode($data[$column]);
                
                if ($parsedjson) {
                    array_shift($fields);
                    
                    $val = $parsedjson;
                    foreach ($fields as $name) {
                        if ($name && isset($val->$name)) {
                            $val = $val->$name;
                        } else {
                            $val = null;
                            break;
                        }
                    }
                    
                    return is_string($val) ? trim($val) : $val;
                }
            }
        } else {
            if (isset($data[$field])) {
                return is_string($data[$field]) ? trim($data[$field]) : $data[$field];
            }
        }
    }
    
    return null;
}


/**
 *
 * @param file format array
 * @return mixed
 */
function filesizer($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

/**
 *
 * @param  duration
 * @return mixed
 */
function duration($value) {
    $str = null;
    if(isset($value)) {
        $hours = intval($value / 60);
        $minutes = $value % 60;

        if ($hours != 0) {
            $str = $hours . ' '.App::translate('hr');

        }

        // Always show minutes if there are no hours.
        if ($minutes != 0 || $hours == 0) {
            $str .= ' ' . $minutes . ' '.App::translate('min');
        }

        // There will be a leading space if hours is zero.
        return trim($str);
    } else {
        return null;
    }
}

/**
 *
 * @param  Downloader
 * @return mixed
 */

function downloader($url, $filename)
{
    if (file_exists($filename)) {
        @unlink($filename);
    }
    $fp = fopen($filename, 'w');
    if ($fp) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        $result = parse_url($url);
        curl_setopt($ch, CURLOPT_REFERER, $result['scheme'] . '://' . $result['host']);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
        $raw = curl_exec($ch);
        curl_close($ch);
        if ($raw) {
            fwrite($fp, $raw);
        }
        fclose($fp);
        if (!$raw) {
            @unlink($filename);
            return false;
        }
        return true;
    }
    return false;
}

/**
 *
 * @param getDomain
 * @return mixed
 */
function getDomain($url){
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){
        return $regs['domain'];
    }
    return FALSE;
}

/**
 *
 * @param delete directory
 * @return mixed
 */
function removefolder($dirname) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
     if (!$dir_handle)
          return false;
     while($file = readdir($dir_handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                     unlink($dirname."/".$file);
                else
                     removefolder($dirname.'/'.$file);
           }
     }
     closedir($dir_handle);
     rmdir($dirname);
     return true;
}

/**
 *
 * @param  Word Limit
 * @return mixed
 */

function wordlimit($deger, $krktr = 80)
{
    $deger  = Input::cleaner($deger);
    $toplam = strlen($deger);
    if ($toplam > $krktr) {
        $deger = mb_substr($deger, 0, $krktr, 'UTF-8');
    }
    return $deger;
}

/**
 *
 * @param Hit view
 * @return mixed
 */
function hitview($n, $precision = 1) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    }
    else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = ' K';
    }
    else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = ' M';
    }
    else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = ' B';
    }
    else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = ' T';
    } 
    
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }

    return $n_format . $suffix.' '.App::translate('view');
}
/**
 *
 * @param Search array
 * @return mixed
 */
function searchForId($id,$key2=null, $array=null) {
   foreach ($array as $key => $val) {
       if ($val[$key2] == $id) {
           return $key;
       }
   }
   return null;
}
/**
 *
 * @param Minify
 * @return mixed
 */
function buffer($buffer){
    if(MINIFY == true) {
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = str_replace(': ', ':', $buffer);
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    }
    return $buffer;
}

/**
 *
 * @param  Avatar
 * @return mixed
 */
function gravatar($Id = null, $Name = null, $Avatar = null, $Class = null, $Color = null)
{ 
    if ($Avatar) {
        return '<div class="bg-img-cover ' . $Class . '" style="background-image:url(' . UPLOAD . '/avatar/' . $Avatar . ');"></div>';
    } else {
        return '<div class="' . $Class . '" style="'.(isset($Color) ? 'background-color:#'.$Color . ';' : '').'">' . mb_strtoupper(mb_substr($Name, 0, 1, "UTF-8"), "UTF-8") . '</div>';
    }
}

/**
 *
 * @param  iconer
 * @return mixed
 */
function iconer($Icon = null, $Class = null) {  
    return '<div class="' . $Class . '"><svg width="14" height="14" stroke="currentColor" stroke-width="1.75" fill="none"><use xlink:href="'.ASSETS.'/sprite/sprite.svg#'.$Icon.'"></use></svg></div>';
}

// Convert hex to rgb (modified from csstricks.com)
function hex2rgb($colour)
{
    $colour = preg_replace("/[^abcdef0-9]/i", "", $colour);
    if (strlen($colour) == 6)
    {
        list($r, $g, $b) = str_split($colour, 2);
        return Array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
    }
    elseif (strlen($colour) == 3)
    {
        list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        return Array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));    
    }
    return false;
}
/**
 *
 * @param  preview image
 * @return mixed
 */
function picture($folder = null, $image = null, $class = null,$title = null,$size = null) {
    if(isset($size)) {
        $size = explode(',', $size);
    }
    if(isset($image) AND $image == 'thumb-') {
        $image = null;
    }
    if(empty($image)) {
    return '<picture>
        <img src="'.APP.'/ajax/placeholder?size='.$size[0].'x'.$size[1].'" alt="" class="'.$class.'" width="'.$size[0].'" height="'.$size[1].'">
    </picture>';
    } else {
    return '<picture>
        <source data-srcset="' . UPLOAD . '/'.$folder.'/'.str_replace('png', 'webp', $image).'" type="image/webp" class="img-fluid" srcset="' . UPLOAD . '/'.$folder.'/'.str_replace('png', 'webp', $image).'">
        <source data-srcset="' . UPLOAD . '/'.$folder.'/'.$image.'" type="image/png" class="'.$class.'" srcset="' . UPLOAD . '/' . $folder . '/'.$image.'"> 
        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . UPLOAD . '/'.$folder.'/'.$image.'" alt="" class="lazyload '.$class.'" width="'.$size[0].'" height="'.$size[1].'">
    </picture>';

    }
}

/**
 *
 * @param  google image
 * @return mixed
 */
function google_image_proxy($content) {
    $prefix = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url=';
    $suffix = '&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
    $pattern = '/(<img [^>]* ?src=)["\']?(https?:\/\/[^"\' ]+)["\']?([^>]+>)/ism';

    /* method 1, does not encode url */
    //$replacement = '${1}"'.$prefix.'${2}'.$suffix.'"${3}';
    //return preg_replace($pattern, $replacement, $content);

    /* method 2, preg_match then str_replace */
    preg_match_all($pattern, $content, $matches);
    foreach ($matches[2] as $match_url) {
        //if (strpos($match_url, $prefix) !== false) { continue; }
        $replacement = $prefix.urlencode($match_url).$suffix;
        $content = str_replace($match_url, $replacement, $content);
    }
    return $content;
}

function webper($image = '') {
    $searchVal  = array("jpg", "jpeg", "png");
    $replaceVal = array("webp", "webp", "webp");
    return str_replace($searchVal, $replaceVal, $image);
}

/**
 *
 * @param uploader
 * @return mixed
 */
function uploader($file = null, $name = null, $folder = null, $sizer = null,$format = null) {
    if(isset($sizer)) {
        $size = explode(',', $sizer);
    }

    $foo = new \Verot\Upload\Upload($file);
    if ($foo->uploaded) {
        $foo->allowed                   = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png','image/webp');
        $foo->file_auto_rename          = true;
        $foo->file_new_name_body        = $name;
        $foo->image_resize              = true;
        if(empty($size[1])) {
            $foo->image_ratio_y         = true;
        } else {
            $foo->image_ratio_crop      = true;
            $foo->image_y               = $size[1];
        }


        $foo->image_x               = $size[0];
        if(isset($format)) {
            $foo->image_convert         = $format;
        }
        $foo->jpeg_quality          = 100;
        $foo->webp_quality          = 100;
        $foo->Process($folder);
        return $foo->file_dst_name;
    }
}


/**
 *
 * @param tagger
 * @return mixed
 */
function tagger($dd,$decode = null) {
    $tr = array(" ");
    $eng = array("+");
    $dd = str_replace($tr,$eng,trim($dd));
    if(isset($decode)) {
        $dd = str_replace('+',' ',urldecode(trim($dd)));
    }
    return $dd;
}


/**
 *
 * @param random code
 * @return mixed
 */
function randomcode($input = null, $strength = 10) {
    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}

/**
 *
 * @param ip address
 * @return mixed
 */
function ipaddress() {  
    if (!empty($_SERVER['HTTP_CLIENT_IP']))  {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    } else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  

/**
 *
 * @param money
 * @return mixed
 */
function money($money = NULL)
{
    $money = @number_format($money, 2, ",", ".");
    return '$ '.$money;
}


/**
 *
 * @param  Dating
 * @return mixed
 */
function dating($str = null, $format = null)
{   
    if(isset($format) AND $format == 'year') {
        $str = date('Y', strtotime($str));
    } elseif(isset($str)) {
        $calendar = array(
            'Monday'    => App::translate('Monday'),
            'Tuesday'   => App::translate('Tuesday'),
            'Wednesday' => App::translate('Wednesday'),
            'Thursday'  => App::translate('Thursday'),
            'Friday'    => App::translate('Friday'),
            'Saturday'  => App::translate('Saturday'),
            'Sunday'    => App::translate('Sunday'),
            'January'   => App::translate('January'),
            'February'  => App::translate('February'),
            'March'     => App::translate('March'),
            'April'     => App::translate('April'),
            'May'       => App::translate('May'),
            'June'      => App::translate('June'),
            'July'      => App::translate('July'),
            'August'    => App::translate('August'),
            'September' => App::translate('September'),
            'October'   => App::translate('October'),
            'November'  => App::translate('November'),
            'December'  => App::translate('December'),
            'Mon'       => App::translate('Mon'),
            'Tue'       => App::translate('Tue'),
            'Wed'       => App::translate('Wed'),
            'Thu'       => App::translate('Thu'),
            'Fri'       => App::translate('Fri'),
            'Sat'       => App::translate('Sat'),
            'Sun'       => App::translate('Sun'),
            'Jan'       => App::translate('Jan'),
            'Feb'       => App::translate('Feb'),
            'Mar'       => App::translate('Mar'),
            'Apr'       => App::translate('Apr'),
            'May'       => App::translate('May'),
            'Jun'       => App::translate('Jun'),
            'Jul'       => App::translate('Jul'),
            'Aug'       => App::translate('Aug'),
            'Sep'       => App::translate('Sep'),
            'Oct'       => App::translate('Oct'),
            'Nov'       => App::translate('Nov'),
            'Dec'       => App::translate('Dec'),
        );
        $month = date('M', strtotime($str));
        $str = $calendar[$month].'. '.date('d', strtotime($str)).', '.date('Y', strtotime($str));
    }
    return $str;
}

/**
 *
 * @param Timeago
 * @return mixed
 */
function timeago($date)
{
    $timestamp = strtotime($date);
    
    $strTime = array(
        App::translate('sec'),
        App::translate('min'),
        App::translate('hour'),
        App::translate('day'),
        App::translate('month'),
        App::translate('year')
    );
    $length  = array(
        "60",
        "60",
        "24",
        "30",
        "12",
        "10"
    );
    
    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }
        
        $diff = round($diff);
        return $diff . " " . $strTime[$i] . " ".App::translate('ago');
    }
}


/**
 *
 * @param  Ads
 * @return mixed
 */
function ads($data,$id = null,$class = null) {
    $ArrayId        = array_search($id, array_column($data, 'id'));
    $Row            = isset($data["$ArrayId"]) ? $data["$ArrayId"] : null;
    $html = null; 
    if(isset($Row['id'])) {
        $JsonData       = json_decode($Row['ads_data'], true);  
        if($Row['display_user'] == 2 || empty($_COOKIE[AUTH_NAME])) {
            if ($Row['type'] == 'image') {
                
                $html = '<a href="'.$JsonData['link'].'" rel="noreferrer" class="d-block text-center '.$class.'" target="_blank" rel="nofollow"><img src="'.UPLOAD.'/ads/'.$JsonData['image'].'" alt="Ads" class="img-fluid rounded-1"></a>';
                
            } elseif ($Row['type'] == 'code') {
                if(isset($class)) {
                    $html .= '<div class="text-center '.$class.'">';
                }
                $html .= htmlspecialchars_decode($Row['ads_code']);
                if(isset($class)) {
                    $html .= '</div>';
                }
            }
        }
    }
    return $html;

}

/**
 *
 * @param rating
 * @return mixed
 */
function rating($rating) {
    for ($i=1; $i <=5 ; $i++) { 
        if($i<=round($rating)) {
            echo '<i class="bg-warning"></i>';
        }else{
            echo '<i class="bg-gray-300"></i>';
        }
    }
}

/**
 *
 * @param ranked
 * @return mixed
 */
function ranked($xp,$rank = null) {
    $Array = array();
    $index = 0;
    foreach ($rank as $key) {
        if($xp >= $key['xp']){
            $index++;
            $Array['id']        = $index;
            $Array['level']     = $key['level'];
            $Array['xp']        = $key['xp'];
            $Array['name']      = $key['name'];
        }
    }
    return $Array;
}
/**
 *
 * @param  Post link
 * @return mixed
 */
function post($id, $self = null,$type = null) {
    if($type == 'movie') {
        return APP.'/movie/'.$self;
    } elseif($type == 'serie') {
        return APP.'/serie/'.$self;
    }
}
 
/**
 *
 * @param Episode Link
 * @return mixed
 */
function episode($id, $self = null,$season = null,$episode = null) {
    return APP.'/'.App::translate('serie').'/'.$self.'-'.$season.'-'.App::translate('season').'-'.$episode.'-'.App::translate('episode');
}
 
/**
 *
 * @param people link
 * @return mixed
 */

function people($id,$self = null) {
    return APP.'/'.App::translate('people').'/'.$self.'-'.$id;
}

/**
 *
 * @param collections link
 * @return mixed
 */

function collections() {
    return APP.'/'.App::translate('collections');
}
/**
 *
 * @param collection link
 * @return mixed
 */

function collection($id,$self = null) {
    return APP.'/'.App::translate('collection').'/'.$self.'-'.$id;
}

/**
 *
 * @param user link
 * @return mixed
 */

function user($id,$self = null) {
    return APP.'/'.App::translate('user').'/'.$self;
}
/**
 *
 * @param user link
 * @return mixed
 */

function dashboard() {
    return APP.'/'.App::translate('dashboard');
}
 

/**
 *
 * @param tag link
 * @return mixed
 */

function tag($self = null) {
    return APP.'/'.App::translate('tag').'/'.trim($self);
}

 
/**
 *
 * @param platform link
 * @return mixed
 */

function platform($id,$self = null) {
    return APP.'/'.App::translate('platform').'/'.$self.'-'.$id;
}
/**
 *
 * @param community link
 * @return mixed
 */

function community($sort = null) {
    return APP.'/'.App::translate('community').'/'.$sort;
}
/**
 *
 * @param thread link
 * @return mixed
 */

function thread($id,$self = null) {
    return APP.'/'.App::translate('thread').'/'.$self.'-'.$id;
}

/**
 *
 * @param genre link
 * @return mixed
 */

function genre($id,$self = null) {
    return APP.'/'.App::translate('explore').'?genre='.$id;
}
/**
 *
 * @param page link
 * @return mixed
 */

function page($id,$self = null) {
    return APP.'/'.App::translate('page').'/'.$self;
}