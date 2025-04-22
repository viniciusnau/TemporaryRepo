<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 25/03/2014 - criado por mga
*
*
*/

require_once dirname(__FILE__) . '/../Sip.php';

class SipRN extends InfraRN {

  public function __construct() {
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco() {
    return BancoSip::getInstance();
  }

  public function pesquisarUsuario(UsuarioDTO $parObjUsuarioDTO) {
    try {
      $ret = null;

      $parObjUsuarioDTO->setStrTipoServidorAutenticacao(strtoupper(trim($parObjUsuarioDTO->getStrTipoServidorAutenticacao())));

      if ($parObjUsuarioDTO->getStrTipoServidorAutenticacao() != 'AD' && $parObjUsuarioDTO->getStrTipoServidorAutenticacao() != 'LDAP') {
        throw new InfraException('Tipo do servidor de autentica��o [' . $parObjUsuarioDTO->getStrTipoServidorAutenticacao() . '] inv�lido.');
      }

      $objUsuarioDTO = new UsuarioDTO();
      //$objUsuarioDTO->setBolExclusaoLogica(false);
      $objUsuarioDTO->retNumIdOrgao();
      $objUsuarioDTO->retStrSigla();
      $objUsuarioDTO->retStrNome();
      $objUsuarioDTO->setNumIdOrgao($parObjUsuarioDTO->getNumIdOrgao());
      $objUsuarioDTO->setStrSigla($parObjUsuarioDTO->getStrSigla());

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTO = $objUsuarioRN->consultar($objUsuarioDTO);

      if ($objUsuarioDTO == null) {
        throw new InfraException('Usu�rio [' . $parObjUsuarioDTO->getStrSigla() . '] n�o encontrado no �rg�o [' . $parObjUsuarioDTO->getNumIdOrgao() . '].');
      }

      //Obtem IP do LDAP para o �rg�o
      $objOrgaoDTO = new OrgaoDTO();
      //$objOrgaoDTO->setBolExclusaoLogica(false);
      $objOrgaoDTO->retNumIdOrgao();
      $objOrgaoDTO->retStrSigla();
      $objOrgaoDTO->setNumIdOrgao($parObjUsuarioDTO->getNumIdOrgao());

      $objOrgaoRN = new OrgaoRN();
      $objOrgaoDTO = $objOrgaoRN->consultar($objOrgaoDTO);

      if ($objOrgaoDTO == null) {
        throw new InfraException('�rg�o [' . $parObjUsuarioDTO->getNumIdOrgao() . '] n�o encontrado.');
      }

      $objRelOrgaoAutenticacaoDTO = new RelOrgaoAutenticacaoDTO();
      $objRelOrgaoAutenticacaoDTO->retNumIdServidorAutenticacao();
      $objRelOrgaoAutenticacaoDTO->setNumIdOrgao($objOrgaoDTO->getNumIdOrgao());
      $objRelOrgaoAutenticacaoDTO->setStrStaTipoServidorAutenticacao($parObjUsuarioDTO->getStrTipoServidorAutenticacao());
      $objRelOrgaoAutenticacaoDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objRelOrgaoAutenticacaoRN = new RelOrgaoAutenticacaoRN();
      $arrObjRelOrgaoAutenticacaoDTO = $objRelOrgaoAutenticacaoRN->listar($objRelOrgaoAutenticacaoDTO);

      if (count($arrObjRelOrgaoAutenticacaoDTO) == 0) {
        throw new InfraException('Nenhum servidor de autentica��o ' . $parObjUsuarioDTO->getStrTipoServidorAutenticacao() . ' est� associado com o �rg�o.');
      }

      $numServidoresAutenticacao = count($arrObjRelOrgaoAutenticacaoDTO);

      for ($i = 0; $i < $numServidoresAutenticacao; $i++) {
        $objServidorAutenticacaoDTO = new ServidorAutenticacaoDTO();
        $objServidorAutenticacaoDTO->retStrStaTipo();
        $objServidorAutenticacaoDTO->retStrEndereco();
        $objServidorAutenticacaoDTO->retNumPorta();
        $objServidorAutenticacaoDTO->retNumVersao();
        $objServidorAutenticacaoDTO->retStrSufixo();
        $objServidorAutenticacaoDTO->retStrUsuarioPesquisa();
        $objServidorAutenticacaoDTO->retStrSenhaPesquisa();
        $objServidorAutenticacaoDTO->retStrContextoPesquisa();
        $objServidorAutenticacaoDTO->retStrAtributoFiltroPesquisa();
        $objServidorAutenticacaoDTO->retStrAtributoRetornoPesquisa();
        $objServidorAutenticacaoDTO->setNumIdServidorAutenticacao($arrObjRelOrgaoAutenticacaoDTO[$i]->getNumIdServidorAutenticacao());

        $objServidorAutenticacaoRN = new ServidorAutenticacaoRN();
        $objServidorAutenticacaoDTO = $objServidorAutenticacaoRN->consultar($objServidorAutenticacaoDTO);

        $conexao = null;

        try {
          $conexao = ldap_connect($objServidorAutenticacaoDTO->getStrEndereco(), $objServidorAutenticacaoDTO->getNumPorta());

          if ($parObjUsuarioDTO->getStrTipoServidorAutenticacao() == 'AD') {
            ldap_set_option($conexao, LDAP_OPT_PROTOCOL_VERSION, $objServidorAutenticacaoDTO->getNumVersao());
            ldap_set_option($conexao, LDAP_OPT_REFERRALS, 0);
          }

          if ($objServidorAutenticacaoDTO->getStrUsuarioPesquisa() != null && $objServidorAutenticacaoDTO->getStrSenhaPesquisa() != null) {
            ldap_bind($conexao, $objServidorAutenticacaoDTO->getStrUsuarioPesquisa(), $objServidorAutenticacaoDTO->getStrSenhaPesquisa());
          }

          $pesquisa = @ldap_search($conexao, $objServidorAutenticacaoDTO->getStrContextoPesquisa(),
            $objServidorAutenticacaoDTO->getStrAtributoFiltroPesquisa() . '=' . $objUsuarioDTO->getStrSigla() . $objServidorAutenticacaoDTO->getStrSufixo(), array($objServidorAutenticacaoDTO->getStrAtributoRetornoPesquisa()));

          if (ldap_errno($conexao) == 0) {
            $entry = ldap_first_entry($conexao, $pesquisa);

            if (!empty($entry)) {
              $attrs = ldap_get_attributes($conexao, $entry);

              $ret = array();
              $ret['Retorno'] = $objServidorAutenticacaoDTO->getStrAtributoRetornoPesquisa();
              $ret['SiglaUsuario'] = $objUsuarioDTO->getStrSigla();
              $ret['NomeUsuario'] = $objUsuarioDTO->getStrNome();

              $dominioUsuario = ldap_get_dn($conexao, $entry);

              if (!empty($dominioUsuario)) {
                $ret['ContextoUsuario'] = InfraLDAP::formatarContexto(utf8_decode($dominioUsuario));

                $arrDominioUsuario = explode(',', $dominioUsuario);

                $ret['SiglaUnidade'] = str_replace(array('OU=', 'ou='), '', $arrDominioUsuario[1]);
                $ret['LocalizacaoUsuario'] = str_replace(array('OU=', 'ou='), '', $arrDominioUsuario[2]);

                foreach ($arrDominioUsuario as $itemDominio) {
                  if (substr($itemDominio, 0, 3) == 'DC=' || substr($itemDominio, 0, 3) == 'dc=') {
                    $ret['SiglaOrgaoUsuario'] = InfraString::transformarCaixaAlta(str_replace(array('DC=', 'dc='), '', $itemDominio));
                    break;
                  } else {
                    if (substr($itemDominio, 0, 2) == 'O=' || substr($itemDominio, 0, 2) == 'o=') {
                      $ret['SiglaOrgaoUsuario'] = InfraString::transformarCaixaAlta(str_replace(array('O=', 'o='), '', $itemDominio));
                      break;
                    }
                  }
                }

                unset($arrDominioUsuario[0]);

                $dominioUnidade = implode(',', $arrDominioUsuario);

                $ret['ContextoUnidade'] = InfraLDAP::formatarContexto(utf8_decode($dominioUnidade));

                $pesquisa = @ldap_search($conexao, $objServidorAutenticacaoDTO->getStrContextoPesquisa(), 'OU=' . $ret['SiglaUnidade'], array('description'));

                if (ldap_errno($conexao) == 0) {
                  $entry = ldap_first_entry($conexao, $pesquisa);

                  if (!empty($entry)) {
                    $attrs = ldap_get_attributes($conexao, $entry);

                    if (!isset($attrs['description'])) {
                      $ret['DescricaoUnidade'] = '';
                    } else {
                      $ret['DescricaoUnidade'] = utf8_decode($attrs['description'][0]);
                    }
                  }
                }

                //sair no primeiro que achar
                break;
              } else {
                throw new InfraException('N�o foi poss�vel determinar o contexto do usu�rio no ' . $parObjUsuarioDTO->getStrTipoServidorAutenticacao() . '.');
              }
            } else {
              throw new InfraException('Usu�rio n�o existe no contexto do ' . $parObjUsuarioDTO->getStrTipoServidorAutenticacao() . '.');
            }
          } else {
            throw new InfraException('Conex�o com o ' . $parObjUsuarioDTO->getStrTipoServidorAutenticacao() . ' n�o foi estabelecida.');
          }

          ldap_close($conexao);
        } catch (Exception $e) {
          try {
            ldap_close($conexao);
          } catch (Exception $e2) {
          }

          //se for o �ltimo servidor de autentica��o associado
          if ($i == ($numServidoresAutenticacao - 1)) {
            throw $e;
          }
        }
      }

      return $ret;
    } catch (Exception $e) {

      if ($e instanceof InfraException){
        throw $e;
      }

      //NAO REPASSAR A EXCECAO ORIGINAL POIS O PHP PODE MOSTRAR A SENHA DE BUSCA NOS PARAMETROS DE CHAMADA
      throw new InfraException('Erro pesquisando dados do usu�rio.', null, null, false);
    }
  }
}

?>