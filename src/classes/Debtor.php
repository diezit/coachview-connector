<?php


namespace Diezit\Coachview\Service\Classes;


class Debtor
{
    protected $name;
    protected $vatNumber;
    protected $iban;
    protected $bic;
    protected $private;
    protected $comments;
    protected $paymentType;
    protected $sendInvoiceUsing;
    protected $emailType = 'Bedrijf';
    protected $emailAddress;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  mixed  $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    /**
     * @param  mixed  $vatNumber
     */
    public function setVatNumber($vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param  mixed  $iban
     */
    public function setIban($iban): void
    {
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param  mixed  $bic
     */
    public function setBic($bic): void
    {
        $this->bic = $bic;
    }

    /**
     * @return mixed
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param  mixed  $private
     */
    public function setPrivate($private): void
    {
        $this->private = $private;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param  mixed  $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param  mixed  $paymentType
     */
    public function setPaymentType($paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return mixed
     */
    public function getSendInvoiceUsing()
    {
        return $this->sendInvoiceUsing;
    }

    /**
     * @param  mixed  $sendInvoiceUsing
     */
    public function setSendInvoiceUsing($sendInvoiceUsing): void
    {
        $this->sendInvoiceUsing = $sendInvoiceUsing;
    }

    /**
     * @return mixed
     */
    public function getEmailType()
    {
        return $this->emailType;
    }

    /**
     * @param  mixed  $emailType
     */
    public function setEmailType($emailType): void
    {
        $this->emailType = $emailType;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param  mixed  $emailAddress
     */
    public function setEmailAddress($emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }


}
