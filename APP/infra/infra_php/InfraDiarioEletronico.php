<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 04/12/2008 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.19.0
 *
 * Vers�o no CVS: $Id$
 */

abstract class InfraDiarioEletronico
{

    public static $WS_FERIADO_DATA = 'Data';
    public static $WS_FERIADO_DESCRICAO = 'Descricao';
    public static $WS_FERIADO_TIPO = 'Tipo';
    public static $WS_FERIADO_DESCRICAO_TIPO = 'TipoDescricao';

    public static $FERIADO_TRIBUNAL = 'T';
    public static $FERIADO_OFICIAL = 'F';
    public static $FERIADO_RECESSO = 'R';

    public function __construct()
    {
    }

    public abstract function getStrWsdl();

    private function getWebService()
    {
        $objWS = null;

        $strWSDL = $this->getStrWsdl();

        try {
            if (!@file_get_contents($strWSDL)) {
                throw new InfraException('Falha na leitura do arquivo WSDL do Di�rio Eletr�nico.');
            }

            $objWS = new SoapClient($strWSDL, array('encoding' => 'ISO-8859-1'));
        } catch (Exception $e) {
            throw new InfraException('Falha na conex�o com o Web Service do Di�rio Eletr�nico.', $e);
        }

        return $objWS;
    }

    public function listarFeriados($strDataInicial = null, $strDataFinal = null)
    {
        $ret = null;

        try {
            $objWS = $this->getWebService();

            if ($strDataInicial == null) {
                $strDataInicial = '01/01/1900';
            }

            if ($strDataFinal == null) {
                $strDataFinal = '31/12/2100';
            }

            $ret = $objWS->listarFeriados($strDataInicial, $strDataFinal);

            foreach ($ret as $feriado) {
                if (InfraString::isBolVazia($feriado[self::$WS_FERIADO_DATA])) {
                    throw new InfraException('Data de feriado do Di�rio Eletr�nico vazia ou nula.');
                }

                if (!InfraData::validarData($feriado[self::$WS_FERIADO_DATA])) {
                    throw new InfraException(
                        'Data de feriado "' . $feriado[self::$WS_FERIADO_DATA] . '" do Di�rio Eletr�nico inv�lida.'
                    );
                }


                if ($feriado[self::$WS_FERIADO_TIPO] != 'T' && $feriado[self::$WS_FERIADO_TIPO] != 'F' && $feriado[self::$WS_FERIADO_TIPO] != 'R') {
                    throw new InfraException(
                        'Tipo de feriado "' . $feriado[self::$WS_FERIADO_TIPO] . '" do Di�rio Eletr�nico inv�lido.'
                    );
                }
            }
        } catch (Exception $e) {
            throw new InfraException($e->__toString(), $e);
        }

        return $ret;
    }

    public function agendarPublicacao(
        $numOrgao,
        $numTipoPublicacao,
        $strNumeroDocumento,
        $strConteudo,
        $strCodigoUnidade,
        $strIdOrigem,
        $numIdSerie,
        $strDtaDisponibilizacao,
        $strIdOrigemPai,
        $numCodigoVeiculoIO,
        $strDescricaoVeiculoIO,
        $strSiglaVeiculoIO,
        $strDtaPublicacaoIO,
        $strSecaoIO,
        $strPaginaIO
    ) {
        $ret = null;

        try {
            $objWS = $this->getWebService();

            $ret = $objWS->agendarPublicacao(
                $numOrgao,
                $numTipoPublicacao,
                $strNumeroDocumento,
                $strConteudo,
                $strCodigoUnidade,
                $strIdOrigem,
                $numIdSerie,
                $strDtaDisponibilizacao,
                $strIdOrigemPai,
                $numCodigoVeiculoIO,
                $strDescricaoVeiculoIO,
                $strSiglaVeiculoIO,
                $strDtaPublicacaoIO,
                $strSecaoIO,
                $strPaginaIO
            );
        } catch (Exception $e) {
            throw new InfraException($e->__toString(), $e);
        }

        return $ret;
    }

    public function cancelarAgendamentoPublicacao($strIdOrigem)
    {
        $ret = null;

        try {
            $objWS = $this->getWebService();

            $ret = $objWS->cancelarAgendaPublicacao($strIdOrigem);
        } catch (Exception $e) {
            throw new InfraException($e->__toString(), $e);
        }

        return $ret;
    }


    public function alterarAgendamentoPublicacao(
        $numOrgao,
        $numTipoPublicacao,
        $strNumeroDocumento,
        $strConteudo,
        $strCodigoUnidade,
        $strIdOrigem,
        $numIdSerie,
        $strDtaDisponibilizacao,
        $strIdOrigemPai,
        $numCodigoVeiculoIO,
        $strDescricaoVeiculoIO,
        $strSiglaVeiculoIO,
        $strDtaPublicacaoIO,
        $strSecaoIO,
        $strPaginaIO
    ) {
        $ret = null;

        try {
            $objWS = $this->getWebService();

            $ret = $objWS->alterarAgendaPublicacao(
                $numOrgao,
                $numTipoPublicacao,
                $strNumeroDocumento,
                $strConteudo,
                $strCodigoUnidade,
                $strIdOrigem,
                $numIdSerie,
                $strDtaDisponibilizacao,
                $strIdOrigemPai,
                $numCodigoVeiculoIO,
                $strDescricaoVeiculoIO,
                $strSiglaVeiculoIO,
                $strDtaPublicacaoIO,
                $strSecaoIO,
                $strPaginaIO
            );
        } catch (Exception $e) {
            throw new InfraException($e->__toString(), $e);
        }

        return $ret;
    }


    public function obterDataDisponibilizacao()
    {
        $ret = null;

        try {
            $objWS = $this->getWebService();

            $ret = $objWS->obterDataValida();
        } catch (Exception $e) {
            throw new InfraException($e->__toString(), $e);
        }

        return $ret;
    }

}

