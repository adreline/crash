<?php
namespace Controller\App;
use Crash\Crash;
use Elements\Page;
use Elements\Head;

/*
* This controller processes default pages. usually static pages, which reside in views folder.
*/
class Controller{
	public static function process($req, $middleware=null, $template='default'){
		//check if requested page is present in static pages 
		if (isset(Crash::$static_page[$req])) {
			//reneder the page
			include Crash::$static_page[$req];
		}else{
			//check if requested page is present in the database
			$page = Page::getPageByName($req);
			if ($page instanceof Page) {
				//page present, fetch assoc head section
				global $head;
				$head = Head::getHead($page->id);
				//reverse htmlspecialchars 
				$page->content =  htmlspecialchars_decode($page->content, ENT_QUOTES);
				$page->custom_css =  htmlspecialchars_decode($page->custom_css, ENT_QUOTES);
				$page->javascript =  htmlspecialchars_decode($page->javascript, ENT_QUOTES);
				//render the page
				include Crash::$template[$template];
			}else{
				//page cant be found, throw 404.
				throw new Exception('404');	
			}
		}
	}
}

?>
