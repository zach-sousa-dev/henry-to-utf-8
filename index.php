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

            $henry_chars = explode(",", explode("\n", $cypher_file)[0]);
            $utf_chars = explode(",", explode("\n", $cypher_file)[1]);

            $to_utf_cypher = [];
            for($i = 0; $i < count($henry_chars); $i++) {
                $to_utf_cypher[$henry_chars[$i]] = $utf_chars[$i]??"ERROR!";
            }

            $to_henry_cypher = [];
            for($i = 0; $i < count($utf_chars); $i++) {
                $to_henry_cypher[$utf_chars[$i]] = $henry_chars[$i]??"ERROR!";
            }

            //var_dump($to_utf_cypher);
            
        ?>

        <?php

            $bad_str = file_get_contents("example.txt");  
            //echo decode_str($bad_str, $to_utf_cypher);   
            echo count($to_utf_cypher);    
            echo count($to_henry_cypher);    
            echo "<br><br><h3>TO HENRY</h3><br>";
            var_dump($to_henry_cypher);
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo decode_str($bad_str, $to_utf_cypher);

            //convert function

            function decode_str($input_str, $cypher) {
                $output_str = "";
                $chars = str_split($input_str);

                for($i = 0; $i < count($chars); $i++) {
                    if( array_key_exists($chars[$i], $cypher) ) {
                        $output_str.=$cypher[$chars[$i]];
                    } else {
                        $output_str.=$chars[$i];
                    }
                }

                return $output_str;
            }
        ?>

    </body>

</html>