<?php
require_once("../libs/functions.php");

$csrf_token = generate_csrf_token();

require("../views/signup_view.php");