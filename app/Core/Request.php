<?php

namespace App\Core;

class Request
{
    private array $server_params = [];
    private $request_uri = null;
    private ?string $url = null;
    private $type = null;
    private ?array $get_data = null;
    private ?array $post_data = null;
    private ?array $all_data = null;

    /**
     * Request constructor.
     */
    function __construct()
    {
        $this->server_params = $_SERVER;
        $this->request_uri = $_SERVER['REQUEST_URI'];
        $this->url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
        $this->type = $_SERVER['REQUEST_METHOD'];
        $this->get_data = $this->parser(parse_url($this->url, PHP_URL_QUERY));
        $this->post_data = $this->parser($_POST, true);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->get_data[$key]) ? $this->get_data[$key] : null;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function post($key)
    {
        return isset($this->post_data[$key]) ? $this->post_data[$key] : null;
    }

    /**
     * @return array
     */
    public function all()
    {
        return [
            'get' => $this->get_data,
            'post' => $this->post_data,
        ];
    }

    /**
     * @return mixed
     */
    public function method()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return trim($this->request_uri, '/');
    }


    /**
     * @param $arr
     * @param $value
     * @param $name
     * @return mixed
     */
    private function collect(&$arr, $value, $name)
    {

        if (isset($arr[$name])) {
            if (is_array($arr[$name])) {
                $arr[$name][] = $value;
            } else {
                $arr[$name] = array($arr[$name], $this->clear($value));
            }
        } else {
            $arr[$name] = $value;
        }

        return $arr;
    }

    /**
     * @param $value
     * @return string
     */
    private function clear($value)
    {
        $value = trim($value);
        return htmlspecialchars($value);
    }


    /**
     * @param $data
     * @param bool $isPost
     * @return array
     */
    private function parser($data, $isPost = false)
    {
        $arr = array();

        if (!$isPost) {
            if ($data) {
                $pairs = explode('&', $data);
                foreach ($pairs as $i) {
                    list($name, $value) = explode('=', $i, 2);
                    $this->collect($arr, $value, $name);
                }
            }
        } else {
            foreach ($data as $name => &$value) {
                $this->collect($arr, $value, $name);
            }
        }
        return $arr;
    }
}