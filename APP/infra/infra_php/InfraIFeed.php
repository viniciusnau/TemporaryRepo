<?php

/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 17/05/2011 - criado por MGA
 *
 * @package infra_php
 */

interface InfraIFeed
{
    public function adicionar(InfraFeedDTO $objInfraFeedDTO);

    public function remover(InfraFeedDTO $objInfraFeedDTO);

    public function indexar();

    public function limpar();

    public function formatarDta($dta);
}

