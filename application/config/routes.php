<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//l1-一级分类，l2-二级分类，l3-三级分类，d-区县，a-片区，s-性别，t-类型，stu-是否大学生，f-是否涉外，r-是否实名认证，o-是否上门服务，or-顺序,p-当前页码
//$route['lista/(l1|l2|l3|d|a|s|t|stu|f|r|o|or|p)/(\d*)/'] = 'lista/index';//搜索工种列表
//$route['/lista\/((\w+)\/\d*\/)+/'] = 'lista/index';//搜索工种列表
//$route['lista/((\w+)/(\d*)/)*']  = 'lista/index';//搜索工种列表
//$route['lista/st/(\d+)'] = 'lista/index';//大学生
//$route['lista/or/(\d+)'] = 'lista/index';//顺序
//$route['lista/l1/(\d+)'] = 'lista/index';//一级分类
//$route['lista/l1/(\d+)/l2/(\d+)'] = 'lista/index';//二级分类
//$route['lista/l1/(\d+)/l2/(\d+)/l3/(\d+)'] = 'lista/index';//三级分类
//$route['lista/l1/(\d+)/l2/(\d+)/l3/(\d+)/d/(\d+)/a/(\d+)/s/(\d+)/t/(\d+)/stu/(\d+)/f/(\d+)/r/(\d+)/o/(\d+)/or/(\d+)/p/(\d+)'] = 'lista/index';
