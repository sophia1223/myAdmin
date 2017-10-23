<?php

namespace App\Tools;


class Validator {
    
    /**
     * isUserName
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool|int
     */
    public function isUserName($attribute, $value, $parameters, $validator)
    {
        $len = strlen($value);
        $mb_len = mb_strlen($value);
        
        $flag = false;
        // 首先检测长度
        if ($mb_len > 2 && $mb_len <= 12)
        {
        } elseif ($len > 2 && $len < 18)
        {
        } else
        {
            return $flag;
        }
        
        if (preg_match('/^(?!\d)(?!_)(?!.*?_$)[a-zA-Z0-9_\-\x{4e00}-\x{9fa5}]+$/u', $value))
        {
            return $flag = true;
        }
        
        return preg_match("/^1[0-9]{10}$/", $value);
        
    }
    
    /**
     * isMobile
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return int
     */
    public function isMobile($attribute, $value, $parameters, $validator)
    {
        return preg_match("/^[1][34578][0-9]{9}$/",$value);
    }
    
    /**
     * isPassword
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function isPassword($attribute, $value, $parameters, $validator)
    {
        $len = strlen($value);
        if ($len < 6 || $len > 24 || preg_match('/(^\d+$)|(^[a-zA-Z]+$)/', $value))
        {
            return false;
        }
        
        return true;
    }
}
