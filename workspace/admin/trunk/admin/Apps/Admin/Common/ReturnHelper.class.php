<?php

namespace Admin\Common;

class ReturnHelper {

    public $return_array;

    function __construct() {
        $this->return_array = array("is_success" => "0", "msg" => "system error", "return_obj" => array());
    }

    function setError($msg) {
        $this->return_array["is_success"] = "0";
        $this->return_array["msg"] = $msg;
    }

    function setSuccess($obj = array(), $msg = "") {
        $this->return_array["is_success"] = "1";
        $this->return_array["msg"] = $msg;
        $this->return_array["return_obj"] = $obj;
    }

    function returnJson() {
        return json_encode($this->return_array);
    }

}
