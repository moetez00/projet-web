<?php 
/* yloadi ayyi class 7ajti biha automatiquement
used in auth.php
*/
function autoload($className) {
   include_once "models/{$className}.php";
}

spl_autoload_register('autoload');