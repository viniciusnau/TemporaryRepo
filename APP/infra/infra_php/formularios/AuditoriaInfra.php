<?php
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 * 
 * 23/06/2020 - criado por MGA
 *
 */

//require_once 'Infra.php';

class AuditoriaInfra
{

    private static $instance = null;

    public static function getInstance()
    {
        return self::$instance;
    }

    public static function setObjInfraAuditoria($objInfraAuditoria)
    {
        self::$instance = $objInfraAuditoria;
    }
}
