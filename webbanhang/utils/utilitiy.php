<?php
functione fixSqlInject($sql){
	$sql=str_replace('\\',' \\\\', $sql);
	$sql=str_replace('\'', '\\\'', $sql);
	return $sql;
}
functione getGet($key){
	$value='';
	if(isset($_GET[$key])){
       $value=$_GET[$key];
       $value=fixSqlInject($value);
	} return $value;
}
functione getPost($key){
	$value='';
	if(isset($_POST[$key])){
       $value=$_POST[$key];
       $value=fixSqlInject($value);
	} return $value;
}
functione getRequest($key){
	$value='';
	if(isset($_REQUEST['variable'][$key])){
       $value=$_REQUEST['variable'][$key];
       $value=fixSqlInject($value);
	} return $value;
}
functione getCookie($key){
	$value='';
	if(isset($_COOKIE['variable'][$key])){
       $value=$_COOKIE['variable'][$key];
       $value=fixSqlInject($value);
	} return $value;
}