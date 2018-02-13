<?php 
class PostInfo{
    // THIS CLASS USE TO GET LIKE, REACT,COMMENT,ETC 
    public $ObjectId; // Profile ID
    public $profileName; // Name
    public $postId; // ID Post
    public $acToken ; // Access Token
    public function _getToken($in_Token){
        $this->acToken = $in_Token;
    }
    // Constructor: Get My Profile ID
    public function _getMyProfileId(){
        
        if (isset($this->acToken))
        {
            $url="https://graph.facebook.com/v2.11/me?fields=id,name&access_token=".$this->acToken;
            $json = file_get_contents($url);
            $js_id = json_decode($json,true);
            if (isset($js_id['id']) && isset($js_id['name']))
            {
                 $this->ObjectId = $js_id['id'];
                 $this->profileName = $js_id['name'];
            } else echo '<br>'."Can't not get Id. Your Access Token can be wrong!";
        }else {
            echo '<br>'."Access Token is empty. Check IT!";
        }
    }
    // Constructor: Get Id group
    public function _getGroupId($gr_id){
        $this->ObjectId = $gr_id;
    }
     // Constructor: Get Id FanFage
    public function _getFageId($fg_id){
        $this->ObjectId = $fg_id;
    }
    // Constructor: Get Post ID
    public function _getPostId($in_Post){
        if (isset($this->ObjectId)){
             $this->postId = $this->ObjectId.'_'.$in_Post;
        }else echo '<br>'."You Don't type profile Id";
    }
    
