<?php
namespace Itgalaxy\OsFilter;

class OsFilter
{
    public static function find($arr)
    {
        $arch = null;
        $platform = strtolower(PHP_OS);

        if (substr($platform, 0, 3) === 'win') {
            $platform = 'winint';
        }

        if (!empty(strstr(php_uname('m'), '64'))) {
            $arch = 'x64';
        } else {
            $arch = 'x86';
        }

        if (!$arr || count($arr) == 0) {
            return [];
        }

        return array_filter(
            $arr,
            function ($obj) use ($arch, $platform) {
                if (!empty($obj['os']) && $obj['os'] == $platform && !empty($obj['arch']) && $obj['arch'] == $arch) {
                    unset($obj['os']);
                    unset($obj['arch']);

                    return $obj;
                } elseif (!empty($obj['os']) && $obj['os'] == $platform && empty($obj['arch'])) {
                    unset($obj['os']);

                    return $obj;
                } elseif (!empty($obj['arch']) && $obj['arch'] == $arch && empty($obj['os'])) {
                    unset($obj['arch']);

                    return $obj;
                } elseif (empty($obj['os']) && empty($obj['arch'])) {
                    return $obj;
                }
            }
        );
    }
}
