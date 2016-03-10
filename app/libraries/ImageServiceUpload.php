<?php

class ImageServiceUpload{

    //logging of image params

    
    //$logger->info(" NEAR PLACES SCRIPT STARTED ");
    

    static $image_upload_url = IMAGE_SERVICE_URL;
    static $doc_upload_url = DOC_SERVICE_URL;

    static $valid_request_methods = array("POST", "PUT", "DELETE");
    static $object_types = array("project" => "project",
        "option" => "property",
        "builder" => "builder",
        "locality" => "locality",
        "bank" => "bank",
        "city" => "city",
        "suburb" => "suburb",
        "landmark" => "landmark",
        "company" => "company",
        "listing" => "listing"
    );
    static $sec_image_types = array(
        "project" => array(
            "project_image" => array(
                "Elevation"=> "Elevation",
                "Amenities"=>"Amenities", 
                "Main Others"=>"mainOthers"
            ),
        ),
       
    );
    static $image_types = array(
        "project" => array(
            "location_plan" => "locationPlan",
            "layout_plan" => "layoutPlan",
            "site_plan" => "sitePlan",
            "master_plan" => "masterPlan",
            "cluster_plan" => "clusterPlan",
            "construction_status" => "constructionStatus",
            "payment_plan" => "paymentPlan",
            "specification" => "specification",
            "price_list" => "priceList",
            "application_form" => "applicationForm",
            "project_image" => "main",
            "elevation"=> "main",
            "amenities"=>"amenities", 
            "main_other"=>"mainOther",
            "projectBrouchure"=>"projectBrouchure"
        ),
        "option" => array("floor_plan" => "floorPlan",
                           "3d_floor_plan" => "3DFloorPlan",
                           "panorama" => "Panoramic" ),
        "builder" => array("builder_image" => "logo"),
        "locality" => array(
            "heroshot" => "heroShot",
           
            
        ),
       "city" => array(
            "mall" => "mall",
            "map"  => "map",
            "road" => "road",
            "school" => "school",
            "hospital" => "hospital",
            "hotel" => "hotel",
            "bank" => "bank",
            "station" => "station",
            "gurdwara" => "gurdwara",
            "mosque" => "mosque",
            "bus stand" => "bus stand",
            "park" => "park",
            "hall" => "hall",
            "office" => "office",
            "buildings" => "buildings",
             "other" => "other",
            
        ),
         "suburb" => array(
            "mall" => "mall",
            "map"  => "map",
            "road" => "road",
            "school" => "school",
            "hospital" => "hospital",
            "hotel" => "hotel",
            "bank" => "bank",
            "station" => "station",
            "gurdwara" => "gurdwara",
            "mosque" => "mosque",
            "bus stand" => "bus stand",
            "park" => "park",
            "hall" => "hall",
            "office" => "office",
            "buildings" => "buildings",
             "other" => "other",
            
        ),
         "landmark" => array(
            "school" => "school",
            "hospital"  => "hospital",
            "bank" => "bank",
            "bus_stand" => "bus_stand",
            "park" => "park",
            "atm" => "atm",
            "restaurant" => "restaurant",
            "gas_station" => "gas_station",
            "subway_station" => "subway_station",
            "bus_station" => "bus_station",
            "train_station" => "train_station",
            "airport" => "airport",
            "shopping_mall" => "shopping_mall",
            "grocery_or_supermarket" => "grocery_or_supermarket",
            "office_complex" => "office_complex",
            "play_school" => "play_school",
            "higher_education" =>"higher_education",
            "road" =>"road",
            "hotel" =>"hotel",
            "commercialComplex" =>"commercialComplex",
            "sportsComplex" =>"sportsComplex",
            "major_road" => "major_road",
            "minor_road" => "minor_road",
            "River" => "river",
            "Canal" => "canal",
            "Drain" => "drain",
            "Railway Line" => "railway_line",
            "Metro Line" => "metro_line",
            "Industrial" => "industrial",
            "Agricultural" => "agricultural",
            "Residential Land" => "residential_land",
            "Green Belt" => "green_belt",
            "flyovers" => "flyovers",
            "other" => "other",
        ),
        "bank" => array("logo" => "logo"),
        "company" => array("logo" => "logo",
                "companysignupform" => "companySignupForm"
            ),
        "listing" => array(
            "bedroom"=> "Bedroom",
            "bathroom"=>"Bathroom",
            "balcony"=>"Balcony", 
            "living"=> "Living",
            "dining"=> "Dining",
            "kitchen"=> "Kitchen",
            "other"=> "Other",
            ),
    );


