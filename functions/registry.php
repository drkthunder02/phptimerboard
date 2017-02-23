<?php

//Autoload Functions
require_once __DIR__.'/../vendor/autoload.php';

//Classes
require_once __DIR__.'/../functions/class/sessions.php';

//Database Functions
require_once __DIR__.'/../functions/database/dbclose.php';
require_once __DIR__.'/../functions/database/dbopen.php';

//SSO Functions
require_once __DIR__.'/../functions/sso/getfooter.php';
require_once __DIR__.'/../functions/sso/getheader.php';
require_once __DIR__.'/../functions/sso/getssocallbackurl.php';
require_once __DIR__.'/../functions/sso/printssourl.php';
require_once __DIR__.'/../functions/sso/redirecttonew.php';
require_once __DIR__.'/../functions/sso/ssosuccess.php';

//HTML Functions
require_once __DIR__.'/../functions/html/printhtmlheader.php';

?>