    /*USED: Count React
        return int(32)
        @ $in_Type: There are 6 parameter valid
            - LIKE
            - LOVE
            - HAHA
            - WOW
            - SAD
            - ANGRY
    */
    public function CountReact($in_Type){
        if (isset($this->postId))
        {
            $p_id = $this->postId;
            $url = "https://graph.facebook.com/v2.11/".$p_id."?fields=reactions.type(".strtoupper($in_Type).").limit(0).summary(1).as(".strtolower($in_Type).")&access_token=".$this->acToken;
            $json = file_get_contents($url);
            $js_react = json_decode($json,true);
            $count =  $js_react[strtolower($in_Type)]['summary']['total_count'];
            return $count;
        }else echo '<br>'."You Don't type Post Id";
    }
    /* USED: This Function To Export List ID Connection
        @ ListReact function return array
        @ $in_Type: There are 6 parameter valid
            - LIKE
            - LOVE
            - HAHA
            - WOW
            - SAD
            - Angry
        @ $in_qr: There are 2 parameter valid
            - id: Export to list id user
            - name:  Export to list name user
    */
    public function ListReact($in_Type,$in_qr){
        if (isset($this->postId))
        {
            $in_Type = strtoupper($in_Type);
            $in_qr = strtolower($in_qr);
            $p_id = $this->postId;
            $url = "https://graph.facebook.com/v2.11/".$p_id."/reactions?pretty=0&type=".strtoupper($in_Type)."&limit=10000000000&access_token=".$this->acToken;
            $json = file_get_contents($url,true);
            $js_List = json_decode($json);
            // Convert js_List to new array
            $result = array();
            for ($i = 0; $i < count($js_List->data);$i++)
               $result[$i] = $js_List->data[$i]->$in_qr;
            return $result;
        }else echo '<br>'."You Don't type Post Id";
    }
    /*USED: Count Commnent
        return int(32)
    */
    public function CountComment(){
        if (isset($this->postId)){
            $p_id = $this->postId;
            $url = "https://graph.facebook.com/v2.11/".$p_id."?fields=comments.limit(0).summary(1)&access_token=".$this->acToken;
            $json = file_get_contents($url);
            $js_cmt = json_decode($json,true);
            $count = $js_cmt['comments']['summary']['total_count'];
            return $count;

        } else echo '<br>'."You Don't type Post Id";
    }
    /* USED: Export list comment
        @ ListComment fucntion return array
        @ There are 4 parameter valid
            - id : Get list id users when they comment
            - name : Get list name users when they comment
            - message : Get content message text when they comment
            - created_time : Get time user when they comment
    */
    public function ListComment($in_qr){
        $in_qr = strtolower($in_qr);
        if ($in_qr == 'id' || $in_qr == 'name')
        {
            if (isset($this->postId)){
                $p_id = $this->postId;
                $url = "https://graph.facebook.com/v2.11/".$p_id."?fields=comments.limit(10000000000)&access_token=".$this->acToken;
                $json = file_get_contents($url);
                $js_List = json_decode($json,true);
                // Convert js_List to new array
                $result = array();
                for ($i = 0; $i < count($js_List['comments']['data']);$i++)
                  $result[$i] = $js_List['comments']['data'][$i]['from'][$in_qr];
                return $result;
            } else '<br>'."You Don't type Post Id";
        }elseif($in_qr == 'message'||$in_qr == 'created_time'){
            switch ($in_qr)
            {
                case 'message':
                    if (isset($this->postId)){
                        $p_id = $this->postId;
                        $url = "https://graph.facebook.com/v2.11/".$p_id."?fields=comments.limit(10000000000)&access_token=".$this->acToken;
                        $json = file_get_contents($url);
                        $js_List = json_decode($json,true);
                        // Convert js_List to new array
                        $result = array();
                        for ($i = 0; $i < count($js_List['comments']['data']);$i++)
                        $result[$i] = $js_List['comments']['data'][$i][$in_qr];
                        return $result;
                    } else '<br>'."You Don't type Post Id";
                    break;
                case 'created_time':
                    if (isset($this->postId)){
                        $p_id = $this->postId;
                        $url = "https://graph.facebook.com/v2.11/".$p_id."?fields=comments.limit(10000000000)&access_token=".$this->acToken;
                        $json = file_get_contents($url);
                        $js_List = json_decode($json,true);
                        // Convert js_List to new array
                        $result = array();
                        for ($i = 0; $i < count($js_List['comments']['data']);$i++)
                        $result[$i] = $js_List['comments']['data'][$i][$in_qr];
                        return $result;
                    } else '<br>'."You Don't type Post Id";
                    break;
            } // End Switch
        } else echo "Parameter Not Invalid ";
   
    }
    /* USED: Create New Status Post
        @ Paramater $message is Message Which you post to your timeline
    */
    public function CreateStaPost($message){
         if (isset($this->ObjectId)){
             $data  = array();
            // Config data
            $data['message'] = $message;
            $data['access_token'] = $this->acToken;
            $post_url = 'https://graph.facebook.com/v2.11/'.$this->ObjectId.'/feed';
            // Curl 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($ch);
            curl_close($ch);
         }else echo "Parameter Not Invalid ";
        
        
    }
    /* USED: Create New Status Post With Picture
        @ Paramater $message is Message Which you post to your timeline
        @ Paramater $link_pic is a url content picture you want to post your timeline
    */
    public function CreatePicPost($message,$link_pic){
         if (isset($this->ObjectId)){
             $data  = array();
            // Config data
            $data['source'] = $link_pic;
            $data['message'] = $message;
            $data['access_token'] = $this->acToken;
            $post_url = 'https://graph.facebook.com/v2.11/'.$this->ObjectId.'/feed';
            // Curl 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($ch);
            curl_close($ch);
         }else echo "You not type your ObjectId ";
        
    }
    /* USED: Edit Post which exist your timeline
        @ Paramater $message is Message Which you post to your timeline
    */
    public function UpdatePost($message){
        if (isset($this->postId)){
            $data  = array();
            // Config data
            $data['message'] = $message;
            $data['access_token'] = $this->acToken;
            $post_url = 'https://graph.facebook.com/v2.11/'.$this->postId;
            // Curl 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($ch);
            curl_close($ch);
        }else echo "You not type your Post Id ";
        
    }
    /* USED: Delete Post which exist your timeline
    */
    public function DeletePost(){
        if (isset($this->postId)){
            $data  = array();
            // Config data
            $data['access_token'] = $this->acToken;
            $post_url = 'https://graph.facebook.com/v2.11/'.$this->postId;
            // Curl 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($ch);
            curl_close($ch);
        }else echo "You not type your Post Id";
    }
    /* USED: Push comment into a post
        @ Paramater $message is comment 
        
        NOTE: Available only fanfage 
    */
    public function Comment($message){
        if (isset($this->postId)){
            $data  = array();
            // Config data
            $data['message'] = $message;
            $data['access_token'] = $this->acToken;
            $post_url = 'https://graph.facebook.com/v2.11/'.$this->postId.'/comments';
            // Curl 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($ch);
            echo $return;
            curl_close($ch);
        }else echo "You not type your Post Id ";
        
    }
    
} 
?>