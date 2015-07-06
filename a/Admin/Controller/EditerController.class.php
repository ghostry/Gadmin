<?php

/**
 * @地区管理
 * @author: Ghostry <ghostry@ghostry.cn>
 * @time: 2014/03
 * @Copyright: blog.ghostry.cn
 */

namespace Admin\Controller;

use Think\Controller;

class EditerController extends CommonController {

    public function __construct() {
	parent::__construct();
	//$this->model = D(CONTROLLER_NAME);
    }

    //编辑器文件上传
    public function upload() {
	//上传类型  image,flash,media,file
	//ini_set('upload_max_filesize', '8M');
	$fileext = array();
	$dir_name = I("get.dir", 'image', 'htmlspecialchars,trim');
	switch ($dir_name) {
	    case 'image':
		$fileext = array('jpg', 'jpeg');
		break;
	    case 'flash':
		$fileext = array('swf', 'flv');
		break;
	    case 'media':
		$fileext = array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb');
		break;
	    case 'file':
		$fileext = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz');
		break;
	}
	$php_url = '/' . UPLOAD_PATH . '/';
	$config = array(
	    'mimes' => array(), //允许上传的文件MiMe类型
	    'maxSize' => 1024000, //上传的文件大小限制 (0-不做限制)
	    'exts' => $fileext, //允许上传的文件后缀
	    'autoSub' => true, //自动子目录保存文件
	    'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
	    'rootPath' => UPLOAD_PATH, //保存根路径
	    'savePath' => $dir_name . '/', //保存路径
	    'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
	    'saveExt' => '', //文件保存后缀，空则使用原后缀
	    'replace' => false, //存在同名是否覆盖
	    'hash' => true, //是否生成hash编码
	    'callback' => false, //检测文件是否存在回调，如果存在返回文件信息数组
	    'driver' => '', // 文件上传驱动
	    'driverConfig' => array(), // 上传驱动配置
	);
	$upload = new \Think\Upload($config);
	$jieguo = $upload->upload();

	//取得最后一次错误信息
	$uploaderror = $upload->getError();
	//取成功返回信息
	//$jieguo = $upload->getUploadFileInfo();
	//$uploaderror = '请500KB以下的jpg图片';
	$json = new \Lib\Services_JSON();
	//var_export($jieguo);
	//\Think\Log::write(var_export($jieguo, TRUE) . UPLOAD_PATH);
	//错误信息空和有返回成功信息则返回URL
	if ($uploaderror == '' && $jieguo) {
	    if ($jieguo['imgFile']) {
		$jieguo['UploadFile'] = $jieguo['imgFile'];
	    }
	    if ($dir_name == 'image') {
		$filename = substr($php_url . $jieguo['UploadFile']['savepath'] . $jieguo['UploadFile']['savename'], 1);
		$im = imagecreatefromjpeg($filename);
		Imagejpeg($im, $filename, 60);
		ImageDestroy($im);
	    }
	    D('System')->setTableNameCN('文件')->log($php_url . $jieguo['UploadFile']['savepath'] . $jieguo['UploadFile']['savename'], '上传');
	    echo $json->encode(array('error' => 0, 'url' => $php_url . $jieguo['UploadFile']['savepath'] . $jieguo['UploadFile']['savename']));
	} else {
	    echo $json->encode(array('error' => 1, 'message' => $uploaderror));
	}
    }

    //编辑器文件浏览器
    public function file_manage() {
	$php_url = UPLOAD_PATH . DIRECTORY_SEPARATOR;

	$root_path = $php_url;
	$root_url = $php_url;
	$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
	//目录名
	$dir_name = I("get.dir", 'image', 'htmlspecialchars,trim');
	if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
	    echo "无效的目录名";
	    exit;
	}
	if ($dir_name !== '') {
	    $root_path .= $dir_name . DIRECTORY_SEPARATOR;
	    $root_url .= $dir_name . DIRECTORY_SEPARATOR;
	    if (!file_exists($root_path)) {
		mkdir($root_path);
	    }
	}

	//根据path参数，设置各路径和URL
	if (empty($_GET['path'])) {
	    $current_path = realpath($root_path) . '/';
	    $current_url = $root_url;
	    $current_dir_path = '';
	    $moveup_dir_path = '';
	} else {
	    $current_path = realpath($root_path) . '/' . $_GET['path'];
	    $current_url = $root_url . $_GET['path'];
	    $current_dir_path = $_GET['path'];
	    $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
	}
	echo realpath($root_path);
	//排序形式，name or size or type
	$order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);

	//不允许使用..移动到上一级目录
	if (preg_match('/\.\./', $current_path)) {
	    echo '没有权限访问';
	    exit;
	}
	//最后一个字符不是/
	if (!preg_match('/\/$/', $current_path)) {
	    echo '无效的参数';
	    exit;
	}
	//目录不存在或不是目录
	if (!file_exists($current_path) || !is_dir($current_path)) {
	    echo '文件夹不存在';
	    exit;
	}

	//遍历目录取得文件信息
	$file_list = array();
	if ($handle = opendir($current_path)) {
	    $i = 0;
	    while (false !== ($filename = readdir($handle))) {
		if ($filename{0} == '.')
		    continue;
		$file = $current_path . $filename;
		if (is_dir($file)) {
		    $file_list[$i]['is_dir'] = true; //是否文件夹
		    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
		    $file_list[$i]['filesize'] = 0; //文件大小
		    $file_list[$i]['is_photo'] = false; //是否图片
		    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
		} else {
		    $file_list[$i]['is_dir'] = false;
		    $file_list[$i]['has_file'] = false;
		    $file_list[$i]['filesize'] = filesize($file);
		    $file_list[$i]['dir_path'] = '';
		    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
		    $file_list[$i]['filetype'] = $file_ext;
		}
		$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
		$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
		$i++;
	    }
	    closedir($handle);
	}

	//排序
	function cmp_func($a, $b) {
	    global $order;
	    if ($a['is_dir'] && !$b['is_dir']) {
		return -1;
	    } else if (!$a['is_dir'] && $b['is_dir']) {
		return 1;
	    } else {
		if ($order == 'size') {
		    if ($a['filesize'] > $b['filesize']) {
			return 1;
		    } else if ($a['filesize'] < $b['filesize']) {
			return -1;
		    } else {
			return 0;
		    }
		} else if ($order == 'type') {
		    return strcmp($a['filetype'], $b['filetype']);
		} else {
		    return strcmp($a['filename'], $b['filename']);
		}
	    }
	}

	usort($file_list, 'cmp_func');

	$result = array();
	//相对于根目录的上一级目录
	$result['moveup_dir_path'] = $moveup_dir_path;
	//相对于根目录的当前目录
	$result['current_dir_path'] = $current_dir_path;
	//当前目录的URL
	$result['current_url'] = $current_url;
	//文件数
	$result['total_count'] = count($file_list);
	//文件列表数组
	$result['file_list'] = $file_list;

	//输出JSON字符串
	$json = new Services_JSON();
	echo $json->encode($result);
    }

}
