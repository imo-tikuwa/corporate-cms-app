<?php
use Cake\Core\Configure;

/**
 * コード定義を取得する
 * @param $code_key
 * @param $default
 * @return bool|mixed
 */
function _code($code_key, $default = null)
{
    return Configure::read($code_key, $default);
}

/**
 * ランダムな文字列の生成
 * @param number $length
 */
function create_random_str($length = 8)
{
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
        $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
}