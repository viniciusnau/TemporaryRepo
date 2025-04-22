<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 16/10/2009 - criado por MGA
 *
 * @package infra_php
 */

abstract class InfraConfiguracao
{

    public abstract function getArrConfiguracoes();

    public function getValor($strGrupo, $strChave = null, $bolErroNaoEncontrado = true, $strValorPadrao = null)
    {
        $arr = $this->getArrConfiguracoes();

        if (!isset($arr[$strGrupo])) {
            if ($bolErroNaoEncontrado) {
                throw new InfraException('Grupo de Configura��es ' . $strGrupo . ' n�o encontrado.');
            } else {
                return $strValorPadrao;
            }
        }

        if ($strChave != null) {
            if (!isset($arr[$strGrupo][$strChave])) {
                if ($bolErroNaoEncontrado) {
                    throw new InfraException(
                        'Configura��o ' . $strChave . ' n�o encontrada no grupo ' . $strGrupo . '.'
                    );
                } else {
                    return $strValorPadrao;
                }
            }
            return $arr[$strGrupo][$strChave];
        }

        return $arr[$strGrupo];
    }

    public function isSetValor($strGrupo, $strChave = null)
    {
        $arr = $this->getArrConfiguracoes();

        if (!isset($arr[$strGrupo])) {
            return false;
        }

        if ($strChave != null && !isset($arr[$strGrupo][$strChave])) {
            return false;
        }

        return true;
    }

}

