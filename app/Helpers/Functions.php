<?php

if(! function_exists('first_letter'))
{
    function first_letter($word)
    {
        return substr($word, 0, 1);
    }
}
