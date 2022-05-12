<?php
namespace Controller\App;
use Crash\Crash as Crash;
use Elements\Page as Page;
/*
* This controller processes default pages. usually static pages, which reside in views folder.
*/
	function process($req, $middleware=null, $template='default'){
		//check if requested page is present in static pages 
		if (isset(Crash::$static_page[$req])) {
			//reneder the page
			include Crash::$static_page[$req];
		}else{
			//check if requested page is present in the database
			$page_id = Page::fetchPageByName($req);
			if ($page_id!=-1) {
				//render the page
				$page = Page::getPage($page_id)[0];
				//reverse htmlspecialchars 
				$page->content =  htmlspecialchars_decode($page->content, ENT_QUOTES);
				$page->custom_css =  htmlspecialchars_decode($page->custom_css, ENT_QUOTES);
				$page->javascript =  htmlspecialchars_decode($page->javascript, ENT_QUOTES);
				include Crash::$template[$template];
			}else{
				//page cant be found, return 404.
				Crash::error(404, "Thrown in Controller\App. Requested url: $req");	
			}
		}
	}
?>
