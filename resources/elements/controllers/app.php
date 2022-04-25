<?php
namespace Controller\App;
use Crash\Crash as Crash;
use Elements\Page as Page;
/*
* This controller processes default pages. usually static pages, which reside in views folder.
*/
	function process($req, $eval=null, $template='default'){
		//we can pass a function $f if we want the controller to ewaluate something prior (like passing a modal message)
		if(isset($eval)){
			$eval();
		}
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
				Crash::error(404, "Thrown in Controller\App. Requested url: $req");
			}
		}
	}
?>
