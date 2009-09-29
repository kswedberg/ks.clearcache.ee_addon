<?php


/*
================================================================
	Clearcache
	for EllisLab ExpressionEngine - by Karl Swedberg at Fusionary.
----------------------------------------------------------------
	Credits: Karl Swedberg
----------------------------------------------------------------
	USE THIS SOFTWARE AT YOUR OWN RISK. Karl Swedberg AND 
	Fusionary ASSUME NO WARRANTY OR LIABILITY FOR THIS SOFTWARE.
================================================================
	File:			mod.clearcache.php
----------------------------------------------------------------
	Version:		1.0.0
----------------------------------------------------------------
	Purpose:		Clear the cache from within a public-facing page
----------------------------------------------------------------
	Compatibility:	EE 1.6.6
----------------------------------------------------------------
	Updated:		2009-06-15
================================================================
*/


if ( ! defined('EXT')) {
  exit('Invalid file request');
}
    
/**	----------------------------------------
/**	Begin class
/**	----------------------------------------*/

class Clearcache {

    var $return_data	= ''; 

    // -------------------------------------
    //  Constructor
    // -------------------------------------

    function Clearcache() {
      global $FNS, $TMPL, $PREFS, $SESS;
      $output = '';
      $js = '';
      if ($SESS->userdata['access_cp'] == 'y'):
        $cpurl = $PREFS->ini('system_folder');
        $link_text = !( $TMPL->fetch_param('text') ) ? 'Clear Cache' : $TMPL->fetch_param('text');
        $link_class = 'clear-cache';
        if ($TMPL->fetch_param('class')) {
          $link_class .= ' ' . $TMPL->fetch_param('class');
        }
        $cache_type = !( $TMPL->fetch_param('type') ) ? 'all' : $TMPL->fetch_param('type');
        $output = '<a class="' . $link_class . '" href="/' . $cpurl . '/index.php?&amp;C=modules&amp;M=clearcache&amp;P=clear_cache&amp;type=' . $cache_type . '">' . $link_text . '</a>';
      
        $js = '<script type="text/javascript">';
        $js .= '(function() {var s = document.createElement("script"), b=document.getElementsByTagName("head")[0];';
        $js .= 's.src = "/' . $cpurl . '/modules/clearcache/scripts/clearcache.js";';
        $js .= 'b.appendChild(s);';
        $js .= '})();</script>';
      endif;
      $this->return_data = $output . "\n" . $js;
      
    }
}
/**	End class */

?>