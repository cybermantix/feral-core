<?php

namespace Feral\Core\Tests\Utility\DateTime;

use Feral\Core\Utility\DateTime\ReferenceBasedDateTimeWindowCreator;
use PHPUnit\Framework\TestCase;

class ReferenceBasedDateTimeWindowCreatorTest extends TestCase
{

    public function testCreate()
    {
        $creator = new ReferenceBasedDateTimeWindowCreator();
        $format = 'Y-m-d';

        $reference = new \DateTimeImmutable('2021-01-01');
        $window = $creator->create($reference, 1, 2021);
        $this->assertEquals('2021-01-01', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-01-31', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2021);
        $this->assertEquals('2021-02-01', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-02-28', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2020);
        $this->assertEquals('2020-02-01', $window->getStartDateTime()->format($format));
        $this->assertEquals('2020-02-29', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 3, 2021);
        $this->assertEquals('2021-03-01', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-03-31', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 12, 2021);
        $this->assertEquals('2021-12-01', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-12-31', $window->getEndDateTime()->format($format));



        $reference = new \DateTimeImmutable('2021-01-03');
        $window = $creator->create($reference, 1, 2021);
        $this->assertEquals('2021-01-03', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-02-02', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2021);
        $this->assertEquals('2021-02-03', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-03-02', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 3, 2021);
        $this->assertEquals('2021-03-03', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-04-02', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 4, 2021);
        $this->assertEquals('2021-04-03', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-05-02', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 12, 2021);
        $this->assertEquals('2021-12-03', $window->getStartDateTime()->format($format));
        $this->assertEquals('2022-01-02', $window->getEndDateTime()->format($format));


        $reference = new \DateTimeImmutable('2021-01-29');
        $window = $creator->create($reference, 1, 2021);
        $this->assertEquals('2021-01-29', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-02-27', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2021);
        $this->assertEquals('2021-02-28', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-03-28', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 1, 2020);
        $this->assertEquals('2020-01-29', $window->getStartDateTime()->format($format));
        $this->assertEquals('2020-02-28', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2020);
        $this->assertEquals('2020-02-29', $window->getStartDateTime()->format($format));
        $this->assertEquals('2020-03-28', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 3, 2021);
        $this->assertEquals('2021-03-29', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-04-28', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 12, 2021);
        $this->assertEquals('2021-12-29', $window->getStartDateTime()->format($format));
        $this->assertEquals('2022-01-28', $window->getEndDateTime()->format($format));

        $reference = new \DateTimeImmutable('2021-01-31');
        $window = $creator->create($reference, 1, 2021);
        $this->assertEquals('2021-01-31', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-02-27', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2021);
        $this->assertEquals('2021-02-28', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-03-30', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 1, 2020);
        $this->assertEquals('2020-01-31', $window->getStartDateTime()->format($format));
        $this->assertEquals('2020-02-28', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 2, 2020);
        $this->assertEquals('2020-02-29', $window->getStartDateTime()->format($format));
        $this->assertEquals('2020-03-30', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 3, 2021);
        $this->assertEquals('2021-03-31', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-04-29', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 4, 2021);
        $this->assertEquals('2021-04-30', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-05-30', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 6, 2021);
        $this->assertEquals('2021-06-30', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-07-30', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 7, 2021);
        $this->assertEquals('2021-07-31', $window->getStartDateTime()->format($format));
        $this->assertEquals('2021-08-30', $window->getEndDateTime()->format($format));

        $window = $creator->create($reference, 12, 2021);
        $this->assertEquals('2021-12-31', $window->getStartDateTime()->format($format));
        $this->assertEquals('2022-01-30', $window->getEndDateTime()->format($format));
    }
}
