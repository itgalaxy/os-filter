<?php
namespace Itgalaxy\OsFilter\Tests;

use Itgalaxy\OsFilter\OsFilter;
use PHPUnit\Framework\TestCase;

class OsFilterTest extends TestCase
{
    public function test()
    {
        $arr = [
            [
                'foo' => 'all'
            ],
            [
                'foo' => 'x86',
                'arch' => 'x86'
            ],
            [
                'foo' => 'x64',
                'arch' => 'x64'
            ],
            [
                'foo' => 'linux',
                'os' => 'linux',
            ],
            [
                'foo' => 'linux',
                'os' => 'linux',
                'arch' => 'x86'
            ],
            [
                'foo' => 'linux',
                'os' => 'linux',
                'arch' => 'x64'
            ],
            [
                'foo' => 'darwin',
                'os' => 'darwin'
            ],
            [
                'foo' => 'windows',
                'os' => 'windows'
            ],
            [
                'foo' => 'windows',
                'os' => 'windows',
                'arch' => 'x86'
            ],
            [
                'foo' => 'windows',
                'os' => 'windows',
                'arch' => 'x64'
            ]
        ];

        $osFilter = new OsFilter();

        $os = strtolower(PHP_OS);

        if (substr($os, 0, 3) === 'win') {
            $os = 'windows';
        }

        if (strstr(php_uname('m'), '64') !== false) {
            $arch = 'x64';
        } else {
            $arch = 'x86';
        }

        $result = $osFilter->find($arr);

        $this->assertTrue($osFilter->find($arr)[0]['foo'] === 'all');

        $this->assertTrue($osFilter->find($arr)[1]['foo'] === $arch);
        $this->assertTrue($osFilter->find($arr)[1]['arch'] === $arch);

        $this->assertTrue($osFilter->find($arr)[2]['foo'] === $os);
        $this->assertTrue($osFilter->find($arr)[2]['os'] === $os);

        if ($os == 'linux') {
            $this->assertTrue(count($result) === 4);
            $this->assertTrue($osFilter->find($arr)[3]['foo'] === $os);
            $this->assertTrue($osFilter->find($arr)[3]['os'] === $os);
            $this->assertTrue($osFilter->find($arr)[3]['arch'] === $arch);
        } elseif ($os == 'windows') {
            $this->assertTrue(count($result) === 4);

            $this->assertTrue($osFilter->find($arr)[3]['foo'] === $os);
            $this->assertTrue($osFilter->find($arr)[3]['os'] === $os);
            $this->assertTrue($osFilter->find($arr)[3]['arch'] === $arch);
        }
    }
}