    static $document_types = array("3d_floor_plan", "companysignupform", "panorama", "projectBrouchure");



    function __construct($image, $object, $object_id, $image_type, $extra_params, $method, $image_id = NULL){
        $this->image = $image;
        $this->object = $object;
        $this->object_id = $object_id;
        $this->image_type = $image_type;
        $this->image_id = $image_id;
        $this->method = trim($method);
        $this->extra_params = $extra_params;
        $this->errors = array();
        if(isset($image))
        $this->validate();
        Logger::configure( dirname(__FILE__) . '/../log4php.xml');
        $this->logger = Logger::getLogger("main");
    }

    function upload(){
        
        if(in_array($this->image_type,  static::$document_types)){
            if(!isset($this->image))
                $params = array('file'=>$this->image,'objectType'=>static::$object_types[$this->object],
                'objectId' => $this->object_id, 'documentType' => static::$image_types[$this->object][$this->image_type]);
            else
                 $params = array('file'=>'@'.$this->image,'objectType'=>static::$object_types[$this->object],
                'objectId' => $this->object_id, 'documentType' => static::$image_types[$this->object][$this->image_type]);
        }
        else{
            if(!isset($this->image))
                $params = array('image'=>$this->image,'objectType'=>static::$object_types[$this->object],
                'objectId' => $this->object_id, 'imageType' => static::$image_types[$this->object][$this->image_type]);
            else
                 $params = array('image'=>'@'.$this->image,'objectType'=>static::$object_types[$this->object],
                'objectId' => $this->object_id, 'imageType' => static::$image_types[$this->object][$this->image_type]);
        }
            

        $extra_params = $this->extra_params;
        $params = array_merge($params, $extra_params);





        if($this->method == "DELETE"){

            $response = static::delete($this->image_id, $params);
            $this->logger->info("Method: DELETE");
            $url = static::join_urls(self::$image_upload_url, $this->image_id);
            $this->logger->info("Url: {$url}");
        }
        elseif($this->method == "PUT"){
            $response = static::update($this->image_id, $params);
            $this->logger->info("Method: PUT");
            if($params['image']=='')
                $this->logger->info("Update with no Image.");
            else
                $this->logger->info("Update with Image.");
            $url = static::join_urls(self::$image_upload_url, $this->image_id);
            $this->logger->info("Url: {$url}");
        }
        else{
            $response = static::create($params);
            $this->logger->info("Method: POST");
            $url = self::$image_upload_url;
            $this->logger->info("Url: {$url}");
        }

        
        $this->logger->info("Parameters:");
        foreach ($params as $k => $v) {
            $this->logger->info("{$k} => {$v}");
        }
        
        $this->logger->info("");
        
       
        //$this->response_header = $response["header"];
        //$this->response_body = $response["body"];
        //$this->status = $response["status"];
        //$this->verify_status();
        return $response;
        //$this->raise_errors_if_any();
       
    }

    static function join_urls() {
        $args = func_get_args();
        $paths = array();
        foreach ($args as $arg) {
            $paths = array_merge($paths, (array)$arg);
        }

        $paths = array_map(create_function('$p', 'return trim($p, "/");'), $paths);
        $paths = array_filter($paths);
        return join('/', $paths);
    }

