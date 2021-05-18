<?php

/*  validation.php
 *  Validate data from cupcake form
 *
 */

//returns true if the name is valid
function validName($name)
{
    return strlen(trim($name)) >= 2;
}

//returns true as long as 1 flavor is selected
function validFlavor($flavors)
{
    return !is_null($flavors);
}