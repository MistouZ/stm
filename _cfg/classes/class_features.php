<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 29/11/2018
 * Time: 10:38
 */

abstract class Features
{
    /**
     * Set parameter to the item
     * Data from database;
     * @param array $data
     */

    function generate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

}