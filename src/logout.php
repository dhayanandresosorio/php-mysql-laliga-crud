<?php
require __DIR__ . '/includes/auth.php';

session_destroy();

redirect('login.php');
