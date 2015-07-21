<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
  public function index(){

//      $category = D('Category')->getTree();
//      $lists    = D('Document')->lists(null);
//
//      $this->assign('category',$category);//栏目
//      $this->assign('lists',$lists);//列表
//      $this->assign('page',D('Document')->page);//分页
	  	//获取系统公告
	  	$notice = M("Notice")->field(array('id','create_time','title'))->where('status = 0')->
	  	order('is_top desc,create_time desc')->limit(6)->select();
	  	//获取系统公告
	  	$news = M("Infomation")->field(array('id','create_time','title'))->where('status = 1')->
	  	order('level desc,create_time desc')->limit(6)->select();
  	
	  	//获取当天的资讯ID
	  	$notice_key=0;
	  	foreach ($notice as $k => $v) {
	  		 
	  		//获取当天日期
	  		$timetoday = strtotime(date("Y-m-d",time()));
	  		if(strtotime(date("Y-m-d",$v['create_time']))==$timetoday){
	  			$noticearray[$notice_key]=$v['id'];
	  			$notice_key++;
	  		}
	  	}
	  	 
	  	//获取当天的公告ID
	  	$news_key=0;
	  	foreach ($news as $k => $v) {
	  	
	  		//获取当天日期
	  		$timetoday = strtotime(date("Y-m-d",time()));
	  		if(strtotime(date("Y-m-d",$v['create_time']))==$timetoday){
	  			$newsarray[$news_key]=$v['id'];
	  			$news_key++;
	  		}
	  	}
	  	
	  	//公告
	  	$noticelist=implode(",",$noticearray);
	  	//资讯
	  	$newslist=implode(",",$newsarray);
  	
    if (!isMobile()){
			$project = D('Project')->getProjectIndex();
		
			//$this->stock = M('Stock')->where(array('status'=>1))->order('create_time desc')->select();
			$bannerList = M('Banner')->where(array('status' => array('EQ', 0)))->order('sort asc,id desc')->select();

			//$productList = M('Product')->where(array('status' => 9,
			//	'stage'=> array(array('gt', 1), array('lt', 9), array('neq', 8), 'AND')))->
			//	order('is_sort desc,start_time desc')->limit(4)->select();

      //通过审核的可以被众筹的项目
      $appovedFundingProjectList = D('Project')->getFundingProjects();
      //$appovedFundingProductList = D('Product')->getFundingProductsInfo();
        
			//$appovedFundingStocksList = D('Stock')->getFundingStcokInfo();
      //int_to_string($productList,
			//	array('stage'=>array(0=>'筹备中',1=>'预热中',2=>'众筹中',8=>'众筹失败',9=>'众筹成功')));

      	$suminfo = get_sum_info();

			$this->pageTitle = "中瀛智募";
			$this->assign('project',$project);

			$this->assign('suminfo',$suminfo);
			$this->assign('notice',$notice);
			$this->assign('news',$news);
			$this->assign('bannerList',$bannerList);
			$this->links = M('Link')->field(array('name', 'logo', 'url'))->where(array('status'=>1))->limit(12)->order('sort desc')->select();
			//$this->assign('productList',$productList);
      //$this->assign('appovedFundingProjectList',$appovedFundingProjectList);
      //$this->assign('appovedFundingProductList',$appovedFundingProductList);
      //$this->assign('appovedFundingStcokList',$appovedFundingStocksList);
    }else{
      $this->pageTitle = '';
      $bannerList = M('Banner')->where(array('status' => array('EQ', 0)))->order('sort asc,id desc')->select();
      $this->assign('bannerList',$bannerList);

      $mobileList = recommendMobileFoundings();
      unset($mobileList['stock']);
      $this->assign('mobileList',$mobileList);
    }
    
    $this->assign('noticelist',$noticelist);
    $this->assign('newslist',$newslist);
  	$this->display();
  }

	/**
	 * 手机端 首页咨询内容资讯页面
	 */
  public function newsindex() {
  	//获取系统公告
		$notice = M("Notice")->field(array('id','update_time','title'))->where('status = 0')->
			order('is_top desc,update_time desc')->select();
		//获取系统公告
		$news = M("Infomation")->field(array('id','update_time','title'))->where('status = 0 and display = 1')->
			order('level desc,update_time desc')->select();

			dump($new);

		$bannerList = M('Banner')->where(array('status' => array('EQ', 0)))->order('sort asc,id desc')->select();

		$this->assign('notice',$notice);
		$this->assign('news',$news);
		$this->assign('bannerList',$bannerList);
		$this->display('newsindex');
  }

  public function getinfo() {
  	$type = I('type', 0);
  	$id = I('id');
  	if ($type == 0) {
  		$data = M("Notice")->field(array('content', 'title', 'id'))->find($id);
  		$temp = strip_tags($data['content']);
  		$temp = str_replace("\r", '', $temp);
  		$temp = str_replace("\n", '', $temp);
  		$content = mb_substr($temp, 0, 300, 'utf-8');
  		$url = U('Info/notice?id='.$data['id']);
  		$this->ajaxReturn(array('status'=> 1, 'content'=>$content, 'url'=>$url, 'title'=>$data['title']));
  	} else {
  		$data = M("Infomation")->field(array('description', 'title'))->find($id);
  		$temp = strip_tags($data['description']);
			$url = U('Info/infomation?id='.$data['id']);
  		$this->ajaxReturn(array('status'=> 1, 'content'=>$temp, 'url'=>$url, 'title'=>$data['title']));
  	}
  }

}