<?php
/**
 * @package		 ITPrism Plugins
 * @subpackage	 ITP jQuery
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITP jQuery is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * ITP jQuery Plugin
 *
 * @package		ITPrism Plugins
 * @subpackage	ITP jQuery
 */
class plgSystemITPjQuery extends JPlugin {
    
    public function onBeforeCompileHead(){
        
        // Check for loading library on backend
        $loadBackend = $this->params->get("jquery_backend", 0);
        if(!$loadBackend) {
            $app = JFactory::getApplication();
            /** @var $app JApplication **/
    
            if($app->isAdmin()) {
                return;
            }
        }
        
        $doc   = JFactory::getDocument();
        /** @var $doc JDocumentHtml **/
        
        $localURL   = JURI::root() ."plugins/system/itpjquery/js";
        
        switch($this->params->get("jquery_server")) {
            
            case 1: // jQuery CDN
                $url  = "//code.jquery.com/jquery-".$this->params->get("jquery_library").".min.js";
                break;
                
            case 2: // Google CDN
                $url  = "//ajax.googleapis.com/ajax/libs/jquery/".$this->params->get("jquery_library")."/jquery.min.js";
                break;
                
            case 3: // Microsoft CDN
                $url  = "//ajax.aspnetcdn.com/ajax/jQuery/jquery-".$this->params->get("jquery_library").".min.js";
                break;
                
            case 4: // CDN JS
                $url  = "//cdnjs.cloudflare.com/ajax/libs/jquery/".$this->params->get("jquery_library")."/jquery.min.js";
                break;
                
            default: // Localhost
                $url  = $localURL."/jquery-".$this->params->get("jquery_library").".min.js";
                break;
                
        }
        
        // Load Mootools
        if($this->params->get("jquery_noconflict")) {
            JHtml::_('behavior.framework');
        }
        
        $doc->addScript($url);

        if($this->params->get("jquery_noconflict")) {
            $doc->addScript($localURL."/jquery-noconflict.js");
        }
        
        if($this->params->get("jquery_migrate")) {
            $doc->addScript($localURL."/jquery-migrate-1.2.1.min.js");
        }
        
        // Order scripts
        $headData    = $doc->getHeadData();
        
        // These are allowed jQuery libraries, no conflict  library and migrate script.
        // Only they can be rearranged.
        $allowedJQuery = array(
            "jquery.min.js", 
            "jquery-".$this->params->get("jquery_library").".min.js", 
            "jquery-noconflict.js", 
            "jquery-migrate-1.2.1.min.js"
        );
        
        $first       = array();
        $jquery      = array();
        foreach($headData["scripts"] as $key => $value) {
            
            if( (false !== strpos($key, "mootools-core-uncompressed.js")) OR (false !== strpos($key, "mootools-core.js")) ) {
                $first[$key]  = $value;
                unset($headData["scripts"][$key]);
            } 
            
            if( (false !== strpos($key, "mootools-more-uncompressed.js")) OR (false !== strpos($key, "mootools-more.js")) ) {
                $first[$key]  = $value;
                unset($headData["scripts"][$key]);
            }
            
            if(false !== strpos($key, "jquery")) {
                $baseName = basename($key);
                
                // Order only jQuery library and no conflict script
                if(in_array($baseName, $allowedJQuery)) {
                    $jquery[$key] = $value;
                }
            }
                        
        }
        
        // Check for bootstrap libraries. 
        $allowedBootstrap = array(
            "bootstrap.min.js",
            "bootstrap.js"
        );
        
        $bootstrap = array();
        foreach($headData["scripts"] as $key => $value) {
            
            if(false !== strpos($key, "bootstrap")) {
                $baseName = basename($key);
            
                // Order only jQuery library and no conflict script
                if(in_array($baseName, $allowedBootstrap)) {
                    $bootstrap[$key] = $value;
                }
            }
            
        }
        
        $jquery              =  $this->orderjQueryLibrarires($jquery);
        
        $first               =  array_merge($first, $jquery);
        $first               =  array_merge($first, $bootstrap);
        
        $headData["scripts"] =  array_merge($first, $headData["scripts"]);
        
        // Remove ignored scripts.
        $headData["scripts"] =  $this->removeDuplicates($headData["scripts"]);
        
        $doc->setHeadData($headData);
        
        unset($first);
        unset($headData);
    }
    
    /**
     * Order jQuery libraries in valid order and remove duplicates.
     * 
     * @param array $libs
     */
    private function orderjQueryLibrarires($libs) {
        
        $allowed  = array(
            "code.jquery.com", 
            "ajax.googleapis.com", 
            "ajax.aspnetcdn.com", 
            "cdnjs.cloudflare.com", 
            "itpjquery"
        );
        
        $first    = array();
        
        // Order libraries.
        foreach($libs as $key => $value) {
            
            foreach($allowed as $string) {
                
                if(false !== strpos($key, $string) ) {
                    $first[$key]  = $value;
                    unset($libs[$key]);
                } 
                
            }
            
        }
        
        $first   = array_merge($first, $libs);
        return $first;
    }
    
    /**
     * Remove ignored scripts preveting duplicates.
     *
     * @param array $libs
     */
    private function removeDuplicates($libs) {
    
        // Get ignored values.
        $ignored  = JString::trim($this->params->get("ignored"));
        if(!empty($ignored)) {
            $ignored = explode("\n", $ignored);
            foreach($ignored as $key => $value) {
                $ignored[$key] = JString::trim($value);
            }
        } else {
            $ignored = array();
        }
    
        $first    = array();
    
        foreach($libs as $key => $value) {
    
            foreach($ignored as $string) {
    
                if(false !== strpos($key, $string) ) {
                    unset($libs[$key]);
                }
    
            }
    
        }
    
        return $libs;
    }
    
}