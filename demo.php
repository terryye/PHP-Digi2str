<?php
require("./digi2str.php");

//numbers
$number= "11062219850307397078976546512345678979879";
echo $str = digi2str::encode($number);
echo "<br>\n";
echo digi2str::decode($str);
echo "<br>\n";
echo "length change:" . strlen($number)  . "-->" . strlen($str);
echo "<br>\n";
echo "<br>\n";

//negative numbers.  the negative symbol '-' will be kept before the string
$number= "-110622198503073970789765465123";
echo $str = digi2str::encode($number);
echo "<br>\n";
echo digi2str::decode($str);
echo "<br>\n";
echo "length change:" . strlen($number)  . "-->" . strlen($str);
echo "<br>\n";
echo "<br>\n";


//for Chinese ID, there might be an "X" at the end of the number.
$number= "53620019650405371X";
echo $str = digi2str::encodeIDCard($number);
echo "<br>\n";
echo digi2str::decodeIDCard($str);
echo "<br>\n";
echo "length change:" . strlen($number)  . "-->" . strlen($str);