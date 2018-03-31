<?php

namespace ClawRock\CustomerCoupon\Test\Unit\Observer;

use ClawRock\CustomerCoupon\Observer\RuleAfterLoadObserver;
use Magento\Framework\Event\Observer;
use Magento\SalesRule\Model\Rule;
use PHPUnit\Framework\TestCase;

class RuleAfterLoadObserverTest extends TestCase
{
    /**
     * @var \Magento\SalesRule\Model\Rule
     */
    protected $rule;

    /**
     * @var \ClawRock\CustomerCoupon\Observer\RuleAfterLoadObserver
     */
    protected $observer;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->rule = $this->getMockBuilder(Rule::class)
                           ->setMethods()
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->observer = new RuleAfterLoadObserver();
    }

    public function testAddCouponCustomerId()
    {
        $expected = [
            'freeshipping_freeshipping',
            'flatrate_flatrate'
        ];

        $this->rule->setApplyToShippingMethods('freeshipping_freeshipping,flatrate_flatrate');

        $eventObserver = new Observer([
            'rule' => $this->rule,
        ]);

        $this->observer->execute($eventObserver);
        $this->assertEquals($expected, $this->rule->getApplyToShippingMethods());
        $this->assertInternalType('array', $this->rule->getApplyToShippingMethods());
    }
}
