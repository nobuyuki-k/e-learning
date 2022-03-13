<?php
require_once("../libs/functions.php");

$csrf_token = generate_csrf_token();

require_once("../views/signin_view.php");