    static function curl_request($post, $method, $url){
        //echo "curl-start:".microtime(true)."<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
        if($method == "POST" || $method == "PUT")
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response= curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response_header = substr($response, 0, $header_size);
        $response_body = json_decode(substr($response, $header_size));
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        //print("<pre>"); print_r($post); echo $url;//echo "head:";var_dump($response_header); echo "body:"; var_dump($response_body);echo "status:"; var_dump($status);
        //die();
        //echo "curl-end:".microtime(true)."<br>";
        return array("header" => $response_header, "body" => $response_body, "status" => $status);
    }

    static function create($post){
        
        //print("<pre>");var_dump($post);var_dump(static::$image_upload_url);die("heool-create");
        
        $returnArr = array();
        $returnArr = array("params" => $post, "method" => 'POST', "url" => static::$image_upload_url);
        //print("<pre>");var_dump($returnArr); die("create");
        return $returnArr;
        
        //return static::curl_request($post, 'POST', static::$image_upload_url);

    }

    static function delete($id, $post){
         //print("<pre>");     
//print_r($post);
        //die("here1");
        if($post['dtype']=="Document"){
                //echo "3d del";
                $url = static::join_urls(self::$doc_upload_url, $id); //die($url);
        }
        else    
            $url = static::join_urls(static::$image_upload_url, $id);
        //return static::curl_request($post, 'DELETE', $url);
        $returnArr = array("params" => $post, "method" => 'DELETE', "url"=> $url);
        return $returnArr;
    }

    static function update($id, $post){
        $url = static::join_urls(static::$image_upload_url, $id);
        //print("<pre>");var_dump($post);var_dump($url);die("heool-update");//
        //return static::curl_request($post, 'POST', $url);
        $returnArr = array("params" => $post, "method" => 'POST', "url"=> $url);
        return $returnArr;
    }

    function validate(){
        if($this->method != "DELETE"){
            $this->validate_keys();
        }
        $this->check_extra_params();
        //$this->raise_errors_if_any();
    }


    function check_extra_params(){
        if(!is_array($this->extra_params)){
            $this->add_errors("Extra params should be array");
        }
    }

    function validate_keys(){
        if(!array_key_exists($this->object, static::$object_types)){
            $this->add_errors($this->object." object not found");
        }
        else{
            if(!array_key_exists($this->image_type, static::$image_types[$this->object])){
                $this->add_errors($this->image_type." image type does not exist in hash.");
            }
        }
    }

    function validate_request_methods(){
        if(!array_key_exists($this->method, static::$valid_request_methods)){
            $this->add_errors("Not a valid request method {$this->method}. Valid methods are: ".
                implode(", ", static::$valid_request_methods));
        }

        if(($this->method == "PUT" || $this->method == "DELETE") && $this->image_id == NULL ){
            $this->add_errors("Image id cannot be null for {$this->method} type request");
        }
    }

    function verify_status(){
        if((int)$this->status != 200){
            $this->add_errors("Got response code ".$this->status.": ".$this->response_body->error->msg);
        }
        else{
            if(property_exists($this->response_body, "error")){
                $this->add_errors("Got error: ".$this->response_body->error->msg);
            }

        }
    }

    function add_errors($errors){
        array_push($this->errors, $errors);
    }

    function raise_errors_if_any(){
        if(count($this->errors) > 0){
            die(implode($this->errors,", "));
        }
    }

    function data(){
        return $this->response_body->data;
    }
    function getMediaTypes($ObjectType_id){
        if(!$ObjectType_id){
            return "Object type id not received!!";
        }
        print_r($object_type_config);
        $query = "SELECT * FROM ".PROPTIGER_DB.".object_media_types WHERE ObjectType_id=".$ObjectType_id;
        $sql_exec = mysql_query($query);
        $data = array();
        while($row = mysql_fetch_assoc($sql_exec)){
            $data[$row["type"]] = $row["display_name"];
        }
        return $data;
    }
}
