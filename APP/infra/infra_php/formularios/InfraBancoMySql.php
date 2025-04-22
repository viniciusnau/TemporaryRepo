<?php
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/04/2013 - criado por MGA
*
*/

//require_once dirname(__FILE__).'/Infra.php';


class InfraBancoMySql extends InfraMySql
{

    private $strServidor = '';
    private $strPorta = '';
    private $strBanco = '';
    private $strUsuario = '';
    private $strSenha = '';

    public static function newInstance($strServidor, $strPorta, $strBanco, $strUsuario, $strSenha)
    {
        $objInfraMySql = new InfraBancoMySql();
        $objInfraMySql->setServidor($strServidor);
        $objInfraMySql->setPorta($strPorta);
        $objInfraMySql->setBanco($strBanco);
        $objInfraMySql->setUsuario($strUsuario);
        $objInfraMySql->setSenha($strSenha);
        return $objInfraMySql;
    }

    public function setServidor($strServidor)
    {
        $this->strServidor = $strServidor;
    }

    public function getServidor()
    {
        return $this->strServidor;
    }

    public function setPorta($strPorta)
    {
        $this->strPorta = $strPorta;
    }

    public function getPorta()
    {
        return $this->strPorta;
    }

    public function setBanco($strBanco)
    {
        $this->strBanco = $strBanco;
    }

    public function getBanco()
    {
        return $this->strBanco;
    }

    public function setUsuario($strUsuario)
    {
        $this->strUsuario = $strUsuario;
    }

    public function getUsuario()
    {
        return $this->strUsuario;
    }

    public function setSenha($strSenha)
    {
        $this->strSenha = $strSenha;
    }

    public function getSenha()
    {
        return $this->strSenha;
    }
}

