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
            echo "<h3>TO HENRY</h3>";
            var_dump($to_henry_cypher);
            echo "<h3>TO UTF8</h3>";
            var_dump($to_utf_cypher);
            echo "<br>";
            echo "<br>";
            //echo new_decode_str($bad_str, 3, $to_utf_cypher);
            //echo (new_new_decode_str($bad_str, $to_utf_cypher));
            echo mb_convert_encoding($bad_str, $to_utf_cypher, $to_henry_cypher);

            //convert function

            function old_decode_str($input_str, $cypher) {
                $output_str = "";
                $chars = str_split($input_str);

                for($i = 0; $i < count($chars); $i++) {
                    if( array_key_exists($chars[$i], $cypher) ) {
                        $output_str .= $cypher[$chars[$i]];
                    } else {
                        $output_str .= $chars[$i];
                    }
                }

                return $output_str;
            }

            function new_new_decode_str($input_str, $cypher) {
                $output_str = "";
                $chars = mb_str_split($input_str);

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

        <?php
            function new_decode_str($input_str, $highest_len, $cypher) {
                $input_arr = str_split($input_str);
                $text_chunk = [];
                $output_str = "";

                $cypher_keys = array_keys($cypher);
                for($i = 0; $i < count($cypher_keys); $i++) {
                    echo "i am element of cypher_keys: " . $cypher_keys[$i];
                }

                $all_cypher_key_chars_str = "";
                for($i = 0; $i < count($cypher_keys); $i++) {
                    $all_cypher_key_chars_str .= $cypher_keys[$i];
                }
                $all_cypher_key_chars_arr = str_split($all_cypher_key_chars_str);

                var_dump($all_cypher_key_chars_arr);
                echo "<br>";

                for($i = 0; $i < count($input_arr); $i++) {

                    array_push($text_chunk, $input_arr[$i]);

                    $concatenated = "";
                    for($j = 0; $j < count($text_chunk); $j++) {
                        $concatenated .= $text_chunk[$j];
                    }

                    if( array_key_exists($concatenated, $cypher) ) {//found valid character
                        $output_str .= $cypher[$concatenated];
                        //$i -= (count($text_chunk) - 2);
                        $text_chunk = [];
                    } else if(count($text_chunk) == $highest_len) { //no valid characters
                        $i -= ($highest_len - 2);
                        $text_chunk = [];
                    } else {
                        if( !in_array($input_arr[$i], $all_cypher_key_chars_arr) ) {
                            $output_str .= $input_arr[$i];
                        }
                    }
                }

                return $output_str;
            }

        ?>

    </body>

</html>