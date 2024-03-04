<!DOCTYPE html>

<html lang="en">

    <head>
        <title>Henry to UTF-8</title>
        <meta name="description" content=""/>
        <meta name="author" content="Zachary Sousa"/>

        <link href="style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>

        <h1>Henry Font to UTF-8 Converter</h1>

        <h3>Input:</h3>

        <form method="post" action="index.php">

            <select name="menu">
                <option value="h-to-u" selected>Henry -> UTF-8</option>
                <option value="u-to-h">UTF-8 -> Henry</option>
            </select>

            <br>

            <textarea id="text-input" name="text-input" placeholder="Type text to convert..." cols="50" rows="10"></textarea>

            <br>

            <input type="submit" value="Convert!">

            <h3>Output:</h3>

        </form>

        <?php
            //THIS SECTION CREATES THE CYPHER DON'T TOUCH IT :)

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

            foreach($henry_chars_arr as $index => $word)
                $henry_chars_arr[$index] = trim($word);

            foreach($utf_chars_arr as $index => $word)
                $utf_chars_arr[$index] = trim($word);

            $to_utf_cypher = [];
            for($i = 0; $i < count($henry_chars_arr); $i++) {
                $to_utf_cypher[$henry_chars_arr[$i]] = $utf_chars_arr[$i]??"ERROR!";
            }

            $to_henry_cypher = [];
            for($i = 0; $i < count($utf_chars_arr); $i++) {
                $to_henry_cypher[$utf_chars_arr[$i]] = $henry_chars_arr[$i]??"ERROR!";
            }
            
        ?>

        <?php

            if(isset($_POST) && array_key_exists("menu", $_POST) && $_POST["text-input"] != "") {
                if($_POST["menu"] == "h-to-u") {
                    echo decode_str($_POST["text-input"], $to_utf_cypher);
                } else if($_POST["menu"] == "u-to-h") {
                    echo decode_str($_POST["text-input"], $to_henry_cypher);
                }
            } else {
                echo "<em>Your output will show up here.</em>";
            }

            //$bad_str = file_get_contents("example.txt");  

            //echo (decode_str($bad_str, $to_utf_cypher));

            //convert function
            function decode_str($input_str, $cypher) {
                $output_str = "";   //init output
                $chars = preg_split("//u", $input_str);     //split text by unicode characters

                for($i = 0; $i < count($chars); $i++) {     //look at each character
                    if( array_key_exists($chars[$i], $cypher) ) {
                        $output_str .= $cypher[$chars[$i]]; //concatenate decyphered character
                    } else {
                        $output_str .= $chars[$i];  //concatenate ignored character
                    }
                }

                return $output_str;
            }
        ?>

    </body>

</html>