<?php


namespace App\Core;


use App\Models\User;

class Auth
{
    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function authenticate($email, $password)
    {

        if (!empty($email) && !empty($password)) {
            $password = hash("sha256", $password . SALT);
            $user = User::where('name', $email)->where('password', $password)->first();
            if ($user) {
                $_SESSION["user"] = $user->toArray();
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isLogged()
    {
        return (isset($_SESSION["user"]) && !empty($_SESSION["user"]));
    }

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        return (self::isLogged() && 'admin' === $_SESSION["user"]["role"]);
    }

    /**
     * @return mixed|null
     */
    public static function user()
    {
        return self::isLogged() ? $_SESSION["user"] : null;
    }

    /**
     *
     */
    public static function clearSession()
    {
        unset($_SESSION["user"]);
    }


}