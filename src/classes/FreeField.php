<?php

namespace Diezit\CoachviewConnector\Classes;

class FreeField extends CoachviewData
{
    protected $order;
    protected $code;
    protected $label;
    protected $type;
    protected $expression;
    protected $inactive;
    protected $confidential;
    protected $data;

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param  mixed  $order
     * @return FreeField
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param  mixed  $code
     * @return FreeField
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param  mixed  $label
     * @return FreeField
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param  mixed  $type
     * @return FreeField
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param  mixed  $expression
     * @return FreeField
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInactive()
    {
        return $this->inactive;
    }

    /**
     * @param  mixed  $inactive
     * @return FreeField
     */
    public function setInactive($inactive)
    {
        $this->inactive = $inactive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfidential()
    {
        return $this->confidential;
    }

    /**
     * @param  mixed  $confidential
     * @return FreeField
     */
    public function setConfidential($confidential)
    {
        $this->confidential = $confidential;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param  mixed  $data
     * @return FreeField
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }


}
