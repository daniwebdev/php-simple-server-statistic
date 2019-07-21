<?php

class Stats {

    public $output = [];

    function get_cpu() {
        $cpu = sys_getloadavg()[0];
        $this->output['cpu'] = $cpu."%";

        return $this;
    }
    
    protected function get_free($labels) {
        $labels  = explode(' ', $labels);
        $labels_array = [];
        foreach($labels as $value) {
            if($value != "") {
                $labels_array[] = $value;
            }
        }
        return $labels_array;
    }

    function get_mem() {
        
        $free = shell_exec('free -h');
        $free = (string)trim($free);
        $free = explode("\n", $free);
        $mem  = $this->get_free($free[1]);
        
        foreach($this->get_free($free[0]) as $key => $item) {
            if($key > 0) {
                $this->output['memory'][$item] = $mem[$key];
            }
        }
        return $this;
    }

    function get_disk() {
        $df = shell_exec("df -lh");
        $df = (string)trim($df);
        $df = explode("\n", $df);
        $data_df = [];
        foreach($df as $val) {
            $temp = explode(" ", $val);
            $g_temp = [];
            foreach($temp as $dat) {
                if($dat != '') {
                    $g_temp[] = $dat;
                }
            }
            $out['file_sistem']     = $g_temp[0];
            $out['size']            = $g_temp[1];
            $out['used']            = $g_temp[2];
            $out['avail']           = $g_temp[3];
            $out['used_percent']    = $g_temp[4];
            $out['mounted_on']      = $g_temp[5];
            $data_df[] = $out;
        }
        unset($data_df[0]);
        $this->output['disk'] = $data_df;
        
        return $this;
    }


}