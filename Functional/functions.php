<?php

function cleanString($str)
{
$s1 = preg_replace('/\\s/i', '', $str);
return preg_replace('/\\./i', '', $s1);
}

// behaves identically to our powershell scripts
function makeUserName($first, $last, $max)
{
$cleanLast = cleanString($last);
$clampedLast = "";

if(strlen($cleanLast) > $max - 1)
$clampedLast = substr($cleanLast, 0, $max - 1);
else
$clampedLast = $cleanLast;

$ret = strtolower($first[0] . $clampedLast);
if($ret == "hpark")
{
echo "Did you Check the Hpark account did they mean HWpark?";
}

return $ret;
}

function generatePassword($length = 8)
{
$f = fopen("/dev/urandom", "r");
$data = fread($f, 2048);
fclose($f);

return substr(md5($data), 0, $length);
}