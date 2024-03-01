<!DOCTYPE html>

<html lang="en">

    <head>
        <title>Henry to UTF-8</title>
        <meta name="description" content=""/>
        <meta name="author" content="Zachary Sousa"/>

        <link href="style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>

        <!-- webform -->

        <?php
            //make cypher
            $cypher_filename = "cypher.txt";
            $cypher_file = file_get_contents($cypher_filename);

            /* 
            The cypher file must be organized as such:
            H,e,n,r,y,F,o,n,t\n
            N,o,t,H,e,n,r,y,s
            */


            
            $henry_chars_str = explode("\n", $cypher_file)[0];
            $henry_chars_arr = explode(",", $henry_chars_str); 
            $utf_chars_str = explode("\n", $cypher_file)[1];
            $utf_chars_arr = explode(",", $utf_chars_str);

            

            $to_utf_cypher = [];
            for($i = 0; $i < count($henry_chars_arr); $i++) {
                $to_utf_cypher[$henry_chars_arr[$i]] = $utf_chars_arr[$i]??"ERROR!";
            }

            $to_henry_cypher = [];
            for($i = 0; $i < count($utf_chars_arr); $i++) {
                $to_henry_cypher[$utf_chars_arr[$i]] = $henry_chars_arr[$i]??"ERROR!";
            }

            echo "<h3>TO HENRY</h3>";
            //var_dump($henry_chars_arr);
            var_dump($to_henry_cypher);
            echo "<h3>TO UTF8</h3>";
            //var_dump($utf_chars_arr);
            var_dump($to_utf_cypher);
            
        ?>

        <?php

            $bad_str = file_get_contents("example.txt");  
 
            
            echo "<br>";
            echo "<br>";

            echo (new_new_decode_str($bad_str, $to_utf_cypher));

            //convert function

            function new_new_decode_str($input_str, $cypher) {
                $output_str = "";
                $chars = preg_split("//u", $input_str);

                echo "<br><br><h3>INPUT</h3>";
                var_dump($chars);
                echo "<br>";

                for($i = 0; $i < count($chars); $i++) {
                    if( array_key_exists($chars[$i], $cypher) ) {
                        $output_str .= $cypher[$chars[$i]];
                    } else {
                        $output_str .= $chars[$i];
                    }
                }

                return $output_str;
            }
        ?>

    </body>

</html>