<?php
namespace PaymentAdapter;

use ReflectionException;

class Payment {

    /** @var string */
    public $_driver;

    /** @var object */
    public $_user;

    /** @var array */
    protected $drivers = [
        'authorize.net' => \ANet\ANet::class
    ];

    /**
     * Payment constructor.
     * @param string|null $driver
     */
    public function __construct(string $driver = null) {
        if ($driver) {
            $this->setDriver($driver);
        }
    }

    /**
     * @param $user
     * @return Payment
     */
    public function setUser($user) : Payment {
        $this->_user = $user;
        return $this;
    }

    /**
     * @return object
     */
    public function getUser() {
        return $this->_user;
    }

    /**
     * @param string $driver
     * @return Payment
     */
    public function setDriver(string $driver) : Payment {
        $this->_driver = $driver;
        return $this;
    }

    /**
     * It will return name of the driver
     * @return string
     */
    public function getDriver() : string {
        return $this->_driver;
    }

    /**
     * It will get driver class instance
     * @param string|null $driver
     * @return mixed
     */
    public function getDriverClass() {
        $driver = $this->drivers[$this->_driver];
        if (!$driver) {
            throw new Exception('Driver unavailable');
        }
        return new $driver($this->_user);
    }

    public function charge($amountInCents, $currency, $sourceId) : bool {
        return $this->getDriverClass()->charge($amountInCents, $currency, $sourceId);
    }
}
