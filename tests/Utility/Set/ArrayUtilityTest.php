<?php

namespace Feral\Core\Tests\Utility\Set;

use Feral\Core\Utility\Set\ArrayUtility;
use PHPUnit\Framework\TestCase;

class ArrayUtilityTest extends TestCase
{
    public function testDeepSearch()
    {
        $utility = new ArrayUtility();
        $data = [
            'a' => [
                'b' => 'one',
                'c' => 'two'
            ],
            'd' => [
                'e' => 'three',
                'f' => 'four',
                'g' => 'five',
                'h' => [
                    'one',
                    'seven',
                    'three'
                ]
            ],
            'm' => [
                'n' => 'three'
            ],
            'z' => 'one',
        ];
        $keyMaps = $utility->deepSearch('one', $data);
        $this->assertCount(3, $keyMaps);
        $this->assertEquals('b', $keyMaps[0]['a'][0][0]);
        $this->assertEquals(0, $keyMaps[1]['d'][0]['h'][0][0]);
    }

    public function testDeepRemoval()
    {
        $utility = new ArrayUtility();
        $data = [
            'a' => [
                'b' => 'one',
                'c' => 'two'
            ],
            'd' => [
                'e' => 'three',
                'f' => 'four',
                'g' => 'five',
                'h' => [
                    'one',
                    'seven',
                    'three'
                ]
            ],
            'm' => [
                'n' => 'three'
            ],
            'z' => 'one',
        ];
        $keyMap = [
            [
                'a' =>
                    [
                        'b'
                    ]
            ],
            [
                'd' =>
                    [
                        'h' =>
                            [
                                0
                            ]
                    ]
            ],
            [
                'z'
            ],
            [
                'dne'
            ]
        ];
        $final = $utility->deepRemoval($keyMap, $data, true);
        $this->assertFalse(isset($final['a']['b']));
        $this->assertFalse(isset($final['d']['h'][0]));
        $this->assertTrue(isset($final['a']['c']));
        $this->assertTrue(isset($final['d']['h'][1]));
    }
}
