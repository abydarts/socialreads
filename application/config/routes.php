<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = '';

$route['home'] = "home/index";

$route['books/book/(:any)'] = "books/book/$1";
$route['books/recenziranje'] = "books/recenziranje";
$route['books/search'] = "books/search";
$route['books/postavi_recenziju'] = "books/postavi_recenziju";
$route['books/recommendations'] = "books/recommendations";
$route['books/(:any)'] = "books/index/$1";
$route['books'] = "books/index";

$route['users/view_message/(:any)'] = "users/view_message/$1";
$route['users/profile/(:any)'] = "users/profile/$1";
$route['users/(:any)'] = "users/index/$1";
$route['users'] = "users/index";
$route['users/friends'] = "users/friends";
$route['users/similarity'] = "users/similarity";
$route['users/friend_request'] = "users/friend_request";
$route['users/confirm_friendship'] = "users/confirm_friendship";
$route['users/requests'] = "users/requests";
$route['users/unfriend'] = "users/unfriend";
$route['users/write_message'] = "users/write_message";
$route['users/send_message'] = "users/send_message";
$route['users/recommendations'] = "users/recommendations";
$route['users/inbox'] = "users/inbox";
$route['users/outbox'] = "users/outbox";

$route['reviews/user_reviews/(:any)'] = "reviews/user_reviews/$1";
$route['reviews/book_reviews/(:any)'] = "reviews/book_reviews/$1";
$route['reviews/review/(:any)/(:any)'] = "reviews/review/$1/$2";
$route['reviews/(:any)'] = "reviews/index/$1";
$route['reviews/my_reviews'] = "reviews/my_reviews";
$route['reviews/postavi_komentar'] = "reviews/postavi_komentar";
$route['reviews/friends_reviews'] = "reviews/friends_reviews";
$route['reviews/import_reviews_to_deviation'] = "reviews/import_reviews_to_deviation";
$route['reviews'] = "reviews/index";

/* End of file routes.php */
/* Location: ./application/config/routes.php */