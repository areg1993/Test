<?php

namespace App\Controllers;

class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];
    private $r_data;
    private int $status_code;

    /**
     * Class constructor
     *
     * @param array $route_params Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], $args);
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * @param null $data
     * @param int $code
     * @return $this
     */
    protected function response($data = null, $code = 200)
    {
        $this->status_code = $code;
        $this->r_data = $data;
        return $this;
    }

    /**
     *
     */
    protected function json()
    {
        http_response_code($this->status_code);
        header('Content-Type: application/json');
        echo json_encode($this->r_data);
        exit;
    }

    /**
     * @param $url
     * @param $code
     */
    protected function redirect($url, $code)
    {
        header("Location: $url", $code);
        exit();
    }

}