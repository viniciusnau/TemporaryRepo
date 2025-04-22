<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/01/2008 - criado por marcio_db
*
* Vers�o do Gerador de C�digo: 1.12.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class EmailINT extends InfraINT {

  
  public static function formatarNomeEmailRI0960($strSiglaOrgao,$strNome, $strEmail){
  	
  	if($strSiglaOrgao != null){
  		
  			$strSiglaOrgao = $strSiglaOrgao."/";
  		
  	}
  	
    $str = $strSiglaOrgao.$strNome.' &lt;';
    
    if (trim($strEmail)==''){
      $str .= 'e-mail n�o cadastrado';
    }else{
      $str .= $strEmail;
    }
    $str .= '&gt;';
    
    return $str;
  }
  
}
?>