<?php
namespace Controller\App;
use Crash\Crash as Crash;
use Elements\Page as Page;
/*
* This controller processes default pages. usually static pages, which reside in views folder.
*/
	function process($req, $template='default'){
		//check if requested page is present in static pages 
		if (isset(Crash::$static_page[$req])) {
			//reneder the page
			include Crash::$static_page[$req];
		}else{
			//check if requested page is present in the database
			$page_id = Page::fetchPageByName($req);
			if ($page_id!=-1) {
				//render the page
				$page = Page::getPage($page_id);
				include Crash::$template[$template];
			}else{
				//page cant be found, return 404.
				include Crash::$static_page['404'];
			}
		}
	}
?>
