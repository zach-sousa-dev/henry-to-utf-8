<!DOCTYPE html>

<html lang="en">

    <head>
        <title>Henry to UTF-8</title>
        <meta name="description" content="">
        <meta name="author" content="Zachary Sousa">

        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <h1>Henry Font 🔄 UTF-8</h1>

        <nav>
            <a id="active-page">Converter</a>
            <a>About</a>
            <a>Links</a>
        </nav>

        <div id="page">

            <form method="post" action="index.php">

                Conversion cypher:

                <select name="in">
                    <option value="henry" selected>Henry</option>
                    <option value="utf">UTF-8</option>
                </select>

                to

                <select name="out">
                    <option value="henry">Henry</option>
                    <option value="utf" selected>UTF-8</option>
                </select>

                <br><br>

                Settings:<br>

                <input type="checkbox" id="to-file" name="to-file" value="Export">
                <label for="to-file">Export to file</label><br>
                <input type="text" id="ex-name" name="ex-name" placeholder="Exported file name..."><br><br>

                Input:<br>
                <?php 
                    if(isset($_POST) && array_key_exists("text-input", $_POST) && $_POST["text-input"] != "") {
                        echo '<textarea id="text-input" name="text-input" placeholder="Type text to convert..." cols="50" rows="10">' .$_POST["text-input"]. '</textarea>';
                    } else {
                        echo '<textarea id="text-input" name="text-input" placeholder="Type text to convert..." cols="50" rows="10"></textarea>';
                    }
                ?>

                <br>

                <input type="submit" value="Convert!">

                <br><br>
                Output:<br>

            </form>

            <?php
                //THIS SECTION GETS THE LISTS FROM cypher.txt DON'T TOUCH IT :)

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
                    $henry_chars_arr[$index] = trim($word); //some extra spaces were ocurring, this is my bad bandaid solution for now

                foreach($utf_chars_arr as $index => $word)
                    $utf_chars_arr[$index] = trim($word); //some extra spaces were ocurring, this is my bad bandaid solution for now

                /* This is used after the POST is received, the options in the form
                MUST be named as the keys. */
                $char_arrs = array(
                    "henry" => $henry_chars_arr,
                    "utf" => $utf_chars_arr
                );

                /*
                OLD
                $to_utf_cypher = [];
                for($i = 0; $i < count($henry_chars_arr); $i++) {
                    $to_utf_cypher[$henry_chars_arr[$i]] = $utf_chars_arr[$i]??"ERROR!";
                }

                $to_henry_cypher = [];
                for($i = 0; $i < count($utf_chars_arr); $i++) {
                    $to_henry_cypher[$utf_chars_arr[$i]] = $henry_chars_arr[$i]??"ERROR!";
                }*/
                

                /*var_dump($to_utf_cypher);
                echo "<br><br>";
                var_dump($to_henry_cypher);
                echo "<br><br>";*/

            ?>

            <?php

                if(isset($_POST) && array_key_exists("in", $_POST)  && array_key_exists("out", $_POST)  && array_key_exists("text-input", $_POST) && $_POST["text-input"] != "") {
                    echo decode_str( $_POST["text-input"], create_cypher($char_arrs[$_POST["in"]], $char_arrs[$_POST["out"]]) );
                } else {
                    echo "<em>Your output will show up here.</em>";
                }

                //$bad_str = file_get_contents("example.txt");  

                //echo (decode_str($bad_str, $to_utf_cypher));

                function create_cypher($src /*str array*/, $dest/*str array*/) {
                    $cypher = [];
                    for($i = 0; $i < count($dest); $i++) {
                        $cypher[$src[$i]] = $dest[$i]??"ERROR!";
                    }
                    return $cypher;
                }

                //convert function
                function decode_str($input_str, $cypher) {

                    $output_str = "";   //init output
                    $chars = preg_split("\8F[\xA1-\xFE][\xA1-\xFE]\\", $input_str);     //split text by unicode characters

                    var_dump($cypher);
                    echo "<br>";

                    for($i = 0; $i < count($chars); $i++) {     //look at each character
                        if( array_key_exists($chars[$i], $cypher) ) {
                            $output_str .= $cypher[$chars[$i]]; //concatenate decyphered character
                        } else {
                            $output_str .= $chars[$i];  //concatenate ignored character
                        }
                        echo $chars[$i]." ";
                    }

                    return $output_str;
                }
            ?>

        </div>

    </body>

</html>