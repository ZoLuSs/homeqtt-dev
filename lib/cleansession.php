<?php
/*
1 min = 60s
1h = 60min = 3600s
2h = 120min = 7200s
4h = 240min = 14400s
*/
ini_set('session.gc_maxlifetime', 14400); //Durée de la session
session_save_path(dirname(__DIR__) . '/sessions');
session_start();
session_gc();
session_destroy();