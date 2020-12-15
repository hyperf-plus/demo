<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.plus
 * @link     https://www.hyperf.plus
 * @document https://doc.hyperf.plus
 * @contact  4213509@qq.com
 * @license  https://github.com/hyperf-plus/admin/blob/master/LICENSE
 */

use App\Bean\sender;
use App\Entity\UserInfo;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use Qbhy\HyperfAuth\AuthGuard;
use Qbhy\HyperfAuth\AuthManager;


if (!function_exists('getUserInfo')) {
    function getUserInfo($guard = 'jwt', $token = null): \Qbhy\HyperfAuth\Authenticatable
    {
        return getGuard($guard)->user($token);
    }
}

if (!function_exists('getGuard')) {
    function getGuard($guard = 'jwt'): AuthGuard
    {
        return ApplicationContext::getContainer()->get(AuthManager::class)->guard($guard);
    }
}

if (!function_exists('toPrice')) {
    function toPrice($number)
    {
        return number_format($number / 100, 2);
    }
}

if (!function_exists('convertLine')) {
    function convertLine(array $data)
    {
        $result = [];
        foreach ($data as $key => $item) {
            if (is_array($item) || is_object($item)) {
                $result[humpToLine($key)] = convertHump((array)$item);
            } else {
                $result[humpToLine($key)] = $item;
            }
        }
        return $result;
    }
}

/**
 * 　　* 下划线转驼峰
 * 　　* 思路:
 * 　　* step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
 * 　　* step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
 * @param mixed $uncamelized_words
 * @param mixed $separator
 * 　　*/
function camelize($uncamelized_words, $separator = '_')
{
    $uncamelized_words = $separator . str_replace($separator, ' ', strtolower($uncamelized_words));
    return ltrim(str_replace(' ', '', ucwords($uncamelized_words)), $separator);
}

function getTimeMicro()
{
    [$msec, $sec] = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
}


if (!function_exists('getContainer')) {
    function getContainer($id)
    {
        return ApplicationContext::getContainer()->get($id);
    }
}


/**
 * @param $arr_str
 * @param string $delimiter
 * @return array
 */
function multi_str2tree($arr_str, $delimiter = '/')
{
    $res = [];

    $format = function ($str, $delimiter) {
        $arr = explode($delimiter, $str);
        $result = null;
        // 弹出最后一个元素
        for ($i = count($arr) - 1; $i >= 0; --$i) {
            if ($result === null) {
                $result = $arr[$i];
            } else {
                $result = [$arr[$i] => $result];
            }
        }
        return $result;
    };

    foreach ($arr_str as $string) {
        $res = array_merge_recursive($res, $format($string, $delimiter));
    }

    return $res;
}

/**
 * @param $list
 * @param string $id
 * @param string $pid
 * @param string $son
 * @return array|mixed
 */
function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
{
    [$tree, $map] = [[], []];
    foreach ($list as $item) {
        $map[$item[$id]] = $item;
    }
    foreach ($list as $item) {
        if (isset($item[$pid], $map[$item[$pid]])) {
            $map[$item[$pid]][$son][] = &$map[$item[$id]];
        } else {
            $tree[] = &$map[$item[$id]];
        }
    }
    unset($map);
    return $tree;
}
