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
	File:			mcp.clearcache.php
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


class Clearcache_CP {

    var $version    = '1.0.0';
    var $old_version  = '';
    var $module_name  = 'Clearcache';
    var $base     = '';
    var $show_nav   = TRUE;
    
    /** ----------------------------------------
    /** Constructor
    /** ----------------------------------------*/
 
  function Clearcache_CP( $switch = TRUE ) {
    global $IN;
      
    if ($switch) {
      switch($IN->GBL('P')) {
        case 'clear_cache': 
          $this->clear_cache();
          break;
        default: 
          $this->clearcache_home();
          break;
          }
      }
  }
  // END

  function clear_cache() {
    global $DSP, $LANG, $FNS;
    $clearwhat = isset($_GET['type']) ? $_GET['type'] : 'all';

    $FNS->clear_caching($clearwhat, '', TRUE);
    
    $DSP->title = $LANG->line('clearcache_module_name');
    $DSP->crumb = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=clearcache', $LANG->line('clearcache_module_name'));
    $DSP->crumb .= $DSP->crumb_item($LANG->line('clear_the_cache'));
    $DSP->body .= $DSP->qdiv('successBox', $DSP->qdiv('success', $LANG->line('cache_cleared')));
    
  }
  // END
  
  // ----------------------------------------
  //  Module Homepage
  // ----------------------------------------

  function clearcache_home() {
    global $DSP, $LANG;

    $DSP->title = $LANG->line('clearcache_module_name');
    $DSP->crumb = $LANG->line('clearcache_module_name');
    
    $DSP->body .= $DSP->qdiv('tableHeading', $LANG->line('clearcache_module_name'));  

    $DSP->body	.=	$DSP->table('tableBorder', '0', '0', '100%').
		$DSP->tr();

    $DSP->body	.=	$DSP->td();
    $DSP->body	.=	$DSP->td_c();

    $DSP->body	.=	$DSP->tr_c();
    $DSP->body	.=	$DSP->tr();

    $DSP->body	.=	$DSP->td('tableCellTwo');
    $DSP->body .= $DSP->qdiv('itemWrapper',
    							$DSP->heading(
    							$DSP->anchor(BASE.
                               AMP.'C=modules'.
                               AMP.'M=clearcache'.
                               AMP.'P=clear_cache', 
                               $LANG->line('clear_the_cache')),
                               5));
    $DSP->body	.=	$DSP->td_c();

    $DSP->body	.=	$DSP->tr_c();
    $DSP->body	.=	$DSP->table_c();
   }
   // END

  // ----------------------------------------
  //  Module installer
  // ----------------------------------------

  function clearcache_module_install() {
      global $DB;        
      
      $sql[] = "INSERT INTO exp_modules (module_id, module_name, module_version, has_cp_backend) 
                  VALUES  ('', 'Clearcache', '$this->version', 'y')";
                                         
      foreach ($sql as $query) {
          $DB->query($query);
      }
      
      return true;
  }
  // END

  // ----------------------------------------
  //  Module de-installer
  // ----------------------------------------

  function clearcache_module_deinstall() {
      global $DB;    

      $query = $DB->query("SELECT module_id FROM exp_modules WHERE module_name = 'Clearcache'"); 
      $sql[] = "DELETE FROM exp_module_member_groups WHERE module_id = '".$query->row['module_id']."'";      
      $sql[] = "DELETE FROM exp_modules WHERE module_name = 'Clearcache'";
      $sql[] = "DELETE FROM exp_actions WHERE class = 'Clearcache'";
      $sql[] = "DELETE FROM exp_actions WHERE class = 'Clearcache_CP'";

      foreach ($sql as $query) {
          $DB->query($query);
      }

      return true;
  }
  // END

}

/** End class */
    

?>