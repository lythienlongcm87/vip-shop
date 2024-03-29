<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.2.0
 * @author	acyba.com
 * @copyright	(C) 2009-2013 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php

class acypluginsHelper{

	function getFormattedResult($elements,$parameter){
		if(count($elements)<2) return implode('',$elements);

		$beforeAll = array();
		$beforeAll['table'] = '<table cellspacing="0" cellpadding="0" border="0" width="100%" class="elementstable">'."\n";
		$beforeAll['ul'] = '<ul class="elementsul">'."\n";
		$beforeAll['br'] = '';

		$beforeBlock = array();
		$beforeBlock['table'] = '<tr class="elementstable_tr numrow{rownum}">'."\n";
		$beforeBlock['ul'] = '';
		$beforeBlock['br'] = '';

		$beforeOne = array();
		$beforeOne['table'] = '<td valign="top" width="{equalwidth}" class="elementstable_td numcol{numcol}" >'."\n";
		$beforeOne['ul'] = '<li class="elementsul_li numrow{rownum}">'."\n";
		$beforeOne['br'] = '';

		$afterOne = array();
		$afterOne['table'] = '</td>'."\n";
		$afterOne['ul'] = '</li>'."\n";
		$afterOne['br'] = '<br/>'."\n";

		$afterBlock =  array();
		$afterBlock['table'] = '</tr>'."\n";
		$afterBlock['ul'] = '';
		$afterBlock['br'] = '';

		$afterAll = array();
		$afterAll['table'] = '</table>'."\n";
		$afterAll['ul'] = '</ul>'."\n";
		$afterAll['br'] = '';


		$type = 'table';
		$cols = 1;
		if(!empty($parameter->displaytype)) $type = $parameter->displaytype;
		if(!empty($parameter->cols)) $cols = $parameter->cols;

		$string = $beforeAll[$type];
		$a = 0;
		$numrow = 1;
		foreach($elements as $oneElement){
			if($a == $cols){
				$string .= $afterBlock[$type];
				$a = 0;
			}
			if($a == 0){
				$string .= str_replace('{rownum}',$numrow,$beforeBlock[$type]);
				$numrow++;
			}
			$string .= str_replace('{numcol}',$a+1,$beforeOne[$type]).$oneElement.$afterOne[$type];
			$a++;
		}
		while($cols > $a){
			$string .= str_replace('{numcol}',$a+1,$beforeOne[$type]).$afterOne[$type];
			$a++;
		}

		$string .= $afterBlock[$type];
		$string .= $afterAll[$type];

		$equalwidth = intval(100/$cols).'%';

		$string = str_replace(array('{equalwidth}'),array($equalwidth),$string);

		return $string;
	}

	function formatString(&$replaceme,$mytag){
		if(!empty($mytag->part)){
			$parts = explode(' ',$replaceme);
			if($mytag->part == 'last'){
				$replaceme = count($parts)>1 ? end($parts) : '';
			}else{
				$replaceme = reset($parts);
			}

		}
		if(!empty($mytag->type)){
			if(empty($mytag->format)) $mytag->format = JText::_('DATE_FORMAT_LC3');
			if($mytag->type == 'date'){
				$replaceme = acymailing_getDate(acymailing_getTime($replaceme),$mytag->format);
			}elseif($mytag->type == 'time'){
				$replaceme = acymailing_getDate($replaceme,$mytag->format);
			}
		}

		if(!empty($mytag->lower)) $replaceme = strtolower($replaceme);
		if(!empty($mytag->upper)) $replaceme = strtoupper($replaceme);
		if(!empty($mytag->ucwords)) $replaceme = ucwords($replaceme);
		if(!empty($mytag->ucfirst)) $replaceme = ucfirst($replaceme);
		if(!empty($mytag->urlencode)) $replaceme = urlencode($replaceme);


		if(!empty($mytag->maxheight) || !empty($mytag->maxwidth)){
			$pictureHelper = acymailing_get('helper.acypict');
			$pictureHelper->maxHeight = empty($mytag->maxheight) ? 999 : $mytag->maxheight;
			$pictureHelper->maxWidth = empty($mytag->maxwidth) ? 999 : $mytag->maxwidth;
			$replaceme = $pictureHelper->resizePictures($replaceme);
		}
	}

	function removeJS($text){
		$text = preg_replace("#(onmouseout|onmouseover|onclick|onfocus|onload|onblur) *= *\"(?:(?!\").)*\"#iU",'',$text);
		$text =  preg_replace("#< *script(?:(?!< */ *script *>).)*< */ *script *>#isU",'',$text);
		return $text;
	}

