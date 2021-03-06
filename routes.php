<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;
use Elements\Comment as Comment;

require Crash::$controller['app'];
require Crash::$controller['users'];
require Crash::$controller['admin'];
require Crash::$controller['athenaeum'];
require Crash::$controller['search'];
use Controller\Admin\Controller as AdminController;
use Controller\Users\Controller as UsersController;
use Controller\Reader\Controller as ReaderController;
use Controller\Search\Controller as SearchController;
use Controller\App\Controller as DefaultController;



$forward = new Router();
/* Static routes */
$forward->route("/crash/", function(){
    DefaultController::process("home");
});
/* search routes */
$forward->route("/crash/search", function(){
    SearchController::search($_GET['query']);
});
$forward->route("/crash/fandom",function($name){
    SearchController::fetchFandom($name);
});
/* Reader routes*/
$forward->route("/crash/athenaeum",function($title){
    $pub = Publication::getPublicationByUrl($title);
    ReaderController::showReader($pub);
});
/* Admin routes */
if(isset($_SESSION['protagonist']) && $_SESSION['protagonist']->administrator){//verify permission level 
    $forward->route("/crash/admin/users/disable",function(){
        if($_GET['id_user']==$_SESSION['protagonist']->id && $_SESSION['protagonist']->administrator) Crash::error(403,"You can't disable your own account because you are an administrator");
        AdminController::disableUser($_GET['id_user']);
    });
    $forward->route("/crash/admin/users/enable",function(){
        AdminController::enableUser($_GET['id_user']);
    });
    $forward->route("/crash/admin/users/demote",function(){
        AdminController::demoteUser($_GET['id_user']);
    });
    $forward->route("/crash/admin/users/elevate",function(){
        AdminController::elevateUser($_GET['id_user']);
    });
    $forward->route("/crash/admin/users",function(){
        AdminController::showUsers();
    });
    $forward->route("/crash/admin/fandoms", function(){
        AdminController::showFandomRequests();
    });
    $forward->route("/crash/admin/fandoms/accept", function(){
        AdminController::acceptFandomRequest($_GET['id']);
    });
    $forward->route("/crash/admin/fandoms/deny", function(){
        AdminController::denyFandomRequest($_GET['id']);
    });

    $forward->route("/crash/admin", function(){
        AdminController::showPanel();
    });
    $forward->route("/crash/admin/pages", function(){
        AdminController::showPagesManager();
    });
    $forward->route("/crash/admin/pages/edit", function(){
        AdminController::showPageEditor($_GET['id']);
    });
    $forward->route("/crash/admin/pages/edit", function(){
        AdminController::updatePage($_POST);
    },"POST");
    $forward->route("/crash/admin/pages/new", function(){
        AdminController::showPageEditor();
    });
    $forward->route("/crash/admin/pages/new", function(){
        AdminController::insertNewPage($_POST);
    },"POST");
    $forward->route("/crash/admin/pages/delete", function(){
        AdminController::deletePage($_GET['id']);
    });
}
/* user specific routes */
//this route is used to log in users so we don't verify anything
$forward->route("/crash/users/enlist", function(){
    UsersController::enlist();
},"POST");

