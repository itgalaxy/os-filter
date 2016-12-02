<?php
namespace OsFilter\Tests;

use OsFilter\OsFilter;
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
                'foo' => 'linux',
                'os' => 'linux'
            ],
            [
                'foo' => 'darwin',
                'os' => 'darwin'
            ],
            [
                'foo' => 'winnt',
                'os' => 'winnt'
            ]
        ];

        $osFilter = new OsFilter();

        $this->assertTrue(count($osFilter->find($arr)) === 2);
        $this->assertTrue($osFilter->find($arr)[0]['foo'] === 'all');

        $os = strtolower(PHP_OS);

        if ($os === 'linux') {
            $this->assertTrue($osFilter->find($arr)[1]['foo'] === $os);
            $this->assertTrue($osFilter->find($arr)[1]['os'] === $os);
        } elseif ($os === 'darwin') {
            $this->assertTrue($osFilter->find($arr)[2]['foo'] === $os);
            $this->assertTrue($osFilter->find($arr)[2]['os'] === $os);
        } elseif ($os === 'windowsnt') {
            $this->assertTrue($osFilter->find($arr)[3]['foo'] === $os);
            $this->assertTrue($osFilter->find($arr)[3]['os'] === $os);
        }
    }
}
