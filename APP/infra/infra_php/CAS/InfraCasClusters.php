<?php

class InfraCasClusters
{
    public $maincluster = null;
    public $readcluster = null;
    public $leituraInicialNoMain = false;

    public $domain = null;

    /**
     * Construtor da classe InfraCasCluster, ela permite manter uma refer�ncia a dois clusters:
     *
     *   $maincluster - Cluster principal onde s�o feitas todas as opera��es de escrita e em caso de falha ou n�o disponbilidade do $readcluster as de leitura tamb�m.
     *
     *   $readcluster - Cluster, quando existente, usado para ler os objetos. Caso n�o sejam encontrados os objeto neste cluster ele ir� tentar a busca no $maincluster
     *
     **/
    function __construct($maincluster, $readcluster, $leituraInicialNoMain = false, $domain = null)
    {
        $this->maincluster = $maincluster;
        $this->readcluster = $readcluster;
        $this->leituraInicialNoMain = $leituraInicialNoMain;
        $this->domain = $domain;
    }
}
