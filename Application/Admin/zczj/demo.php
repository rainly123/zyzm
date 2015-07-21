<?php
include_once("zczj.api.php"); 


//===============初始化==================//
$options = array(
    'debug' => true,
    'UserName' => '用户名',
	'PassWord' => '密码',
	'PlatId' => 2,
);
$zczj = new zczj($options);


//===============上传项目==================//
$projects = array(
  	  'PlatProjectID' => "193",
  	  'projectName' => "测试项目",
	  'description' => "测试项目，项目描述",
	  'currentAmount' => 100,
	  'targetAmount' => 10000,
  	  'endTime' => "2014-01-13T00:00:00.000",
      'targetDay' => 30,
      'projectSponsor' => "文武",
	  'support' => 5,
	  'state' => 1,
      'projectCategoryId' => 23673,
	  'fileBytes' => @file_get_contents("test.jpg"),
	  'fileName' => "test.jpg",
	  'url' => "http://www.dajiachou.com/view/191/-",
);
$zczj->projectsAdd($projects);


//===============上传平台数据==================//
$platdata = array(
  	  'investmentNum' => 100,
  	  'totalVolume' => 500,
	  'transactionCyde' => 30,
	  'valuation' => 580,
	  'transactionNum' => 30,
	  'completeRate' => 25,
);
$zczj->platDataAdd($platdata);


//===============上传投资人数据==================//
$investordata[0] = array(
   		'InvestorName' => 'a',
   		'Avatar' => 'http://static.cnblogs.com/images/logo_small.gif',
	    'Amount' => 30000,
	    'Type' => 1,
	    'PostDate' => "2014-12-23T00:00:00.000",
);
$zczj->projectInvestorsAdd('44128',$investordata);




