<?php

namespace Diezit\CoachviewConnector\Classes;

class Person
{
    public $initials;
    public $first_name;
    public $last_name;
    protected $address;
    protected $invoiceAddress;

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param  Address  $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getInvoiceAddress(): Address
    {
        return $this->invoiceAddress;
    }

    /**
     * @param  Address  $address
     */
    public function setInvoiceAddress(Address $address): void
    {
        $this->invoiceAddress = $address;
    }

}