	private function _convertbase64pictures(&$html){
		if(!preg_match_all('#<img[^>]*src=("data:image/([^;]{1,5});base64[^"]*")([^>]*)>#Uis',$html,$resultspictures)) return;

		jimport('joomla.filesystem.file');

		$dest = ACYMAILING_MEDIA.'resized'.DS;
		acymailing_createDir($dest);
		foreach($resultspictures[2] as $i => $extension){
			$pictname =  md5($resultspictures[1][$i]).'.'.$extension;
			$picturl = ACYMAILING_LIVE.'media/'.ACYMAILING_COMPONENT.'/resized/'.$pictname;
			$pictPath = $dest.$pictname;
			$pictCode = trim($resultspictures[1][$i],'"');
			if(file_exists($pictPath)){
				$html = str_replace($pictCode,$picturl,$html);
				continue;
			}

			$getfunction = '';
			switch($extension){
				case 'gif':
					$getfunction = 'ImageCreateFromGIF';
					break;
				case 'jpg':
				case 'jpeg':
					$getfunction = 'ImageCreateFromJPEG';
					break;
				case 'png':
					$getfunction = 'ImageCreateFromPNG';
					break;
			}

			if(empty($getfunction) || !function_exists($getfunction)) continue;

			$img = $getfunction($pictCode);

			if(in_array($extension,array('gif','png'))){
				imagealphablending($img, false);
				imagesavealpha($img,true);
			}

			ob_start();
			switch($extension){
				case 'gif':
					$status = imagegif($img);
					break;
				case 'jpg':
				case 'jpeg':
					$status = imagejpeg($img,null,100);
					break;
				case 'png':
					$status = imagepng($img,null,0);
					break;
			}
			$imageContent = ob_get_clean();
			$status = $status && JFile::write($pictPath,$imageContent);

			if(!$status) continue;
			$html = str_replace($pictCode,$picturl,$html);
		}
	}

	private function _lineheightfix(&$html){
		$pregreplace = array();
		$pregreplace['#<tr([^>"]*>([^<]*<td[^>]*>[ \n\s]*<img[^>]*>[ \n\s]*</ *td[^>]*>[ \n\s]*)*</ *tr)#Uis'] = '<tr style="line-height: 0px;" $1';
		$pregreplace['#<td(((?!style|>).)*>[ \n\s]*(<a[^>]*>)?[ \n\s]*<img[^>]*>[ \n\s]*(</a[^>]*>)?[ \n\s]*</ *td)#Uis'] = '<td style="line-height: 0px;" $1';

		$pregreplace['#<xml>.*</xml>#Uis'] = '';
		$newbody = preg_replace(array_keys($pregreplace),$pregreplace,$html);
		if(!empty($newbody)) $html = $newbody;
	}

	private function _removecontenttags(&$html){
		$pregreplace = array();
		$pregreplace['#{tab[ =][^}]*}#is'] = '';
		$pregreplace['#{/tabs}#is'] = '';
		$pregreplace['#{jcomments\s+(on|off|lock)}#is'] = '';
		$newbody = preg_replace(array_keys($pregreplace),$pregreplace,$html);
		if(!empty($newbody)) $html = $newbody;
	}

	function cleanHtml(&$html){

		$this->_lineheightfix($html);
		$this->_removecontenttags($html);
		$this->_convertbase64pictures($html);
	}

	function extractTags(&$email,$tagfamily){
		$results = array();

		$match = '#{'.$tagfamily.':(.*)}#Ui';
		$variables = array('subject','body','altbody');
		$found = false;
		foreach($variables as $var){
			if(empty($email->$var)) continue;
			$found = preg_match_all($match,$email->$var,$results[$var]) || $found;
			if(empty($results[$var][0])) unset($results[$var]);
		}

		if(!$found) return $results;

		foreach($results as $var => $allresults){
			foreach($allresults[0] as $i => $oneTag){
				if(isset($results[$oneTag])) continue;
				$results[$oneTag] = $this->extractTag($oneTag);
			}
		}

		return $results;
	}

	function extractTag($oneTag){
		$arguments = explode('|',strip_tags($oneTag));
		$tag = new stdClass();
		$tag->id = $arguments[0];
		for($i=1,$a=count($arguments);$i<$a;$i++){
			$args = explode(':',$arguments[$i]);
			$arg0 = trim($args[0]);
			if(empty($arg0)) continue;
			if(isset($args[1])){
				$tag->$arg0 = $args[1];
				if(isset($args[2])) $mytag->$args[0] .= ':'.$args[2];
			}else{
				$tag->$arg0 = true;
			}
		}
		return $tag;
	}
}
