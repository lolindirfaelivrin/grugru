<?php
namespace Libreria\Utility;
class Helper
{
    /**
     * __callStatic
     * @param  string $method
     * @param  mixed $args
     * @return void
     */
    public static function __callStatic($method, $args)
    {
        $called = get_called_class();
        $class = new $called();
        return $class->$method(...$args);
    }

    protected function generateToken(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}