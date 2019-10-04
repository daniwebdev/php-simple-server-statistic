<?php

class Stats {

    public $output = [];

    function get_cpu() {

        $e = shell_exec("sar -u 1 1");
        $e = explode("\n", $e);
        $e = explode(' ', $e[4]); //get average;
        // $get_end = end($e);
        $avg    = [];
        $total  = 0;
        
        $end = end($e);
        
        foreach($e as $k => $v) {
            if($k > 10 && $v != $end) {
                if(!empty($v)) {
                    $double = (double) str_replace(',', '.', $v);
                    $avg[]  = $double;
                    $total += $double;
                }
            }
        }
        $this->output['cpu'] = $total;

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

        $free = shell_exec('free');
        $free = (string)trim($free);
        $free = explode("\n", $free);
        $mem  = $this->get_free($free[1]);
        
        foreach($this->get_free($free[0]) as $key => $item) {
            if($key > 0) {
                $this->output['memory_b'][$item] = $mem[$key];
            }
        }
        return $this;
    }

    function get_disk() {
        $df = shell_exec("df -l");
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
            if($g_temp[0] != 'Filesystem') {
                $out['file_sistem']     = $g_temp[0];
                $out['size']            = $g_temp[1];
                $out['used']            = $g_temp[2];
                $out['avail']           = $g_temp[3];
                $out['used_percent']    = $g_temp[4];
                $out['mounted_on']      = $g_temp[5];
                $data_df[] = $out;
            }
        }

        $this->output['disk'] = $data_df;
        
        return $this;
    }

    function get_uptime() {
        $uptime = exec('uptime | cut -d "," -f 1,2');

        $this->output['uptime'] = $uptime;
        return $this;
    }


}