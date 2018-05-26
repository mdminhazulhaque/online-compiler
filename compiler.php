<?php

require_once 'lib/Compiler.php';

$_POST = json_decode(file_get_contents('php://input'), true);
$src = $_POST['src'];
$lang = $_POST['lang'];

// TODO: Get stdin from UI
$input = "";

$compiler = new MdMinhazulHaque\Compiler($lang, $src, $input);

header("Content-Type: application/json; charset=UTF-8");

$response = array(
    "out" => $compiler->getOutput(),
    "err" => $compiler->getError(),
    "ret" => $compiler->getExitCode()
);

echo json_encode($response);
