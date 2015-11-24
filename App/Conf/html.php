<?php
return array (
  'HTML_CACHE_ON' => false,
  'HTML_CACHE_RULES' => 
  array (
    'index:index' => 
    array (
      0 => '{:group}/index_{0|get_language_mark}',
      1 => '604800',
    ),
    'channel:index' => 
    array (
      0 => '{:group}/channel/{id}{jobid}{infoid}_{0|get_language_mark}_{0|get_para}',
      1 => '1296000',
    ),
    'info:read' => 
    array (
      0 => '{:group}/info/{id}_{0|get_para}',
      1 => '0',
    ),
  ),
);
?>