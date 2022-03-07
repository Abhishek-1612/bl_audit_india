<?php

if (is_array($data) && !empty($data)){
            $keys = array_keys($data[0]);

            echo "<table>";
            echo "<tr>";
            foreach ($keys as $key) {
                echo "<th> $key </th>";
            }
            echo "</tr>";

            for($i=0;$i<count($data);$i++){
                echo "<tr>";
                foreach ($data[$i] as $key => $value) {
                    echo "<td> $value </td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        }
        else{
            echo "<div style='width:100%;display:flex;align-items:center;justify-content:center;'><img style='width:30%;' src='./gifs/no-data.svg'/></div>";
    }

