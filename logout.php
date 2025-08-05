<?php
ob_start();
session_start();
unset($_SESSION['Klin_user']);
unset($_SESSION['candidate_id']);
session_destroy();

header("Location: login");
