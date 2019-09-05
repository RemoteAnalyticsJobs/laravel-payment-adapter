<?php
namespace PaymentAdapter\Test;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PaymentAdapter\Contracts\PaymentDriverInterface;
use PaymentAdapter\Payment;
use Tests\TestCase;

class PaymentTest extends TestCase {
    use DatabaseMigrations;

    public function test_if_class_can_be_instantiated() {
        $this->assertIsObject(new Payment());
    }


    public function test_if_driver_can_be_set() {
        $payment = new Payment();
        $driver  = 'authorize.net';

        $payment->setDriver($driver);

        $this->assertEquals($driver, $payment->_driver);
    }

    public function test_if_driver_can_be_retrieved() {
        $payment    = new Payment();
        $driver     = 'authorize.net';

        $payment->_driver = $driver;
        $this->assertEquals($driver, $payment->getDriver());
    }

    public function test_if_driver_can_be_only_string() {
        $this->expectException(\TypeError::class);
        $payment    = new Payment();
        $driver     = null;

        $payment->_driver = $driver;
        $this->assertEquals($driver, $payment->getDriver());
    }

    public function test_if_driver_class_is_returned() {
        $driverName  = 'authorize.net';
        $payment = new Payment($driverName);

        $driver = $payment->getDriverClass();
        $this->assertInstanceOf(PaymentDriverInterface::class, $driver);
    }

    public function test_if_charge_method_is_available() {
        $this->assertTrue(\method_exists(new Payment(), 'charge'));
    }

    public function test_if_user_can_be_set_and_get() {
        $payment = new Payment();
        $user    = factory(User::class)->create();

        $payment->setUser($user);
        $this->assertTrue($user->is($payment->_user));
        $this->assertTrue($payment->getUser()->is($user));
    }

    public function test_if_driver_can_be_used_For_Charge() {
        $amount     = 1200;
        $currency   = 'USD';
        $sourceId   = 1;
        $driver     = 'authorize.net';
        $user       = factory(User::class)->create();

        $payment = new Payment($driver);
        $payment->setUser($user);
        $isCharged = $payment->charge($amount, $currency, $sourceId);
        dd($isCharged);
    }

}
