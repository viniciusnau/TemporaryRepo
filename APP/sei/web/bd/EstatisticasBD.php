<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/11/2010 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.17.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class EstatisticasBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }
  
  public function gerarInspecaoProcessosGerados(EstatisticasInspecaoDTO $parObjEstatisticasInspecaoDTO){

    try{
      
      $sql = '';
      $sql .= 'SELECT COUNT(*) as total, uni_ger.id_orgao AS idorgaounidadegeradora, orgao.sigla AS siglaorgaounidadegeradora ';
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_GERADOS){
        $sql .= ',protocolo.id_unidade_geradora AS idunidadegeradora,uni_ger.sigla AS siglaunidadegeradora ';  
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_GERADOS){
        $sql .= ',p.id_tipo_procedimento AS idtipoprocedimentoprocedimento,tpp.nome AS nometipoprocedimentoprocedi001 ';
      }
      
      $sql .= 'FROM protocolo INNER JOIN ';

      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_GERADOS){
        $sql .= '(';
      }
      
      $sql .= 'procedimento p ';
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_GERADOS){
        $sql .= 'INNER JOIN tipo_procedimento tpp  ON p.id_tipo_procedimento=tpp.id_tipo_procedimento ';

        if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_GERADOS && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdTipoProcedimento())){
          $sql .= 'AND tpp.id_tipo_procedimento='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdTipoProcedimento());
        }
        
        $sql .= ') ';
      }

      $sql .= 'ON protocolo.id_protocolo=p.id_procedimento ';
      $sql .= 'INNER JOIN  (unidade uni_ger INNER JOIN orgao ON uni_ger.id_orgao=orgao.id_orgao ';
      
      if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdOrgao())){
        $sql .= 'AND orgao.id_orgao='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdOrgao()).' ';
      }
      
      $sql .= ') ON protocolo.id_unidade_geradora=uni_ger.id_unidade ';
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_GERADOS && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdUnidade())){
        $sql .= 'AND uni_ger.id_unidade='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdUnidade()).' ';
      }
      
      
      $sql .= 'WHERE protocolo.sta_protocolo='.$this->getObjInfraIBanco()->formatarGravacaoStr(ProtocoloRN::$TP_PROCEDIMENTO).' ';
      $sql .= 'AND protocolo.sta_nivel_acesso_global<>'.$this->getObjInfraIBanco()->formatarGravacaoStr(ProtocoloRN::$NA_SIGILOSO).' ';

      if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getDtaInicio()) && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getDtaFim())){
        $sql .= 'AND protocolo.dta_geracao >= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaInicio()).' ';
        $sql .= 'AND protocolo.dta_geracao <= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaFim()).' ';
      }

      $sql .= 'GROUP BY uni_ger.id_orgao, orgao.sigla ';
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_GERADOS){
        $sql .= ',protocolo.id_unidade_geradora, uni_ger.sigla ';  
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_GERADOS){
        $sql .= ', p.id_tipo_procedimento, tpp.nome ';
      }
      

      if ($parObjEstatisticasInspecaoDTO->isOrdStrSiglaOrgao()){
        $sql .= 'ORDER BY orgao.sigla '.$parObjEstatisticasInspecaoDTO->getOrdStrSiglaOrgao();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdStrSiglaUnidade()){
        $sql .= 'ORDER BY uni_ger.sigla '.$parObjEstatisticasInspecaoDTO->getOrdStrSiglaUnidade();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdStrNomeTipoProcedimento()){
        $sql .= 'ORDER BY tpp.nome '.$parObjEstatisticasInspecaoDTO->getOrdStrNomeTipoProcedimento();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdNumQuantidade()){
        $sql .= 'ORDER BY total '.$parObjEstatisticasInspecaoDTO->getOrdNumQuantidade();
      }
      
      $rs = $this->getObjInfraIBanco()->consultarSql($sql);
      
      $arr = array();
      foreach($rs as $item){
        if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_ORGAOS_GERADOS){
    		  $arr[$item['idorgaounidadegeradora']] = $item['total'];
 			  }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_GERADOS){
 				  $arr[$item['idunidadegeradora']] = $item['total'];
 				}else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_GERADOS){
 				  $arr[$item['idorgaounidadegeradora'].'#'.$item['idtipoprocedimentoprocedimento']] = $item['total'];
				}
      }
      
      return $arr;
      
    }catch(Exception $e){
      throw new InfraException('Erro gerando dados de inspe��o para processos gerados.',$e);
    }
  }

  public function gerarInspecaoProcessosTramitacao(EstatisticasInspecaoDTO $parObjEstatisticasInspecaoDTO){

    try{

      $sql = '';
      $sql .= 'SELECT COUNT(DISTINCT atividade.id_protocolo) as total, uni_tram.id_orgao AS idorgaounidadetramitacao, orgao.sigla AS siglaorgaounidadetramitacao ';

      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_TRAMITACAO){
        $sql .= ',atividade.id_unidade AS idunidadetramitacao,uni_tram.sigla AS siglaunidadetramitacao ';
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_TRAMITACAO){
        $sql .= ',proc.id_tipo_procedimento AS idtipoprocedimentoprocedimento,tpp.nome AS nometipoprocedimentoprocedi001 ';
      }

      $sql .= 'FROM atividade INNER JOIN ';

      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_TRAMITACAO){
        $sql .= '(';
      }

      $sql .= 'protocolo prot ';

      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_TRAMITACAO){
        $sql .= 'INNER JOIN (procedimento proc ';
        $sql .= 'INNER JOIN tipo_procedimento tpp ON proc.id_tipo_procedimento=tpp.id_tipo_procedimento ';

        if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdTipoProcedimento())){
          $sql .= 'AND tpp.id_tipo_procedimento='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdTipoProcedimento());
        }

        $sql .= ') ON proc.id_procedimento=prot.id_protocolo) ';
      }

      $sql .= 'ON atividade.id_protocolo=prot.id_protocolo ';

      $sql .= 'INNER JOIN  (unidade uni_tram INNER JOIN orgao ON uni_tram.id_orgao=orgao.id_orgao ';

      if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdOrgao())){
        $sql .= 'AND orgao.id_orgao='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdOrgao()).' ';
      }

      $sql .= ') ON atividade.id_unidade=uni_tram.id_unidade ';

      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_TRAMITACAO && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdUnidade())){
        $sql .= 'AND uni_tram.id_unidade='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdUnidade()).' ';
      }

      $sql .= ' WHERE prot.sta_nivel_acesso_global<>'.$this->getObjInfraIBanco()->formatarGravacaoStr(ProtocoloRN::$NA_SIGILOSO).' ';

      if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getDtaInicio()) && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getDtaFim())){
        $sql .= 'AND (';
        $sql .= '(atividade.dth_abertura <= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaFim()).' AND (atividade.dth_conclusao > '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaFim()).' OR atividade.dth_conclusao is null)) ';
        $sql .= 'OR ';
        $sql .= '(atividade.dth_abertura >= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaInicio()).' and atividade.dth_abertura <= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaFim()).') ';
        $sql .= 'OR ';
        $sql .= '(atividade.dth_conclusao >= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaInicio()).' and atividade.dth_conclusao <= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaFim()).') ';
        $sql .= ') ';
      }else {
        $sql .= ' AND atividade.dth_conclusao is null ';
      }

      $sql .= 'GROUP BY uni_tram.id_orgao, orgao.sigla ';
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_TRAMITACAO){
        $sql .= ',atividade.id_unidade, uni_tram.sigla ';
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_TRAMITACAO){
        $sql .= ', proc.id_tipo_procedimento, tpp.nome ';
      }

      if ($parObjEstatisticasInspecaoDTO->isOrdStrSiglaOrgao()){
        $sql .= 'ORDER BY orgao.sigla '.$parObjEstatisticasInspecaoDTO->getOrdStrSiglaOrgao();
      }

      if ($parObjEstatisticasInspecaoDTO->isOrdStrSiglaUnidade()){
        $sql .= 'ORDER BY uni_tram.sigla '.$parObjEstatisticasInspecaoDTO->getOrdStrSiglaUnidade();
      }

      if ($parObjEstatisticasInspecaoDTO->isOrdStrNomeTipoProcedimento()){
        $sql .= 'ORDER BY tpp.nome '.$parObjEstatisticasInspecaoDTO->getOrdStrNomeTipoProcedimento();
      }

      if ($parObjEstatisticasInspecaoDTO->isOrdNumQuantidade()){
        $sql .= 'ORDER BY total '.$parObjEstatisticasInspecaoDTO->getOrdNumQuantidade();
      }

      $rs = $this->getObjInfraIBanco()->consultarSql($sql);

      $arr = array();
      foreach($rs as $item){
        if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_ORGAOS_TRAMITACAO){
          $arr[$item['idorgaounidadetramitacao']] = $item['total'];
        }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_TRAMITACAO){
          $arr[$item['idunidadetramitacao']] = $item['total'];
        }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_TRAMITACAO){
          $arr[$item['idorgaounidadetramitacao'].'#'.$item['idtipoprocedimentoprocedimento']] = $item['total'];
        }
      }

      return $arr;

    }catch(Exception $e){
      throw new InfraException('Erro gerando dados de inspe��o para processos em tramita��o.',$e);
    }
  }


  public function obterTotalProcessosEmTramitacao(){
    try{      
      $sql = 'select count(distinct id_protocolo) as total from atividade where dth_conclusao is null';
      $rs = $this->getObjInfraIBanco()->consultarSql($sql);
     
      return $rs[0]['total'];
      
      
    }catch(Exception $e){
      throw new InfraException('Erro obtendo total de processos em tramita��o.',$e);
    }
  }

  public function gerarInspecaoDocumentosGeradosRecebidos(EstatisticasInspecaoDTO $parObjEstatisticasInspecaoDTO){
    try{
      
      $sql = '';
      $sql .= 'SELECT COUNT(*) as total, protocolo.sta_protocolo AS staprotocolo, uni_ger.id_orgao AS idorgaounidadegeradora, orgao.sigla AS siglaorgaounidadegeradora ';
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_DOCUMENTOS){
        $sql .= ',protocolo.id_unidade_geradora AS idunidadegeradora,uni_ger.sigla AS siglaunidadegeradora ';  
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS){
        $sql .= ',documento.id_serie AS idseriedocumento,serie.nome AS nomeseriedocumento ';
      }
      
      $sql .= 'FROM protocolo INNER JOIN ';
  
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS){
        $sql .= '(';
      }
      
      $sql .= 'documento ';
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS){
        $sql .= 'INNER JOIN serie  ON documento.id_serie=serie.id_serie ';
        
        if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdSerie())){
          $sql .= 'AND serie.id_serie='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdSerie()).' ';
        }
        
        $sql .= ') ';
      }
      
      $sql .= 'ON protocolo.id_protocolo=documento.id_documento INNER JOIN  (unidade uni_ger INNER JOIN orgao  ON uni_ger.id_orgao=orgao.id_orgao ';
      
      if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdOrgao())){
        $sql .= 'AND orgao.id_orgao='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdOrgao()).' ';
      }
      
      $sql .= ')  ON protocolo.id_unidade_geradora=uni_ger.id_unidade ';
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_DOCUMENTOS && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getNumIdUnidade())){
        $sql .= 'AND uni_ger.id_unidade='.$this->getObjInfraIBanco()->formatarGravacaoNum($parObjEstatisticasInspecaoDTO->getNumIdUnidade()).' ';
      }
  
      $sql .= 'WHERE protocolo.sta_protocolo IN ('.$this->getObjInfraIBanco()->formatarGravacaoStr(ProtocoloRN::$TP_DOCUMENTO_GERADO).','.$this->getObjInfraIBanco()->formatarGravacaoStr(ProtocoloRN::$TP_DOCUMENTO_RECEBIDO).') ';
      $sql .= 'AND protocolo.sta_nivel_acesso_global<>'.$this->getObjInfraIBanco()->formatarGravacaoStr(ProtocoloRN::$NA_SIGILOSO).' '; 
  
      if (!InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getDtaInicio()) && !InfraString::isBolVazia($parObjEstatisticasInspecaoDTO->getDtaFim())){
        $sql .= 'AND protocolo.dta_geracao >= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaInicio()).' ';
        $sql .= 'AND protocolo.dta_geracao <= '.$this->getObjInfraIBanco()->formatarGravacaoDta($parObjEstatisticasInspecaoDTO->getDtaFim()).' ';
      }
      
      $sql .= 'GROUP BY protocolo.sta_protocolo, uni_ger.id_orgao, orgao.sigla ';
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_DOCUMENTOS){
        $sql .= ',protocolo.id_unidade_geradora, uni_ger.sigla ';  
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS){
        $sql .= ', documento.id_serie, serie.nome ';
      }
      
      
      if ($parObjEstatisticasInspecaoDTO->isOrdStrSiglaOrgao()){
        $sql .= 'ORDER BY orgao.sigla '.$parObjEstatisticasInspecaoDTO->getOrdStrSiglaOrgao();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdStrSiglaUnidade()){
        $sql .= 'ORDER BY uni_ger.sigla '.$parObjEstatisticasInspecaoDTO->getOrdStrSiglaUnidade();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdStrNomeSerie()){
        $sql .= 'ORDER BY serie.nome '.$parObjEstatisticasInspecaoDTO->getOrdStrNomeSerie();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdNumQuantidade()){
        $sql .= 'ORDER BY total '.$parObjEstatisticasInspecaoDTO->getOrdNumQuantidade();
      }
      
      if ($parObjEstatisticasInspecaoDTO->isOrdNumQuantidadeGerados()){
        $sql .= 'ORDER BY protocolo.sta_protocolo ASC, total '.$parObjEstatisticasInspecaoDTO->getOrdNumQuantidadeGerados();
      }

      if ($parObjEstatisticasInspecaoDTO->isOrdNumQuantidadeRecebidos()){
        $sql .= 'ORDER BY protocolo.sta_protocolo DESC, total '.$parObjEstatisticasInspecaoDTO->getOrdNumQuantidadeRecebidos();
      }

      $rs = $this->getObjInfraIBanco()->consultarSql($sql);
      
      $arr = array();
      
      if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_ORGAOS_DOCUMENTOS){
        foreach($rs as $item){
          $arr[$item['idorgaounidadegeradora']][ProtocoloRN::$TP_DOCUMENTO_GERADO] = '0';
          $arr[$item['idorgaounidadegeradora']][ProtocoloRN::$TP_DOCUMENTO_RECEBIDO] = '0';
        }
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_DOCUMENTOS){
        foreach($rs as $item){
          $arr[$item['idunidadegeradora']][ProtocoloRN::$TP_DOCUMENTO_GERADO] = '0';
          $arr[$item['idunidadegeradora']][ProtocoloRN::$TP_DOCUMENTO_RECEBIDO] = '0';
        }
      }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS){
        foreach($rs as $item){
          $arr[$item['idorgaounidadegeradora'].'#'.$item['idseriedocumento']][ProtocoloRN::$TP_DOCUMENTO_GERADO] = '0';
          $arr[$item['idorgaounidadegeradora'].'#'.$item['idseriedocumento']][ProtocoloRN::$TP_DOCUMENTO_RECEBIDO] = '0';
        } 
      }
      
      foreach($rs as $item){
        if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_ORGAOS_DOCUMENTOS){
          $arr[$item['idorgaounidadegeradora']][$item['staprotocolo']] = $item['total'];
  		  }else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_UNIDADES_DOCUMENTOS){
  			  $arr[$item['idunidadegeradora']][$item['staprotocolo']] = $item['total'];
  			}else if ($parObjEstatisticasInspecaoDTO->getStrStaTipo()==EstatisticasRN::$TIPO_INSPECAO_TIPOS_DOCUMENTOS){
  			  $arr[$item['idorgaounidadegeradora'].'#'.$item['idseriedocumento']][$item['staprotocolo']] = $item['total'];
  			}
      }
      
      return $arr;
      
    }catch(Exception $e){
      throw new InfraException('Erro gerando dados de inspe��o para documentos gerados.',$e);
    }
    
  }
}
?>