<?php

namespace Admin\BLL;

class AdminLogs {

    public function debug($msg, $func = "") {
        $log_table = D("AdminLogs");

        $data["create_time"] = date('Y-m-d');
        $data["type"] = "DEBUG";
        $data["msg"] = $msg;
        $data["func_name"] = $func;

        $log_table->add($data);
        
    }

    public function error($msg, $func = "") {
        $log_table = D("AdminLogs");

        $data["create_time"] = date('Y-m-d');
        $data["type"] = "ERROR";
        $data["msg"] = $msg;
        $data["func_name"] = $func;

        $log_table->add($data);
    }

}
