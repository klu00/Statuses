<?php

namespace Model;

class JsonFinder implements FinderInterface {
    
    private $file = "save.json";

    public function __construct() {
        if(!file_exists($this->file)) {
            $handle = fopen($this->file,"w");
            fclose($handle);
        }
    }
    
    public function findAll(){
        $previous_statuses = json_decode(file_get_contents($this->file), true);   
        return $this->create_status_list_from_array($previous_statuses);
    }
    
    public function findAllJson() {
        return file_get_contents($this->file);
    }
    
    public function findOneById($id) {
       $previous_statuses = json_decode(file_get_contents($this->file), true);
       if($status = $this->create_status_from_json($previous_statuses, $id))
          return $status;
       return null;
    }

    public function findOneByIdJson($id) {
        $previous_statuses = json_decode(file_get_contents($this->file), true);
        if($status = $this->create_status_from_json($previous_statuses, $id))
            return $this->create_json_status($status);
        return null;
    }
    
    public function add_status(Status $status){
        $new_status = $this->create_json_status($status);

        $previous_statuses = json_decode(file_get_contents($this->file), true);

        array_push($previous_statuses, $new_status);

        file_put_contents($this->file, json_encode($previous_statuses, JSON_FORCE_OBJECT) . "\n");
    }
    
    public function delete($id) {
        $previous_statuses = json_decode(file_get_contents($this->file), true);
        $new_array = array();
        
        foreach($previous_statuses as $status) {
            var_dump($status);
            if($status['id'] != $id) {
                array_push($new_array, $status);
            }
        }
        file_put_contents($this->file, json_encode($new_array, JSON_FORCE_OBJECT) . "\n");
    }

    private function create_status_list_from_array($previous_statuses){
        $status_array = array();
        foreach($previous_statuses as $status) {
            $status_array[] = $this->create_status_from_array($status);
        }
        return $status_array;
    }

    private function create_status_from_array($status){
        $status_id = $status['id'];
        $status_user = $status['user'];
        $status_message = $status['message'];
        $status_date = \DateTime::createFromFormat("Y-m-d H:i:s", $status['date']);
        return new Status($status_id, $status_date, $status_user, $status_message);
    }

    private function create_status_from_json($previous_statuses, $id) {
        foreach($previous_statuses as $status){
            if($status['id'] == $id)
            {
                return $this->create_status_from_array($status);
            }
        }
    }

    private function create_json_status(Status $status) {
        $array = ['id' => $status->getId(),
                    'user' => $status->getUser(),
                    'message' => $status->getMessage(),
                    'date' => $status->getDate()->format('Y-m-d H:i:s'),
        ];
        return $array;
    }     
} 
