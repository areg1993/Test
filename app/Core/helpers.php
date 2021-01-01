<?php

function view($name, $params = [])
{
    \App\Core\View::render($name, $params);
}

