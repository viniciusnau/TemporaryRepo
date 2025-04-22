<?php

class InfraCasNode
{
    public $active = true;
    private $lastfailtime;
    private $timeout = 1;

    /** @var string Vari�vel contendo uma representa��o no formato URI de acesso a um n� Sawrm ou um SCSPProxy. */
    public $url;

    /**
     * Construtor indicando a URL para este n� assim como o timeout (minutos) antes de tentar de tirar do estado de falha.
     *
     * @param string $url - URL indicando um n� do Swarm ou SCSPProxy
     *
     * @param int $timeout - N�mero de minutos antes que o n� em estado de falha possa ser reavaliado para entrar em opera��o
     *
     **/
    function __construct($url, $timeout = 1)
    {
        $this->url = $url;
        $this->timeout = $timeout;
    }

    /**
     * Fun��o que detecta se este n� est� v�lido ou n�o. Caso o n� esteja marcado como inativo ele ir� verificar se j� passou o 'timeout' e colocar-lo como ativo.
     *
     * @return bool True indica que o n� � v�lido
     *
     **/
    public function isValid()
    {
        if ($this->active == false) {
            $now = new DateTime();
            $diff = $now->getTimestamp() - $this->lastfailtime->getTimestamp();

            if ($diff >= $this->timeout * 60) {
                $this->active = true;
            }
        }

        return $this->active;
    }

    /**
     * Marcar o n� como n�o ativo, normalmente associado a um erro na grava��o na URL informada.
     *
     **/
    public function fail()
    {
        $this->active = false;
        $this->lastfailtime = new DateTime();
    }
}
