<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/07/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class HistoricoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  public function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }


  /*
  Basicamente, existem 4 cen�rios que um hist�rico novo ou um com as datas inicial/final alteradas podem se enquadrar. quando comparado com os outros historicos cadastrados:

  1. Hist�rico Englobado: o per�odo do hist�rico fica englobado em outro historico existente:
          existente
     |----------------|
        novo/alterado
          |-----|

  2. Hist�rico Englobador: o per�odo do hist�rico engloba outros historicos existentes:
          existentes
        |-----||-----|
        novo/alterado
     |-------------------|

  3. Hist�rico Anterior: a data final do hist�rico sobrepoe a data inicial de outro existente:
               existente
             |-----------|
        novo/alterado
       |----------|

  4. Hist�rico Posterior: a data inicial do hist�rico sobrepoe a data final de outro existente:
         existente
       |-----------|
              novo/alterado
              |----------|

  Obs.: nos exemplos acima, n�o s�o exibidos outros historicos existentes, lembrando que o historico mais recente, que tem a data final nula, corresponde ao org�o vigente.

  O m�todo chama um m�todo para tratar cada um dos 4 cen�rios.
  Se executados nesta ordem, n�o � necess�rio identificar em qual cen�rio o hist�rico cadastrado/alterado se enquadra, pois se esse hist�rico se enquadrar no cen�rio 1, por exemplo, ser� ajustado no primeiro m�todo chamado, e os outros 3 n�o ter�o a��o

 */
  public function ajustarHistoricosBanco($objHistoricoDTO){
    //$this->tratarHistoricoIgual($objHistoricoDTO);
    $this->tratarHistoricoEnglobado($objHistoricoDTO);
    $this->tratarHistoricoEnglobador($objHistoricoDTO);
    $this->tratarHistoricoAnterior($objHistoricoDTO);
    $this->tratarHistoricoPosterior($objHistoricoDTO);
  }

  /*
  Tratamento para quando um hist�rico � alterado e a nova data inicial fica maior que a data inicial atual, ou a nova data final fica menor que a data final atual
  Nesses casos, a data final do historico anterior deve ser prolongada e/ou a data inicial do historico posterior deve ser antecipada
  Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente

        anter.  alterado  post.
     1.|-----||---------||-----|
     2.|-----|  |-----|  |-----|
     3.|-------||-----||-------|

        anter.  alterado  post.
     1.|-----||---------||-----|
     2.|-----|  |-------||-----|
     3.|-------||-------||-----|

        alterado  post.
     1.|---------||-----|
     2.|-----|    |-----|
     3.|-----||---------|
 */
  public function tratarHistoricoAlteracao($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());
    //testa se o metodo foi chamado pelo cadastrado/altera��o um org�o
    if($objHistoricoDTO->isSetBolOrigemSIP() && $objHistoricoDTO->getBolOrigemSIP()){
      $objHistoricoBD->alterar($objHistoricoDTO);
      //senao, � do cadastro/altera��o de historicos em si
    }else{
      $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

      $objHistoricoDTO_Banco = $this->retornaHistoricoDTOIdHistorico($objHistoricoDTO);
      $objHistoricoDTO_Banco->retTodos();
      $objHistoricoDTO_Banco = $objHistoricoBD->consultar($objHistoricoDTO_Banco);

      //busca data inicial do primeiro historico existente desse orgao/unidade, que ser� utilizada depois da alteracao
      $dtaInicio = $this->consultarDataInicioPrimeiroHistorico($objHistoricoDTO_Banco);

      //testa se a data inicial informada � anterior a data inicial do historico mais antigo, o que nao pode ocorrer
      if(InfraData::compararDatasSimples($dtaInicio, $objHistoricoDTO->getDtaInicio()) == -1){
        (new InfraException())->lancarValidacao("Data Inicial deve ser igual ou posterior a ".$dtaInicio);
      }

      if(InfraData::compararDatasSimples($objHistoricoDTO_Banco->getDtaInicio(),$objHistoricoDTO->getDtaInicio()) == 1){
        $objHistoricoDTO_Anterior = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO_Banco);
        $objHistoricoDTO_Anterior->retTodos();
        $objHistoricoDTO_Anterior->setDtaFim($objHistoricoDTO_Banco->getDtaInicio(),InfraDTO::$OPER_MENOR);
        $objHistoricoDTO_Anterior->setOrdDtaFim(InfraDTO::$TIPO_ORDENACAO_DESC);
        $objHistoricoDTO_Anterior->setNumMaxRegistrosRetorno(1);

        $objHistoricoDTO_Anterior = $objHistoricoBD->consultar($objHistoricoDTO_Anterior);

        if($objHistoricoDTO_Anterior != null) {
          $objHistoricoDTO_Anterior->setDtaFim($objHistoricoDTO->getDtaInicio());
          $objHistoricoBD->alterar($objHistoricoDTO_Anterior);
         //se n�o tem historico anterior, entao est� sendo alterado o primeiro, e a data de inicio n�o pode ser alterada
        }else{
          $objHistoricoDTO->setDtaInicio($dtaInicio);
        }
      }
      if(InfraData::compararDatasSimples($objHistoricoDTO_Banco->getDtaFim(),$objHistoricoDTO->getDtaFim()) == -1){
        $objHistoricoDTO_Posterior = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO_Banco);
        $objHistoricoDTO_Posterior->retTodos();
        $objHistoricoDTO_Posterior->setDtaInicio($objHistoricoDTO_Banco->getDtaFim(),InfraDTO::$OPER_MAIOR);
        $objHistoricoDTO_Posterior->setOrdDtaInicio(InfraDTO::$TIPO_ORDENACAO_ASC);
        $objHistoricoDTO_Posterior->setNumMaxRegistrosRetorno(1);

        $objHistoricoDTO_Posterior = $objHistoricoBD->consultar($objHistoricoDTO_Posterior);
        $objHistoricoDTO_Posterior->setDtaInicio(InfraData::calcularData(1,InfraData::$UNIDADE_DIAS,InfraData::$SENTIDO_ADIANTE,$objHistoricoDTO->getDtaFim()));
        $objHistoricoBD->alterar($objHistoricoDTO_Posterior);
      }
      //primeiro � chamado um m�todo para verificar se o historico cadastrado/alterado tem o per�odo exatamente igual a outro j� existente
      $this->tratarHistoricoIgual($objHistoricoDTO);
      //altera no BD
      $objHistoricoBD->alterar($objHistoricoDTO);
      //trata os historicos existentes, em relacao �s datas de inicio e de fim
      $this->ajustarHistoricosBanco($objHistoricoDTO);
    }
  }

  /*
  Tratamento para quando um hist�rico � cadastrado e a data final fica anterior ao primeiro historico (mais antigo) j� existente
  Nesse caso, a data final do primeiro historico deve ser prolongada
  Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente)

       cadastrado   posterior/primeiro
     1.|--------|      |---------|
     2.|--------||---------------|
 */
  public function tratarHistoricoInclusao($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());
    //testa se o metodo foi chamado pelo cadastrado/altera��o um org�o
    if($objHistoricoDTO->isSetBolOrigemSIP() && $objHistoricoDTO->getBolOrigemSIP()){
      $ret = $objHistoricoBD->cadastrar($objHistoricoDTO);
      //senao, � do cadastro/altera��o de historicos em si
    }else{
      $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

      $objHistoricoDTO_Primeiro = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
      $objHistoricoDTO_Primeiro->retTodos();
      $objHistoricoDTO_Primeiro->setOrdDtaInicio(InfraDTO::$TIPO_ORDENACAO_ASC);
      $objHistoricoDTO_Primeiro->setNumMaxRegistrosRetorno(1);

      $objHistoricoDTO_Primeiro = $objHistoricoBD->consultar($objHistoricoDTO_Primeiro);

      //busca data inicial do primeiro historico existente desse orgao/unidade
      $dtaInicio = $this->consultarDataInicioPrimeiroHistorico($objHistoricoDTO);

      //testa se a data inicial informada � anterior a data inicial do historico mais antigo, o que nao pode ocorrer
      if(InfraData::compararDatasSimples($dtaInicio, $objHistoricoDTO->getDtaInicio()) == -1){
        (new InfraException())->lancarValidacao("Data Inicial deve ser igual ou posterior a ".$dtaInicio);
      }

      if(InfraData::compararDataHorasSimples($objHistoricoDTO->getDtaFim(), $objHistoricoDTO_Primeiro->getDtaInicio()) == 1){
        $objHistoricoDTO_Primeiro->setDtaInicio(InfraData::calcularData(1,InfraData::$UNIDADE_DIAS,InfraData::$SENTIDO_ADIANTE,$objHistoricoDTO->getDtaFim()));
        $objHistoricoBD->alterar($objHistoricoDTO_Primeiro);
      }
      //primeiro � chamado um m�todo para verificar se o historico cadastrado/alterado tem o per�odo exatamente igual a outro j� existente
      $this->tratarHistoricoIgual($objHistoricoDTO);
      //cadastra no BD
      $ret = $objHistoricoBD->cadastrar($objHistoricoDTO);
      //trata os historicos existentes, em relacao �s datas de inicio e de fim
      $this->ajustarHistoricosBanco($objHistoricoDTO);
    }
    return $ret;
  }

  /*
  Tratamento para quando um hist�rico � excluido
  Nesse caso, a data final do historico posterior deve ser antecipada
  Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente)

       anter.   excluido  post.
     1.|-----||---------||-----|
     2.|-----|           |-----|
     3.|-----||----------------|

         excluido  post.
     1.|---------||-----|
     2.|----------------|

 */
  public function tratarHistoricoExclusao($objHistoricoDTO){
    if(!($objHistoricoDTO->isSetBolOrigemSIP() && $objHistoricoDTO->getBolOrigemSIP())) {
      $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

      $objHistoricoDTO_Banco = $this->retornaHistoricoDTOIdHistorico($objHistoricoDTO);
      $objHistoricoDTO_Banco->retTodos();

      $objHistoricoDTO_Banco = $objHistoricoBD->consultar($objHistoricoDTO_Banco);

      $objHistoricoDTO_Posterior = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO_Banco);

      //busca data inicial do primeiro historico existente desse orgao/unidade, que ser� utilizada depois da alteracao
      $dtaInicio = $this->consultarDataInicioPrimeiroHistorico($objHistoricoDTO_Banco);
      $objHistoricoDTO_Posterior->retTodos();
      $objHistoricoDTO_Posterior->setDtaInicio($objHistoricoDTO_Banco->getDtaFim(),InfraDTO::$OPER_MAIOR);
      $objHistoricoDTO_Posterior->setOrdDtaInicio(InfraDTO::$TIPO_ORDENACAO_ASC);
      $objHistoricoDTO_Posterior->setNumMaxRegistrosRetorno(1);

      $objHistoricoDTO_Posterior = $objHistoricoBD->consultar($objHistoricoDTO_Posterior);

      //testa se a data inicial do primeiro historico � igual a data inicial do historico que est� sendo excluindo
      //se for, significa que � o primeiro registro que est� sendo excluindo, entao usa a data inicial do primeiro historico (setada na carga inicial de historicos) no segundo historico (que agora ser� o primeiro)
      if(InfraData::compararDatasSimples($dtaInicio,$objHistoricoDTO_Banco->getDtaInicio()) == 0){
        $objHistoricoDTO_Posterior->setDtaInicio($dtaInicio);
      //senao, apenas 'puxa' a data do historico seguinte ao que est� sendo excluido
      }else {
        $objHistoricoDTO_Posterior->setDtaInicio($objHistoricoDTO_Banco->getDtaInicio());
      }

      $objHistoricoBD->alterar($objHistoricoDTO_Posterior);

    }
  }

  /*
    Retorna a data inicial do historico mais antigo (primeiro).
    O primeiro historico de cada orgao/unidade foi cadastrado em uma carga inicial, na qual foi considerada a data de abertura mais antiga das atividades como data inicial, a qual deve ser mantida
    Contudo, caso o historico mais antigo (primeiro) seja excluido, ou tenha a data inicial alterada para uma posterior a sua atual, poderia ficar inconsistente
    Ent�o esse m�todo verifica se a data inicial do primeiro hist�rico corresponde a data inicial que existia antes; caso n�o seja, altera a data inicial para a de antes.
    Assim, caso o primeiro historico tenha a data inicial alterada, ela � corrigida; caso tenha sido excluido, a data inicil do historico posterior a esse � alterada
    Essas acoes sao realizadas mais alem, depois da chamada desse metodo de consultar a data, na exclusao e alteracao

    1.  primeiro   segundo
       |---------||---------|
        excluido   segundo
    2.            |---------|
        segundo (que agora � o primeiro
    3. |--------------------|


    1.  primeiro   segundo
       |---------||---------|
        alterado   segundo
    2.     |-----||---------|
        primeiro   segundo obs.: esse exemplo n�o faz sentido, mas caso outras informacoes do historico sejam alteradas, incluindo a data inicial (que � mantida), as outras informacoes s�o atualizadas
    3. |---------||---------|
   *
   */

  public function consultarDataInicioPrimeiroHistorico($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

    $objHistoricoDTO_Primeiro = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
    $objHistoricoDTO_Primeiro->retTodos();
    $objHistoricoDTO_Primeiro->setOrdDtaInicio(InfraDTO::$TIPO_ORDENACAO_ASC);
    $objHistoricoDTO_Primeiro->setNumMaxRegistrosRetorno(1);
    $objHistoricoDTO_Primeiro = $objHistoricoBD->consultar($objHistoricoDTO_Primeiro);

    return $objHistoricoDTO_Primeiro->getDtaInicio();
  }


  /*
    Tratamento para quando um novo hist�rico cadastrado possui as mesmas data inicial e data final de outro j� existente
    Nesse caso, os campos sigla e descri��o s�o atualizados no registro j� existente)

    1. existente
       |---------|
           novo
       |---------|

    2. existente (atualizado)
       |---------|

   */
  public function tratarHistoricoIgual($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

    $objHistoricoDTO_Igual = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
    $this->adicionarCriterioNumIdHistorico($objHistoricoDTO, $objHistoricoDTO_Igual);
    $objHistoricoDTO_Igual->retTodos();

    $objHistoricoDTO_Igual->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
      array($objHistoricoDTO->getDtaInicio(), $objHistoricoDTO->getDtaFim()),
      array(InfraDTO::$OPER_LOGICO_AND));
    $objHistoricoDTO_Igual = $objHistoricoBD->consultar($objHistoricoDTO_Igual);
    if($objHistoricoDTO_Igual != null){
      $objHistoricoBD->excluir($objHistoricoDTO_Igual);
    }
  }

  /*
    Tratamento para quando um hist�rico � cadastrado/alterado e a data final fica maior que a data inicial de outro historico posterior exitente
    Nesse caso, a data inicial do historico posterior deve ser prolongada
    Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente)

    1.          posterior
               |--------|
       novo/alterado
       |------------|

    2.          posterior
                     |--|
       novo/alterado
       |------------|

   */
  public function tratarHistoricoAnterior($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

    $objHistoricoDTO_Posterior = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
    $this->adicionarCriterioNumIdHistorico($objHistoricoDTO, $objHistoricoDTO_Posterior);
    $objHistoricoDTO_Posterior->retTodos();

    $objHistoricoDTO_Posterior->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MENOR_IGUAL, InfraDTO::$OPER_MAIOR),
      array($objHistoricoDTO->getDtaFim(), $objHistoricoDTO->getDtaFim()),
      array(InfraDTO::$OPER_LOGICO_AND),"c1");
    $objHistoricoDTO_Posterior->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MENOR_IGUAL, InfraDTO::$OPER_IGUAL),
      array($objHistoricoDTO->getDtaFim(), null),
      array(InfraDTO::$OPER_LOGICO_AND),"c2");
    $objHistoricoDTO_Posterior->agruparCriterios(array('c1','c2'),InfraDTO::$OPER_LOGICO_OR);
      $objHistoricoDTO_Posterior = $objHistoricoBD->consultar($objHistoricoDTO_Posterior);
    if($objHistoricoDTO_Posterior != null){
      $objHistoricoDTO_Posterior->setDtaInicio(InfraData::calcularData(1,InfraData::$UNIDADE_DIAS,InfraData::$SENTIDO_ADIANTE,$objHistoricoDTO->getDtaFim()));
      $objHistoricoBD->alterar($objHistoricoDTO_Posterior);
    }
  }

  /*
    Tratamento para quando um hist�rico � cadastrado/alterado e a data inicial fica menor que a data final de outro historico anterior exitente
    Nesse caso, a data final do historico anterior deve ser antecipada
    Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente)

    1. anterior
       |--------|
             novo/alterado
             |------------|

    1. anterior
       |----|
             novo/alterado
             |------------|

   */
  public function tratarHistoricoPosterior($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

    $objHistoricoDTO_Anterior = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
    $this->adicionarCriterioNumIdHistorico($objHistoricoDTO, $objHistoricoDTO_Anterior);
    $objHistoricoDTO_Anterior->retTodos();

    $objHistoricoDTO_Anterior->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MENOR, InfraDTO::$OPER_MAIOR_IGUAL),
      array($objHistoricoDTO->getDtaInicio(), $objHistoricoDTO->getDtaInicio()),
      array(InfraDTO::$OPER_LOGICO_AND),'c1');
    $objHistoricoDTO_Anterior->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MENOR, InfraDTO::$OPER_IGUAL),
      array($objHistoricoDTO->getDtaInicio(), null),
      array(InfraDTO::$OPER_LOGICO_AND),"c2");
    $objHistoricoDTO_Anterior->agruparCriterios(array('c1','c2'),InfraDTO::$OPER_LOGICO_OR);
    $objHistoricoDTO_Anterior = $objHistoricoBD->consultar($objHistoricoDTO_Anterior);
    if($objHistoricoDTO_Anterior != null){
      $objHistoricoDTO_Anterior->setDtaFim(InfraData::calcularData(1,InfraData::$UNIDADE_DIAS,InfraData::$SENTIDO_ATRAS,$objHistoricoDTO->getDtaInicio()));

      $objHistoricoBD->alterar($objHistoricoDTO_Anterior);
    }
  }

  /*
  Tratamento para quando um historico novo/alterado � englobado por outro
  Nesse caso, o hist�rico englobador � dividido em 2: um que ficar� anterior ao hist�rico novo/alterado (englobado) e outro que ficar� posterior ao novo/alterado (englobado)
  No algoritmo, o englobador � replicado, e depois os m�todos tratarHistoricoAnterior e tratarHistoricoPosterior s�o chamados, um para o englobador original e outro para o englobador replicado
  Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente)

     1.    englobador
        |-------------|
            englobado
            |-----|

     2.    englobador
        |--|
            englobado
            |-----|

    3.  englobador (original)
        |--|
        englobador replica
        |-------------|
            englobado
            |-----|

  4.  englobador (original)
        |--|
        englobador replica
                   |--|
            englobado
            |-----|

 */
  public function tratarHistoricoEnglobado($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

    $objHistoricoDTO_Engloba = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
    $this->adicionarCriterioNumIdHistorico($objHistoricoDTO, $objHistoricoDTO_Engloba);
    $objHistoricoDTO_Engloba->retTodos();

    $objHistoricoDTO_Engloba->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MENOR, InfraDTO::$OPER_MAIOR),
      array($objHistoricoDTO->getDtaInicio(), $objHistoricoDTO->getDtaFim()),
      array(InfraDTO::$OPER_LOGICO_AND),"c1");
    $objHistoricoDTO_Engloba->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MENOR, InfraDTO::$OPER_IGUAL),
      array($objHistoricoDTO->getDtaInicio(),  null),
      array(InfraDTO::$OPER_LOGICO_AND), "c2");
    $objHistoricoDTO_Engloba->agruparCriterios(array('c1','c2'),InfraDTO::$OPER_LOGICO_OR);
    $objHistoricoDTO_Engloba = $objHistoricoBD->consultar($objHistoricoDTO_Engloba);
    if($objHistoricoDTO_Engloba != null) {
      $objHistoricoDTO_Novo = clone($objHistoricoDTO_Engloba);
      $this->adicionarCriterioNumIdHistorico(null, $objHistoricoDTO_Novo);
      $this->tratarHistoricoAnterior($objHistoricoDTO);
      $objHistoricoBD->cadastrar($objHistoricoDTO_Novo);
      $this->tratarHistoricoPosterior($objHistoricoDTO);
    }
  }

  /*
  Tratamento para quando um ou mais hist�ricos s�o englobados por um outro novo/alterado
  Nesse caso, os historicos englobados s�o exclu�dos
  Depois, o hist�rico novo/alterado (o englobador) � tratado com os m�todos tratarHistoricoAnterior e tratarHistoricoPosterior, para ajustar as datas do historico anterior e do posterior
  Obs.: sempre haver� um historico posterior (pelo menos o historico que representa o orgao/unidade vigente)

     1.  anter.  englobado  post.
         |-----||---------||-----|
               novo/alterado
            |-----------------|

     2.  anter.  englobado  post.
         |-----|           |-----|
               novo/alterado
            |-----------------|

   3./4. anter.  englobado    post.
         |-|                   |-|
               novo/alterado
            |-----------------|

 */
  public function tratarHistoricoEnglobador($objHistoricoDTO){
    $objHistoricoBD = new HistoricoBD($this->getObjInfraIBanco());

    $objHistoricoDTO_Englobado = $this->retornaHistoricoDTOIdOrigem($objHistoricoDTO);
    $this->adicionarCriterioNumIdHistorico($objHistoricoDTO, $objHistoricoDTO_Englobado);
    $objHistoricoDTO_Englobado->retTodos();

    $objHistoricoDTO_Englobado->adicionarCriterio(
      array('Inicio', 'Fim'),
      array(InfraDTO::$OPER_MAIOR_IGUAL, InfraDTO::$OPER_MENOR_IGUAL),
      array($objHistoricoDTO->getDtaInicio(), $objHistoricoDTO->getDtaFim()),
      array(InfraDTO::$OPER_LOGICO_AND));
    $arrObjHistoricoDTO_Englobado = $objHistoricoBD->listar($objHistoricoDTO_Englobado);
    if(count($arrObjHistoricoDTO_Englobado)){
      foreach ($arrObjHistoricoDTO_Englobado as $objHistoricoDTO_Englobado){
        $objHistoricoBD->excluir($objHistoricoDTO_Englobado);
      }
      $this->tratarHistoricoAnterior($objHistoricoDTO);
      $this->tratarHistoricoPosterior($objHistoricoDTO);
    }
  }

  private function retornaHistoricoDTOIdOrigem($objHistoricoDTO){
    if($objHistoricoDTO instanceof OrgaoHistoricoDTO){
      $objHistoricoDTO_Novo = new OrgaoHistoricoDTO();
      $objHistoricoDTO_Novo->setNumIdOrgao($objHistoricoDTO->getNumIdOrgao());
    }else{
      $objHistoricoDTO_Novo = new UnidadeHistoricoDTO();
      $objHistoricoDTO_Novo->setNumIdUnidade($objHistoricoDTO->getNumIdUnidade());
    }
    return $objHistoricoDTO_Novo;
  }

  private function retornaHistoricoDTOIdHistorico($objHistoricoDTO){
    if($objHistoricoDTO instanceof OrgaoHistoricoDTO){
      $objHistoricoDTO_Novo = new OrgaoHistoricoDTO();
      $objHistoricoDTO_Novo->setNumIdOrgaoHistorico($objHistoricoDTO->getNumIdOrgaoHistorico());
    }else{
      $objHistoricoDTO_Novo = new UnidadeHistoricoDTO();
      $objHistoricoDTO_Novo->setNumIdUnidadeHistorico($objHistoricoDTO->getNumIdUnidadeHistorico());
    }
    return $objHistoricoDTO_Novo;
  }

  private function adicionarCriterioNumIdHistorico($objHistoricoDTO_Origem, $objHistoricoDTO_Destino){
    if($objHistoricoDTO_Destino instanceof OrgaoHistoricoDTO){
      if($objHistoricoDTO_Origem == null){
        $objHistoricoDTO_Destino->setNumIdOrgaoHistorico(null);
      }else  if ($objHistoricoDTO_Origem->isSetNumIdOrgaoHistorico()) {
        $objHistoricoDTO_Destino->setNumIdOrgaoHistorico($objHistoricoDTO_Origem->getNumIdOrgaoHistorico(), InfraDTO::$OPER_DIFERENTE);
      }
    }else{
      if($objHistoricoDTO_Origem == null){
        $objHistoricoDTO_Destino->setNumIdUnidadeHistorico(null);
      }else if ($objHistoricoDTO_Origem->isSetNumIdUnidadeHistorico()) {
        $objHistoricoDTO_Destino->setNumIdUnidadeHistorico($objHistoricoDTO_Origem->getNumIdUnidadeHistorico(), InfraDTO::$OPER_DIFERENTE);
      }
    }
  }

  public function aplicar($strEntidade, $arrObjInfraDTO, $strAtributoData, $strAtributoId, $strAtributoSigla, $strAtributoDescricao){

    try {
      if (InfraArray::contar($arrObjInfraDTO)) {

        $strClasseRNHistorico = $strEntidade.'HistoricoRN';
        $strClasseDTOHistorico = $strEntidade.'HistoricoDTO';
        $strAtributoIdHistorico = 'Id'.$strEntidade;

        //ordena por data de abertura, para pegar em seguida a data menor/primeira/mais antiga e a data maior/ultima/mais recente
        $arrDthAbertura = InfraArray::converterArrInfraDTO($arrObjInfraDTO, $strAtributoData);
        $dtaAbertura_Menor = substr(InfraData::obterMenor($arrDthAbertura), 0, 10);
        $dtaAbertura_Maior = substr(InfraData::obterMaior($arrDthAbertura), 0, 10);

        //busca os historicos das unidades, filtrando apenas os existentes no intervalo de datas e pelas diferentes unidades presentes na listagem

        $reflectionClass = new ReflectionClass($strClasseDTOHistorico);
        $objHistoricoDTO = $reflectionClass->newInstance();

        $objHistoricoDTO->retTodos();
        $objHistoricoDTO->set($strAtributoIdHistorico, InfraArray::converterArrInfraDTO(InfraArray::distinctArrInfraDTO($arrObjInfraDTO, $strAtributoId), $strAtributoId), InfraDTO::$OPER_IN);

        $objHistoricoDTO->adicionarCriterio(
            array('Fim', 'Fim'),
            array(InfraDTO::$OPER_MAIOR_IGUAL, InfraDTO::$OPER_IGUAL),
            array($dtaAbertura_Menor, null),
            InfraDTO::$OPER_LOGICO_OR, 'cDataFim');
        $objHistoricoDTO->adicionarCriterio(
            array('Inicio'),
            array(InfraDTO::$OPER_MENOR_IGUAL),
            array($dtaAbertura_Maior),
            null, 'cDataInicio');
        $objHistoricoDTO->agruparCriterios(array('cDataInicio', 'cDataFim'), InfraDTO::$OPER_LOGICO_AND);

        //busca em ordem decrescente de data de inicio, pois depois busca o primeiro historico com inicio anterior a data do registro, o qual ser� o historico considerado para esse registro
        $objHistoricoDTO->setOrdDtaInicio(InfraDTO::$TIPO_ORDENACAO_DESC);

        $reflectionClass = new ReflectionClass($strClasseRNHistorico);
        $objHistoricoRN = $reflectionClass->newInstance();

        $arrObjHistorico = $objHistoricoRN->listar($objHistoricoDTO);

        //indexa os historicos pela unidade, para facilitar a busca em cada registro
        $arrHistoricoMap = InfraArray::indexarArrInfraDTO($arrObjHistorico, $strAtributoIdHistorico, true);

        foreach ($arrObjInfraDTO as $objInfraDTO) {

          //busca os historicos da unidade dessa atividade
          $arrObjHistorico = $arrHistoricoMap[$objInfraDTO->get($strAtributoId)];
          $dtaInicio = substr($objInfraDTO->get($strAtributoData), 0, 10);

          foreach ($arrObjHistorico as $objHistoricoDTO) {
            $dtaAbertura = substr($objHistoricoDTO->getDtaInicio(), 0, 10);
            //testa se a data de inicio do historico � anterior a data da atividade... se for, esse � historico a ser considerado, pois os historicos estao ordenados em ordem decrescente de data inicial
            if (InfraData::compararDatasSimples($dtaAbertura, $dtaInicio) >= 0) {
              $objInfraDTO->set($strAtributoSigla, $objHistoricoDTO->getStrSigla());
              $objInfraDTO->set($strAtributoDescricao, $objHistoricoDTO->getStrDescricao());

              //tem que parar de percorrer, pois o primeiro registrado encontrado � o que interessa
              break;
            }
          }
        }
      }
    }catch (Exception $e){
      throw new InfraException('Erro aplicando hist�rico.', $e);
    }
  }

}
