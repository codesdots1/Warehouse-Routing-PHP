<?php

    $array = [

        [
            ['', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', ''],
            ['', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', '']
        ],
        [
            ['', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', ''],
            ['', 'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', '']
        ],
        [
            ['', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', ''],
            ['', 'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', '']
        ],
        [
            ['', 'G1', 'G2', 'G3', 'G4', 'G5', 'G6', 'G7', 'G8', ''],
            ['', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8', '']
        ],
        [
            ['', 'I1', 'I2', 'I3', 'I4', 'I5', 'I6', 'I7', 'I8', ''],
            ['', 'J1', 'J2', 'J3', 'J4', 'J5', 'J6', 'J7', 'J8', '']
        ]

    ];

    $row = [['A', 'B'], ['C', 'D'], ['E', 'F'], ['G', 'H'], ['I', 'J']];

    function pickup($array)
    {
        // $array = [$a,$b,$c,$d];
        // $array = array();

        // foreach($articles as $a){
        //     array_push($array, $a);
        // }
        sort($array);
        
        for($i=0; $i<5; $i++){
            $prekeyrow = null;
            $prekeycol = null;
            foreach ($array as $k => $v) {

                foreach ($GLOBALS['row'] as $key => $value) {
                    if (in_array(substr($v, 0, 1), $value)) {
                        $keyrow = $key;
                        break;
                    }
                }
                if($keyrow==$prekeyrow && substr($v, -1) < $prekeycol){
                    $temp = $array[$k-1];
                    $array[$k-1] = $array[$k];
                    $array[$k] = $temp;
                }
                $prekeycol = substr($v, -1);
                $prekeyrow = $keyrow;
    
            }
        }
        
        // return $array;
        $prepre_elem = null;
        $pre_elem = null;
        foreach($array as $key=>$value){            
            $num = substr($value, -1);
            if($pre_elem != null && $prepre_elem != null && $prepre_elem>4 && $pre_elem<=4 && $num>4){                
                $temp = $array[$key-1];
                $array[$key-1] = $array[$key];
                $array[$key] = $temp;
            }
            $prepre_elem = $pre_elem;
            $pre_elem = $num;
        }

        $firstchar = array();
        $lastchar = array();

        foreach ($array as $value) {
            array_push($firstchar, substr($value, 0, 1));
            array_push($lastchar, substr($value, -1));
        }
     
        $path = array();
        array_push($path, [0,0]);
        
        
        foreach ($firstchar as $k => $v) {

            foreach ($GLOBALS['row'] as $key => $value) {
                if (in_array($v, $value)) {
                    $key2 = array_search($v, $value);
                    $keyrow = $key;
                    break;
                }
            }
            
            if (isset($start) && $start[1] > 4 && $lastchar[$k] > 4) {
                
                if($start[0]==$keyrow){
                    if($start[1] < $lastchar[$k]){
                        for ($i = $start[1]+1; $i <= $lastchar[$k]; $i++) {
                            array_push($path, [$start[0], $i]);
                        }
                    }else{
                        for ($i = $start[1]-1; $i >= $lastchar[$k]; $i--) {
                            array_push($path, [$start[0], $i]);
                        }
                    }
                    
                    $start = [$keyrow, $lastchar[$k]];
                    continue;
                }
                for ($i = $start[1]+1; $i <= 8; $i++) {
                    array_push($path, [$start[0], $i]);
                }
                array_push($path, [$start[0], 9]);
                for ($i = $start[0]+1; $i <= $keyrow; $i++) {
                    array_push($path, [$i, 9]);
                }
                for ($i = 8; $i >= $lastchar[$k]; $i--) {
                    array_push($path, [$keyrow, $i]);
                }
                $start = [$keyrow, $lastchar[$k]];
                continue;
            } elseif (isset($start) && $start[1] <= 4 && $lastchar[$k] <= 4 && $start != [0, 0]) {
                if($start[0]==$keyrow){
                    if($start[1] < $lastchar[$k]){
                        for ($i = $start[1]+1; $i <= $lastchar[$k]; $i++) {
                            array_push($path, [$start[0], $i]);
                        }
                    }else{
                        for ($i = $start[1]-1; $i >= $lastchar[$k]; $i--) {
                            array_push($path, [$start[0], $i]);
                        }
                    }
                    
                    $start = [$keyrow, $lastchar[$k]];
                    continue;
                }
                for ($i = $start[1]-1; $i >= 0; $i--) {
                    array_push($path, [$start[0], $i]);
                }
                for ($i = $start[0]+1; $i <= $keyrow; $i++) {
                    array_push($path, [$i,0]);
                }
                for ($i = 1; $i <= $lastchar[$k]; $i++) {
                    array_push($path, [$keyrow, $i]);
                }
                $start = [$keyrow, $i - 1];
                continue;
            } elseif (isset($start) && $start[1] <= 4 && $lastchar[$k] > 4 ){
                if($start[0]==$keyrow){
                    for ($i = $start[1]+1; $i <= $lastchar[$k]; $i++) {
                        array_push($path, [$start[0], $i]);
                    }
                    
                    $start = [$keyrow, $lastchar[$k]];
                    continue;
                }
                for ($i = $start[1]+1; $i <= 8; $i++) {
                    array_push($path, [$start[0], $i]);
                }
                array_push($path, [$start[0], 9]);
                for ($i = $start[0]+1; $i <= $keyrow; $i++) {
                    array_push($path, [$i, 9]);
                }
                for ($i = 8; $i >= $lastchar[$k]; $i--) {
                    array_push($path, [$keyrow, $i]);
                }

                $start = [$keyrow, $lastchar[$k]];
                continue;
            } elseif (isset($start) && $start[1] > 4 && $lastchar[$k] <= 4 ){
                if($start[0]==$keyrow){
                    for ($i = $start[1]-1; $i >= $lastchar[$k]; $i--) {
                        array_push($path, [$start[0], $i]);
                    }
                    
                    $start = [$keyrow, $lastchar[$k]];
                    continue;
                }

                for ($i = $start[1]+1; $i <= 8; $i++) {
                    array_push($path, [$start[0], $i]);
                }
                array_push($path, [$start[0], 9]);
                for ($i = $start[0]+1; $i <= $keyrow; $i++) {
                    array_push($path, [$i, 9]);
                }
                for ($i = 8; $i >= $lastchar[$k]; $i--) {
                    array_push($path, [$keyrow, $i]);
                }

                $start = [$keyrow, $lastchar[$k]];

                continue;
            }
            for ($i = 1; $i <= $keyrow; $i++) {
                array_push($path, [$i, 0]);
            }
            for ($i = 1; $i <= $lastchar[$k]; $i++) {
                array_push($path, [$keyrow, $i]);
            }
            $start = [$keyrow, $i - 1];
        }
        for ($i = $start[1]-1; $i >= 1; $i--) {
            array_push($path, [$start[0], $i]);
        }

        array_push($path, [$start[0], 0]);

        for ($i = $start[0]-1; $i >= 0; $i--) {
            array_push($path, [$i, 0]);
        }
        array_push($path, $array);
        return $path;
    }

    function robot($array){
        $path = array();
        // $array = array();

        // foreach($articles as $a){
        //     array_push($array, $a);
        // }
        $array = array_chunk($array,4);
        foreach($array as $value){
            array_push($path, pickup($value));
        }
        return $path;
    }    

    $shortest_path = robot($_POST['array']);

       
    foreach($shortest_path as $key=>$value){
        $previousValue = null;
        $step = count($value)-2;
        foreach($value as $v){
            // echo $v[0];
            if(isset($previousValue) && $v[0] !=$previousValue) {
                $step += 2;
            }
            $previousValue = $v[0];
        }
        $shortest_path[$key][] = $step-2;
    }
    
    // echo "<pre>";
    die(json_encode($shortest_path));
    // echo "</pre>";
?>

