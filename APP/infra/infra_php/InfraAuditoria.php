<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 30/05/2006 - criado por MGA
 *
 * @package infra_php
 */


abstract class InfraAuditoria
{

    private $arrRecursos = null;

    public function __construct(InfraIBanco $objInfraIBanco, InfraSessao $objInfraSessao, InfraCache $objInfraCache)
    {
        SessaoInfra::setObjInfraSessao($objInfraSessao);
        BancoInfra::setObjInfraIBanco($objInfraIBanco);
        CacheInfra::setObjInfraCache($objInfraCache);

        $this->carregarRegras();
    }

    public function prepararParametro($varParametro)
    {
        return $varParametro;
    }

    public function getArrExcecoesGet()
    {
        return null;
    }

    public function getArrExcecoesPost()
    {
        return null;
    }

    public function getTempoCache()
    {
        return 300;
    }

    public function getObjInfraIBancoAuditoria()
    {
        return null;
    }

    private function carregarRegras()
    {
        try {
            if ($this->arrRecursos == null) {
                $this->arrRecursos = CacheInfra::getInstance()->getAtributo('INFRA_RA');

                if ($this->arrRecursos == null) {
                    $this->arrRecursos = array();

                    $objInfraRegraAuditoriaRecursoDTO = new InfraRegraAuditoriaRecursoDTO();
                    $objInfraRegraAuditoriaRecursoDTO->setDistinct(true);
                    $objInfraRegraAuditoriaRecursoDTO->retStrRecurso();
                    $objInfraRegraAuditoriaRecursoDTO->setStrSinAtivoInfraRegraAuditoria('S');

                    $objInfraRegraAuditoriaRecursoRN = new InfraRegraAuditoriaRecursoRN();
                    $arrObjInfraRegraAuditoriaRecursoDTO = $objInfraRegraAuditoriaRecursoRN->listar(
                        $objInfraRegraAuditoriaRecursoDTO
                    );
                    foreach ($arrObjInfraRegraAuditoriaRecursoDTO as $objInfraRegraAuditoriaRecursoDTO) {
                        $this->arrRecursos[$objInfraRegraAuditoriaRecursoDTO->getStrRecurso()] = true;
                    }

                    CacheInfra::getInstance()->setAtributo('INFRA_RA', $this->arrRecursos, $this->getTempoCache());
                }
            }
        } catch (Exception $e) {
            throw new InfraException('Erro carregando regras de auditoria.', $e);
        }
    }

    public function verificar($strNomeRecurso)
    {
        return isset($this->arrRecursos[$strNomeRecurso]);
    }

    public function auditar($strNomeRecurso, $strOperacao = null, $varParametro = null)
    {
        try {
            $ret = null;

            if (isset($this->arrRecursos[$strNomeRecurso])) {
                $objSessaoInfra = SessaoInfra::getInstance();

                $objInfraAuditoriaDTO = new InfraAuditoriaDTO();
                $objInfraAuditoriaDTO->setDblIdInfraAuditoria(null);
                $objInfraAuditoriaDTO->setStrRecurso($strNomeRecurso);
                $objInfraAuditoriaDTO->setNumIdUsuario($objSessaoInfra->getNumIdUsuario());
                $objInfraAuditoriaDTO->setStrSiglaUsuario($objSessaoInfra->getStrSiglaUsuario());
                $objInfraAuditoriaDTO->setStrNomeUsuario($objSessaoInfra->getStrNomeUsuario());
                $objInfraAuditoriaDTO->setNumIdOrgaoUsuario($objSessaoInfra->getNumIdOrgaoUsuario());
                $objInfraAuditoriaDTO->setStrSiglaOrgaoUsuario($objSessaoInfra->getStrSiglaOrgaoUsuario());

                $objInfraAuditoriaDTO->setNumIdUsuarioEmulador($objSessaoInfra->getNumIdUsuarioEmulador());
                $objInfraAuditoriaDTO->setStrSiglaUsuarioEmulador($objSessaoInfra->getStrSiglaUsuarioEmulador());
                $objInfraAuditoriaDTO->setStrNomeUsuarioEmulador($objSessaoInfra->getStrNomeUsuarioEmulador());
                $objInfraAuditoriaDTO->setNumIdOrgaoUsuarioEmulador($objSessaoInfra->getNumIdOrgaoUsuarioEmulador());
                $objInfraAuditoriaDTO->setStrSiglaOrgaoUsuarioEmulador(
                    $objSessaoInfra->getStrSiglaOrgaoUsuarioEmulador()
                );

                $objInfraAuditoriaDTO->setNumIdUnidade($objSessaoInfra->getNumIdUnidadeAtual());
                $objInfraAuditoriaDTO->setStrSiglaUnidade($objSessaoInfra->getStrSiglaUnidadeAtual());
                $objInfraAuditoriaDTO->setStrDescricaoUnidade($objSessaoInfra->getStrDescricaoUnidadeAtual());
                $objInfraAuditoriaDTO->setNumIdOrgaoUnidade($objSessaoInfra->getNumIdOrgaoUnidadeAtual());
                $objInfraAuditoriaDTO->setStrSiglaOrgaoUnidade($objSessaoInfra->getStrSiglaOrgaoUnidadeAtual());


                $objInfraAuditoriaDTO->setNumIdUnidade($objSessaoInfra->getNumIdUnidadeAtual());
                $objInfraAuditoriaDTO->setStrIp(InfraUtil::getStrIpUsuario());

                $strServidor = null;
                if (isset($_SERVER['SERVER_NAME'])) {
                    $strServidor = $_SERVER['SERVER_NAME'];
                }

                if (isset($_SERVER['SERVER_ADDR'])) {
                    $strServidor .= ' (' . $_SERVER['SERVER_ADDR'] . ')';
                }

                $objInfraAuditoriaDTO->setStrServidor($strServidor);

                if (isset($_SERVER['HTTP_USER_AGENT'])) {
                    $objInfraAuditoriaDTO->setStrUserAgent($_SERVER['HTTP_USER_AGENT']);
                } else {
                    $objInfraAuditoriaDTO->setStrUserAgent(null);
                }

                $arrGetClone = $_GET;
                if ($this->getArrExcecoesGet() != null) {
                    foreach ($this->getArrExcecoesGet() as $excGet) {
                        if (isset($arrGetClone[$excGet])) {
                            unset($arrGetClone[$excGet]);
                        }
                    }
                }

                $arrPostClone = $_POST;
                if ($this->getArrExcecoesPost() != null) {
                    foreach ($this->getArrExcecoesPost() as $excPost) {
                        if (isset($arrPostClone[$excPost])) {
                            unset($arrPostClone[$excPost]);
                        }
                    }
                }

                $objInfraAuditoriaDTO->setStrRequisicao(
                    'GET - ' . print_r($arrGetClone, true) . "\nPOST - " . print_r($arrPostClone, true)
                );

                $objInfraAuditoriaDTO->setStrOperacao(
                    $strOperacao . '(' . $this->formatarDados($this->prepararParametro($varParametro)) . ')'
                );
                $objInfraAuditoriaDTO->setDthAcesso(InfraData::getStrDataHoraAtual());

                $objInfraAuditoriaRN = new InfraAuditoriaRN();
                $objInfraAuditoriaDTO = $objInfraAuditoriaRN->cadastrar($objInfraAuditoriaDTO);

                $ret = $objInfraAuditoriaDTO->getDblIdInfraAuditoria();
            }
            //}

            return $ret;
        } catch (Exception $e2) {
            throw new InfraException('Erro gravando auditoria.', $e2);
        }
    }

