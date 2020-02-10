<?php
class Table
{
    private $continent;
    public function __construct($continent)
    {
        $this->continent = $continent;
    }
    public function abc()
    {
        return $this->continent;
    }
}