if(isset($_SESSION['protagonist'])){//verify if user is logged in
    /* fandom request routes */
    $forward->route("/crash/users/fandom/request", function(){
        UsersController::showFandomForm();
    });
    $forward->route("/crash/users/fandom/request", function(){
        UsersController::insertFandom($_POST);
    },"POST");
    /* comment management routes */
    $forward->route("/crash/athenaeum/comment/post",function(){
        //verify if id_user is that of the current logged in user
        if($_POST['id_user']!=$_SESSION['protagonist']->id) Crash::error(403,"This action was unauthorized");
        UsersController::leaveComment($_POST);
    },"POST");
    $forward->route("/crash/athenaeum/comment/delete",function(){
          //verify if id_user is that of the current logged in user
        $comment = Comment::getCommentById($_GET['id_comment']);
        if($comment->users_id_user != $_SESSION['protagonist']->id) Crash::error(403,"This action was unauthorized");
            UsersController::deleteComment($_GET['id_comment'],$_GET['uri_redirect_back']);
    });
    /* kudo management routes*/
    $forward->route("/crash/athenaeum/kudo/give", function(){
        //verify if id_user is that of the current logged in user and user is not the author of this publication 
        if(!($_GET['id_user']==$_SESSION['protagonist']->id && $_SESSION['protagonist']->id != Publication::getPublicationById($_GET['id_publication'])->users_id_user)) Crash::error(403,"This action was unauthorized. You either attempted to give kudo as another user or on your own work.");
            UsersController::leaveKudo($_GET['id_user'],$_GET['id_publication']);
    });
    $forward->route("/crash/athenaeum/kudo/withdraw",function(){
        //verify if id_user is that of the current logged in user
        if($_GET['id_user']!=$_SESSION['protagonist']->id) Crash::error(403,"This action was unauthorized");
        UsersController::withdrawKudo($_GET['id_user'],$_GET['id_publication']);
    });
    /** user account management routes*/
    $forward->route("/crash/users/delete", function(){
        UsersController::confirmDeletion();
    });
    $forward->route("/crash/users/delete", function(){
        UsersController::deleteAccount($_SESSION['protagonist']->id);
    },"POST");
    $forward->route("/crash/users/avatar",function(){
        UsersController::showAvatarForm();
    });
    $forward->route("/crash/users/avatar",function(){
        //verify if user is that of the current logged in user
        if($_POST['id_user'] != $_SESSION['protagonist']->id) Crash::error(403,"Unauthorised profile picture change. This incident will be reported.");
        UsersController::changeAvatar($_POST);
    },"POST");
    $forward->route("/crash/users/password",function(){
        UsersController::showPasswordForm();
    });
    $forward->route("/crash/users/password",function(){
        //verify if user is that of the current logged in user
        if($_POST['id_user'] != $_SESSION['protagonist']->id) Crash::error(403,"Unauthorised password change. This incident will be reported.");
            UsersController::changePassword($_POST);
    },"POST");
    $forward->route("/crash/users/username",function(){
        UsersController::showUsernameForm();
    });
    $forward->route("/crash/users/username",function(){
        //verify if user is that of the current logged in user
        if($_POST['id_user'] != $_SESSION['protagonist']->id) Crash::error(403,"Unauthorised username change. This incident will be reported.");
            UsersController::changeUsername($_POST);
    },"POST");
    $forward->route("/crash/users/logout", function(){
        UsersController::logout();
    },"POST");
    $forward->route("/crash/users/profile", function(){
        UsersController::showDashboard();
    });
    /** publication management routes */
    $forward->route("/crash/users/scriptorium", function(){
        UsersController::showScriptorium();
    });
    $forward->route("/crash/users/scriptorium/publication/delete", function(){
        if($_SESSION['protagonist']->id != Publication::getPublicationById($_GET['id_pub'])->users_id_user) Crash::error(403,"You aren't an author of this publication");
            UsersController::deletePublication($_GET['id_pub']);
    });
    $forward->route("/crash/users/scriptorium/publication/editor", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if(isset($_GET['id_pub'])){
            if($_SESSION['protagonist']->id != Publication::getPublicationById($_GET['id_pub'])->users_id_user) Crash::error(403,"You aren't an author of this publication");
            UsersController::showPublicationEditor($_GET['id_pub']);
        }else{
            UsersController::showPublicationEditor();
        }        
    });
    $forward->route("/crash/users/scriptorium/publication/new",function(){
        //verify if id's have not been tampered with 
        if($_REQUEST['users_id_user']!=$_SESSION['protagonist']->id) Crash::error(403,"You don't have permission to publish this publication");
        UsersController::insertNewPublication($_POST);
    },"POST");
    $forward->route("/crash/users/scriptorium/publication/edit",function(){
        //verify if id's have not been tampered with 
        if($_REQUEST['users_id_user']!=$_SESSION['protagonist']->id) Crash::error(403,"You don't have permission to edit this publication");
        UsersController::updatePublication($_POST);
    },"POST");
    /** leaflet management routes */
    $forward->route("/crash/users/scriptorium/leaflet", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if($_SESSION['protagonist']->id != Publication::getPublicationById($_GET['id'])->users_id_user) Crash::error(403,"You aren't an author of this publication");
        UsersController::showLeafOverview($_GET['id']);
    });
    $forward->route("/crash/users/scriptorium/leaflet/editor", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if($_SESSION['protagonist']->id != Publication::getPublicationById($_GET['id_pub'])->users_id_user) Crash::error(403,"You aren't an author of this publication");
        UsersController::showLeafEditor($_GET['id_pub'],$_GET['id_leaf']);
    });
    $forward->route("/crash/users/scriptorium/leaflet/new", function(){
        //TODO verify that supplied publication id is that of a publication owned by current user 
        if($_SESSION['protagonist']->id != Publication::getPublicationById($_POST['id_publication'])->users_id_user) Crash::error(403,"You aren't an author of this publication");
        UsersController::insertNewLeaf($_POST);        
    }, "POST");
    $forward->route("/crash/users/scriptorium/leaflet/delete", function(){
        //verify that supplied publication id is that of a publication owned by current user and that the leaflet belongs to that publication
        $pub = Publication::getPublicationById($_GET['id_pub']);
        $user = $_SESSION['protagonist'];
        $leaf = Leaflet::getLeafletById($_GET['id_leaf']);
        if($user->id == $pub->users_id_user && $leaf->publications_id_publication == $pub->id) Crash::error(403,"You aren't an author of this publication or the page does not belong to this publication");
        UsersController::deleteLeaflet($_GET['id_leaf']);
    });
    $forward->route("/crash/users/scriptorium/leaflet/edit", function(){
        //verify that supplied publication id is that of a publication owned by current user and that the leaflet belongs to that publication
        $pub = Publication::getPublicationById($_POST['id_publication']);
        $user = $_SESSION['protagonist'];
        $leaf = Leaflet::getLeafletById($_POST['id_leaf']);
        if($user->id == $pub->users_id_user && $leaf->publications_id_publication == $pub->id) Crash::error(403,"You aren't an author of this publication or the page does not belong to this publication");
        UsersController::updateLeaf($_POST); 
    },"POST");
}

?>
