<?php
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 * 
 * 23/05/2006 - criado por MGA
 *
 */

//require_once 'Infra.php';

class BancoInfra
{

    private static $instance = null;

    public static function getInstance()
    {
        return self::$instance;
    }

    public static function setObjInfraIBanco($objInfraIBanco)
    {
        self::$instance = $objInfraIBanco;
    }
}
