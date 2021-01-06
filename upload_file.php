<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
    echo "<pre>";
    var_dump($_FILES);
    echo "<pre/>";
}
