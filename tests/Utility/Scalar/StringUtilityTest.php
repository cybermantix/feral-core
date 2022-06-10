<?php

namespace NoLoCo\Core\Tests\Utility\Scalar;

use NoLoCo\Core\Utility\Scalar\StringUtility;
use PHPUnit\Framework\TestCase;

class StringUtilityTest extends TestCase
{

    public function testReplace()
    {
        $stringUtility = new StringUtility();
        $result = $stringUtility->replace(
            'testing replace %one%',
            ['one' => '1']);
        $this->assertEquals('testing replace 1', $result);

        $result = $stringUtility->replace(
            'testing replace |one|',
            ['one' => '1'],
        '|');
        $this->assertEquals('testing replace 1', $result);
    }

    public function testCheckJsonError()
    {
        $stringUtility = new StringUtility();
        $error = $stringUtility->checkJsonError('  {"test":"testing"}  ');
        $this->assertEmpty($error);
        $error = $stringUtility->checkJsonError('"test":"testing"');
        $this->assertNotEmpty($error);
    }

    public function testRandomGenerator()
    {
        $stringUtility = new StringUtility();
        $result = $stringUtility->randomGenerator([1,2,3,4], 3);
        $this->assertEquals(3, strlen($result));
    }


    public function testMergeJsonStrings()
    {
        $utility = new StringUtility();
        $s1 = '{
            "one": "1",
            "two": {
                "two-one": "21"
            },
            "three": [
               {
                 "three-one-one": "311",
                 "three-one-two": "312"
               }
            ]
        }';
        $s2 = '{
            "four": "4"
        }';
        $s3 = '{
            "three": [
               {
                 "three-one-one": "modified"
               }
            ],
            "one": "-DELETED-"
        }';
        $merged = $utility->mergeJsonStrings([$s1, $s2, $s3]);
        $data = json_decode($merged, true);
        $this->assertEquals('modified', $data['three'][0]['three-one-one']);
        $this->assertEquals('21', $data['two']['two-one']);
        $this->assertTrue(empty($data['one']));
    }


    public function testRealMergeJsonStrings()
    {
        $utility = new StringUtility();
        $s1 = '{
          "start": {
            "alias": "ascendian.flow.start",
            "configuration": {},
            "edges": [
              {
                "result": "ok",
                "node": "sync-groups"
              }
            ]
          },
          "sync-groups": {
            "alias": "ascendian.node.sync-groups",
            "configuration": {},
            "edges": [
              {
                "result": "ok",
                "node": "stop"
              }
            ]
          },
          "flush": {
            "alias": "ascendian.data.flush",
            "configuration": {},
            "edges": [
              {
                "result": "ok",
                "node": "stop"
              }
            ]
          },
          "stop": {
            "alias": "ascendian.flow.stop",
            "configuration": {},
            "edges": []
          }
        }';
        $s2 = '{
          "sync-groups": {
            "configuration": {
              "test": "testing"
            }
          }
        }';
        $merged = $utility->mergeJsonStrings([$s1, $s2]);
        $data = json_decode($merged, true);
        $this->assertEquals('ascendian.node.sync-groups', $data['sync-groups']['alias']);
        $this->assertEquals('testing', $data['sync-groups']['configuration']['test']);
    }
}
