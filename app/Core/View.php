<?php

namespace App\Core;

class View
{

    /**
     * Render a view file
     *
     * @param string $view The view file
     * @param array $data Associative array of data to display in the view (optional)
     *
     * @return void
     * @throws \Exception
     */
    public static function render($view, $data = [])
    {
        extract($data, EXTR_SKIP);

        $file = VIEWS . $view . '.php';
        if (file_exists($file) && is_readable($file)) {
            include($file);
        } else {
            http_response_code(404);
        }

    }
}