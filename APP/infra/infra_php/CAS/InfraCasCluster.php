<?php

require_once("InfraCasNode.php");

class InfraCasCluster
{
    private $nodes = array();
    var $nodeindex = -1;
    var $selectedNode;

    /**
     * Construtor indicando a URL para este n� assim como o timeout (minutos) antes de tentar de tirar do estado de falha.
     *
     * @param InfraCasNode $nodes Array de 'InfraCasNode' para este cluster
     *
     **/
    function __construct(array $nodes)
    {
        $this->nodes = $nodes;
        $this->shuffle();
    }

    /**
     * Tenta obter o pr�ximo n� dispon�vel neste cluster
     *
     * @return InfraCasNode Retorna um InfraCasNode, caso n�o existam mais n�s ativos retorna 'null'.
     *
     **/
    private function nextNode()
    {
        $try = 0;
        $count = count($this->nodes);

        do {
            $this->nodeindex += 1;
            if ($this->nodeindex >= $count) {
                $this->nodeindex = 0;
            }

            $cnode = $this->nodes[$this->nodeindex];

            if ($cnode->isValid()) {
                return $cnode;
            }
        } while (++$try < $count);

        return null;
    }

    /**
     * Retorna o n� atual para ser utilizado nas opera��es desta API
     *
     * @return InfraCasNode Retorna um InfraCasNode, caso n�o existam mais n�s ativos retorna 'null'.
     *
     **/
    function getNode()
    {
        if ((!empty($this->selectedNode)) && ($this->selectedNode->active)) {
            return $this->selectedNode;
        }

        $this->selectedNode = $this->nextNode();

        if (empty($this->selectedNode)) {
            return null;
        }

        return $this->selectedNode;
    }

    /**
     * Sinaliza que houve um erro de conex�o no n� atual.
     *
     **/
    function failNode()
    {
        if (empty($this->selectedNode)) {
            return;
        }

        $this->selectedNode->fail();
    }

    /**
     * Executa uma opera��o de ordernar de forma aleat�ria os n�s deste cluster para evitar acessos sequenciais ao mesmo n� f�sico do Swarm
     *
     **/
    function shuffle()
    {
        if (isset($this->nodes)) {
            shuffle($this->nodes);
        }
    }

    public function getActiveNodes()
    {
        $arrStrActiveNodes = array();

        foreach ($this->nodes as $node) {
            if ((!empty($node)) && ($node->active)) {
                $arrStrActiveNodes[] = $node;
            }
        }
        return $arrStrActiveNodes;
    }
}