    public function formatarDados($varParam, $iteracao = 0)
    {
        $ret = '';

        if ($varParam instanceof InfraDTO) {
            $prefixo = "\n" . str_repeat(' ', $iteracao);
            $ret = $prefixo . ' ' . $varParam->__toString();
        } elseif (is_array($varParam)) {
            $n = InfraArray::contar($varParam);
            $prefixo = "\n" . str_repeat(' ', $iteracao);
            $ret .= $prefixo . 'Array (' . $n . ') {';
            foreach ($varParam as $chave => $valor) {
                $ret .= $prefixo . ' [' . $chave . '] => ' . $this->formatarDados($valor, $iteracao + 1);
            }
            $ret .= "\n" . '}';
        } elseif ($varParam === null) {
            $ret = '[null]';
        } elseif ($varParam === '') {
            $ret = '[vazio]';
        } else {
            $ret = $varParam;
        }

        return $ret;
    }

    public function replicarRegra(
        $StaOperacao,
        $IdRegraAuditoria,
        $Descricao,
        $SinAtivo,
        $Recursos
    ) {
        try {
            $objInfraRegraAuditoriaDTO = new InfraRegraAuditoriaDTO();
            $objInfraRegraAuditoriaDTO->setNumIdInfraRegraAuditoria($IdRegraAuditoria);
            $objInfraRegraAuditoriaDTO->setStrDescricao($Descricao);
            $objInfraRegraAuditoriaDTO->setStrSinAtivo($SinAtivo);


            $arrObjInfraRegraAuditoriaRecursoDTO = array();
            foreach ($Recursos as $recurso) {
                $objInfraRegraAuditoriaRecursoDTO = new InfraRegraAuditoriaRecursoDTO();
                $objInfraRegraAuditoriaRecursoDTO->setStrRecurso($recurso);
                $arrObjInfraRegraAuditoriaRecursoDTO[] = $objInfraRegraAuditoriaRecursoDTO;
            }
            $objInfraRegraAuditoriaDTO->setArrObjInfraRegraAuditoriaRecursoDTO($arrObjInfraRegraAuditoriaRecursoDTO);

            $objInfraRegraAuditoriaRN = new InfraRegraAuditoriaRN();

            $dto = new InfraRegraAuditoriaDTO();
            $dto->setBolExclusaoLogica(false);
            $dto->setNumIdInfraRegraAuditoria($IdRegraAuditoria);
            $bolExiste = ($objInfraRegraAuditoriaRN->contar($dto) > 0);

            if ($StaOperacao == 'C' || $StaOperacao == 'A' || $StaOperacao == 'R') {
                if (!$bolExiste) {
                    $objInfraRegraAuditoriaRN->cadastrar($objInfraRegraAuditoriaDTO);
                } else {
                    $objInfraRegraAuditoriaRN->alterar($objInfraRegraAuditoriaDTO);
                }
            } elseif ($StaOperacao == 'E') {
                if ($bolExiste) {
                    $objInfraRegraAuditoriaRN->excluir(array($dto));
                }
            } elseif ($StaOperacao == 'D') {
                if ($bolExiste) {
                    $objInfraRegraAuditoriaRN->desativar(array($dto));
                }
            } else {
                throw new InfraException('Opera��o ' . $StaOperacao . ' inv�lida.');
            }

            CacheInfra::getInstance()->removerAtributo('INFRA_RA');
        } catch (Exception $e) {
            throw new InfraException('Erro replicando auditoria.', $e);
        }
    }

    public function getArrRecursos()
    {
        return $this->arrRecursos;
    }

    public function processarComplemento(InfraAuditoriaDTO $objInfraAuditoriaDTO)
    {
        return null;
    }
}