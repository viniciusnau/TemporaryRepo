<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/01/2008 - criado por marcio_db
*
* Vers�o do Gerador de C�digo: 1.12.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class UsuarioINT extends InfraINT {

  public static function montarSelectPorUnidadeRI0811($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade){
    
  	$objUnidadeDTO = new UnidadeDTO();
    $objUnidadeDTO->setNumIdUnidade($numIdUnidade);

    $objUsuarioRN = new UsuarioRN();
    $arrObjUsuarioDTO = $objUsuarioRN->listarPorUnidadeRN0812($objUnidadeDTO);

    foreach($arrObjUsuarioDTO as $objUsuarioDTO){
      $objUsuarioDTO->setStrSigla($objUsuarioDTO->getStrSigla().' - '.$objUsuarioDTO->getStrNome());
    }
    
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUsuarioDTO, 'IdUsuario', 'Sigla');
  }

	public static function montarSelectNomePorUnidade($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade){

		$objUnidadeDTO = new UnidadeDTO();
		$objUnidadeDTO->setNumIdUnidade($numIdUnidade);

		$objUsuarioRN = new UsuarioRN();
		$arrObjUsuarioDTO = $objUsuarioRN->listarPorUnidadeRN0812($objUnidadeDTO);
		InfraArray::ordenarArrInfraDTO($arrObjUsuarioDTO,'Nome',InfraArray::$TIPO_ORDENACAO_ASC);

		foreach($arrObjUsuarioDTO as $objUsuarioDTO){
			$objUsuarioDTO->setStrNome($objUsuarioDTO->getStrNome().' ('.$objUsuarioDTO->getStrSigla().')');
		}

		return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUsuarioDTO, 'IdUsuario', 'Nome');
	}

  public static function montarSelectPorUnidadeOutros($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUsuario){
    
  	$objUnidadeDTO = new UnidadeDTO();
    $objUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

    $objUsuarioRN = new UsuarioRN();
    $arrObjUsuarioDTO = $objUsuarioRN->listarPorUnidadeRN0812($objUnidadeDTO);

    $arr = array();
    foreach($arrObjUsuarioDTO as $objUsuarioDTO){
    	if ($objUsuarioDTO->getNumIdUsuario()!=$numIdUsuario){
        $objUsuarioDTO->setStrSigla($objUsuarioDTO->getStrSigla().' - '.$objUsuarioDTO->getStrNome());
        $arr[] = $objUsuarioDTO;
    	}
    }
    
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arr, 'IdUsuario', 'Sigla');
  }

  public static function montarSelectSiglaSistema($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdOrgao = ''){

    $objUsuarioDTO = new UsuarioDTO();
    $objUsuarioDTO->retNumIdUsuario();
    $objUsuarioDTO->retStrSigla();

    if ($numIdOrgao!==''){
      $objUsuarioDTO->setNumIdOrgao($numIdOrgao);
    }
    $objUsuarioDTO->setStrStaTipo(UsuarioRN::$TU_SISTEMA);
    $objUsuarioDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUsuarioRN = new UsuarioRN();
    $arrObjUsuarioDTO = $objUsuarioRN->listarRN0490 ($objUsuarioDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUsuarioDTO, 'IdUsuario', 'Sigla');
  }

  public static function autoCompletarUsuarios($numIdOrgao, $strPalavrasPesquisa, $bolOutros, $bolExternos, $bolSiglaNome, $bolInativos){

    $objUsuarioDTO = new UsuarioDTO();

    if ($bolInativos){
      $objUsuarioDTO->setBolExclusaoLogica(false);
    }

    $objUsuarioDTO->retNumIdContato();
    $objUsuarioDTO->retNumIdUsuario();
    $objUsuarioDTO->retStrSigla();
    $objUsuarioDTO->retStrNome();
    $objUsuarioDTO->retStrSiglaOrgao();

    $objUsuarioDTO->setStrPalavrasPesquisa($strPalavrasPesquisa);

    if (!InfraString::isBolVazia($numIdOrgao)){
      $objUsuarioDTO->setNumIdOrgao($numIdOrgao);
    }

    if ($bolOutros){
      $objUsuarioDTO->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario(),InfraDTO::$OPER_DIFERENTE);
    }

    if (!$bolExternos){
      $objUsuarioDTO->setStrStaTipo(UsuarioRN::$TU_SIP);
    }else{
      $objUsuarioDTO->setStrStaTipo(UsuarioRN::$TU_EXTERNO);
    }

    $objUsuarioDTO->setNumMaxRegistrosRetorno(50);

    $objUsuarioDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUsuarioRN = new UsuarioRN();
    $arrObjUsuarioDTO = $objUsuarioRN->pesquisar($objUsuarioDTO);

    if ($bolSiglaNome) {
      $arrTemp = array();
      foreach($arrObjUsuarioDTO as $objUsuarioDTO){
        $strChave = strtolower($objUsuarioDTO->getStrNome().'-'.$objUsuarioDTO->getStrSigla());
        if (!isset($arrTemp[$strChave])){
          $arrTemp[$strChave] = array($objUsuarioDTO);
        }else{
          $arrTemp[$strChave][] = $objUsuarioDTO;
        }
      }

      foreach($arrTemp as $arr){
        if (count($arr) == 1){
          $arr[0]->setStrSigla($arr[0]->getStrNome() . ' (' . $arr[0]->getStrSigla() . ')');
        }else{
          foreach($arr as $dto){
            $dto->setStrSigla($dto->getStrNome() . ' (' . $dto->getStrSigla() . ' / '.$dto->getStrSiglaOrgao().')');
          }
        }
      }
    }

    return $arrObjUsuarioDTO;
  }


  public static function montarSelectUnidadesPermissao($numIdUsuario,$numIdSelecionado=null,$strSinTodos=null){
  	
    $objInfraSip = new InfraSip(SessaoSEI::getInstance());

    $ret = array_values($objInfraSip->carregarUnidades(SessaoSEI::getInstance()->getNumIdSistema(),$numIdUsuario));
    
    InfraArray::ordenarArray($ret,InfraSip::$WS_UNIDADE_SIGLA,InfraArray::$TIPO_ORDENACAO_ASC);
    
    $arrUnidades = array();
    
    foreach($ret as $uni){
    	//somente unidades ativas, todas as unidades de outros usu�rios, se for o usu�rio atual n�o mostra a unidade atual
    	if ($uni[InfraSip::$WS_UNIDADE_SIN_ATIVO]=='S'){
    	  if($strSinTodos==='S' || ($numIdUsuario!=SessaoSEI::getInstance()->getNumIdUsuario() ||$uni[InfraSip::$WS_UNIDADE_ID] != SessaoSEI::getInstance()->getNumIdUnidadeAtual())) {
          $arrUnidades[$uni[InfraSip::$WS_UNIDADE_ID]] = $uni[InfraSip::$WS_UNIDADE_SIGLA] . ' - ' . $uni[InfraSip::$WS_UNIDADE_DESCRICAO];
        }
    	}
    }
    
    if (InfraArray::contar($arrUnidades)==1){
    	$strPrimeiroItemValor = null;
    	$strPrimeiroItemDescricao = null;
    }else{
    	$strPrimeiroItemValor = 'null';
    	$strPrimeiroItemDescricao = ' ';
    }

    if (count($arrUnidades)) {
      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->setBolExclusaoLogica(false);
      $objUnidadeDTO->retNumIdUnidade();
      $objUnidadeDTO->retStrSinEnvioProcesso();
      $objUnidadeDTO->retStrSinAtivo();
      $objUnidadeDTO->setNumIdUnidade(array_keys($arrUnidades), InfraDTO::$OPER_IN);

      $objUnidadeRN = new UnidadeRN();
      $arrObjUnidadeDTO = $objUnidadeRN->listarRN0127($objUnidadeDTO);

      foreach($arrObjUnidadeDTO as $objUnidadeDTO){
        if ($objUnidadeDTO->getStrSinEnvioProcesso()=='N' || $objUnidadeDTO->getStrSinAtivo()=='N'){
          unset($arrUnidades[$objUnidadeDTO->getNumIdUnidade()]);
        }
      }
    }

    return parent::montarSelectArray($strPrimeiroItemValor, $strPrimeiroItemDescricao, $numIdSelecionado, $arrUnidades);
  }
  
  public static function autoCompletarUsuariosAssinatura($numIdOrgao, $strPalavrasPesquisa, $bolIncluirInativos = false){
    
    $objUsuarioDTO = new UsuarioDTO();

    if ($bolIncluirInativos){
      $objUsuarioDTO->setBolExclusaoLogica(false);
    }

    $objUsuarioDTO->retNumIdContato();
    $objUsuarioDTO->retNumIdUsuario();
    $objUsuarioDTO->retStrSigla();
    $objUsuarioDTO->retStrNome();
    $objUsuarioDTO->setStrPalavrasPesquisa($strPalavrasPesquisa);

    if ($numIdOrgao!=null) {
      $objUsuarioDTO->setNumIdOrgao($numIdOrgao);
    }
    
		$objUsuarioDTO->setStrStaTipo(array(UsuarioRN::$TU_SIP, UsuarioRN::$TU_EXTERNO), InfraDTO::$OPER_IN);

		$objUsuarioDTO->setNumMaxRegistrosRetorno(50);
		
    $objUsuarioDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);
		
    $objUsuarioRN = new UsuarioRN();
    $arrObjUsuarioDTO = $objUsuarioRN->pesquisar($objUsuarioDTO);
    foreach($arrObjUsuarioDTO as $objUsuarioDTO){
      $objUsuarioDTO->setStrSigla($objUsuarioDTO->getStrNome().' ('.$objUsuarioDTO->getStrSigla().')');
    }
    return $arrObjUsuarioDTO;
  }

  public static function formatarSiglaNome($strSigla, $strNome){
    return $strSigla.' - '.$strNome;
  }
}
?>