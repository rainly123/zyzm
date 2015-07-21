<?php 
namespace Home\Controller;
use Think\Template\Driver\Mobile;
class InfoController extends HomeController {

	public function about() {
        $about = I('about');
        if ($about == '') {
		    $this->pageTitle = "关于我们";
		} elseif ($about == 'zc') {
		    $this->pageTitle = "关于众筹";
		}
		$this->assign('about', $about);
        $this->display();
	}
	public function contact() {
            $this->display();
    	}
	public function show() {
		$key= $_GET['key'];
		
		$info = M('Info')->where(array('key_word'=>$key))->find();
		if ($info) {
			$info_menu = M('Info')->field('key_word, title')->order('level DESC,id DESC')->select();
			$this->info_menu = $info_menu;
			$this->info = $info;
			$this->pageTitle = $info['title'];
			$this->key_word = $key;

			$this->display();	
		} else {
			$this->error('页面不存在.', U('Index/index'));
		}
	}
	
	//系统公告
	public function notice() {
		//公告ID
		$id= $_GET['id'];
	
		//获取公告信息
		$info = M('Notice')->where(array('id'=>$id))->find();
		if ($info) {
			//热门项目
			$where1 = array('stage' => array('neq', 9));
			
			$hot_lists = M('ProjIndex')->where($where1)->order('like_record desc, read_record desc')->limit(3)->select();
			
			//返回跳转
			$this->assign("backurl",U('Info/infolist',array('type'=>1)));
			
			$this->pageTitle = $info['title'];
			$this->assign('project',$hot_lists);
			$this->info = $info;
			$this->display();
		} else {
			$this->error('页面不存在.', U('Index/index'));
		}
	}

  public function noticelist() {
  	//每页显示条数
  	$onepage =10;
  	
  	//计算件数
  	$totalCounter = M("Notice")->where('status = 0')->count();
  	$Page = new \Think\Page($totalCounter,$onepage);
  	$show= $Page->show();
  	
    $notice = M("Notice")->field(array('id','create_time','left(title,14)'=>title))->where('status = 0')->
    order('is_top desc,update_time desc')->limit($Page->firstRow,$onepage)->select();
   //$this->assign('notice',$notice);

    //获取当天的公告ID
    $notice_key=0;
    foreach ($notice as $k => $v) {
    		
    	//获取当天日期
    	$timetoday = strtotime(date("Y-m-d",time()));
    	if(strtotime(date("Y-m-d",$v['create_time']))==$timetoday){
    		$noticearray[$notice_key]=$v['id'];
    		$notice_key++;
    	}
    }
    
    //公告
    $noticelist=implode(",",$noticearray);
    
    $this->assign('noticelist',$noticelist);
    
    $this->assign('lists',$notice);
    $this->assign('Pages',$show);
	$this->pageTitle = "网站公告列表";
    $this->display();
  }
  
  public function infomationlist() {
  	//每页显示条数
  	$onepage =10;

  	//计算件数
  	$totalCounter = M("Infomation")->where('status = 1')->count();
 
  	$Page = new \Think\Page($totalCounter,$onepage);
  	$show= $Page->show();
  	$notice = M("Infomation")->field(array('id','create_time','left(title,14)'=>mobiletitle,'title'))->where('status = 1')->
  	order('level desc,update_time desc')->limit($Page->firstRow,$onepage)->select();
  	 
  	//获取当天的资讯ID
  	$news_key=0;
  	foreach ($notice as $k => $v) {
  		 
  		//获取当天日期
  		$timetoday = strtotime(date("Y-m-d",time()));
  		if(strtotime(date("Y-m-d",$v['create_time']))==$timetoday){
  			$newsarray[$news_key]=$v['id'];
  			$news_key++;
  		}
  	}
  	 
  	//资讯
  	$newslist=implode(",",$newsarray);
  	
  	$this->assign('newslist',$newslist);
  	$this->assign('lists',$notice);
  	$this->assign('Pages',$show);
  
  	$this->pageTitle = "资讯列表";
  	$this->display();
  }
  
  //资讯
  public function infomation() {
  	//公告ID
  	$id= $_GET['id'];
  
  	//获取公告信息
  	$info = M('Infomation')->where(array('id'=>$id))->find();

  	if ($info) {
  		//修改阅读数
  		M('Infomation')->where(array('id'=>$id))->setInc('view');
  		//热门项目
		$recomendList = recommendFoundings();
		if(count($recomendList['project'])>4){
			$recomendList['project'] = array_slice($recomendList['project'],0,4);
			$recomendList['product'] = null;
		}else{
			if(count($recomendList['product'])>0){
				$recomendList['product'] = array_slice($recomendList['product'],0,4-count($recomendList['project']));
			}
			
		}
  		
		//热门文章
		$hotinfo = M('Infomation')->field(array('id','create_time','left(title,14)'=>title))->where(array('status'=>1,'id'=>array('neq',$id)))->order('level desc,view desc,comment desc,create_time desc')->limit(5)->select();
		
  		//名家点评
  		$comments = M('InfomationComment')->where(array('pid'=>$info['id'],'status'=>0))->order('level desc, create_time desc')->select();

  		//手机端评论留言
  		if (isMobile()) {
  			$cmt = M('InfoComment')->order('create_time desc')->where(array('project_id'=>$id))->select();
  			$info['infocomments'] = get_format_comment($cmt, 5); //$model->getComments($id,5);
  		}
  		
  		//返回跳转
  		$this->assign("backurl",U('Info/infolist'));
  		
  		$this->pageTitle = $info['title'];
  		$this->assign('recomendList',$recomendList);
  		$this->assign('comments',$comments);
  		$this->assign('hotinfo',$hotinfo);
  		$this->assign('infocomment',$infocomment);
  		$this->info = $info;
  		$this->display();
  	} else {
  		$this->error('资讯不存在.', U('Index/index'));
  	}
  }
  
  public function infolist() {
  	$type= $_GET['type'];
  	//获取banner信息
  	$bannerList = M('Banner')->where(array('status' => array('EQ', 0)))->order('sort asc,id desc')->select();
  	
  	//公告ID
  	$notice = M("Notice")->field(array('id','create_time','left(title,14)'=>title))->where('status = 0')->
  	order('is_top desc,update_time desc')->select();
  	
  	//资讯信息
  	$infomation = M("Infomation")->field(array('id','cover','create_time','left(title,14)'=>title))->where('status = 1')->
  		order('level desc,update_time desc')->select();
  	
  	//获取当天的公告ID
  	$notice_key=0;
  	foreach ($notice as $k => $v) {
  		 
  		//获取当天日期
  		$timetoday = strtotime(date("Y-m-d",time()));
  		if(strtotime(date("Y-m-d",$v['create_time']))==$timetoday){
  			$noticearray[$notice_key]=$v['id'];
  			$notice_key++;
  		}
  	}
  	 
  	//获取当天的资讯ID
  	$news_key=0;
  	foreach ($infomation as $k => $v) {
  	
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
  	 
  	
  	//返回跳转
  	$this->type=$type;
  	$this->assign('noticelist',$noticelist);
  	$this->assign('newslist',$newslist);
  	$this->assign("backurl",U('Index/index'));
  	$this->assign('notice',$notice);
  	$this->assign('news',$infomation);
  	$this->assign('bannerList',$bannerList);
  	$this->pageTitle = "网站信息";
  	$this->display();
  }
  
  // 发表评论
  public function comment() {
  	if(!isMobile()){
  		if (IS_POST) {
  			if (empty($_POST['content'])) {
  				$this->error('请输入评论内容。');
  			}
  			$project_id = $_POST['project_id'];
  			$user_id = is_login();
  			$reply_id = $_POST['reply_id'];
  
  			$comment = array('project_id' => $project_id,
  					'comment_user' => $user_id,
  					'content' => $_POST['content'],
  					'reply_id' =>$reply_id,
  					'create_time' => NOW_TIME,
  					'create_id' => $user_id,
  					'update_time' => NOW_TIME,
  					'update_id' => $user_id,
  					'dynamicid'=>I('dynamicid'),);
  			$id = M('InfoComment')->add($comment);
  
/*   			$proj=M('Product')->where('id ='.$project_id)->field('name, uid')->find();
  
  			$ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
  					get_membername($user_id).'</a>';
  			$plink = '<a href="'.U('Product/viewdetail?pid='.$project_id).'">《'.
  					$proj['name'].'》</a>';
  			if ($user_id != $proj['uid']) {
  				$content = $ulink . '评论了您的'. $plink . '项目';
  				D('Message')->send(0,$proj['uid'],'', $content, 3);
  			} */
  
  			if ($reply_id) {
  				$rep = M('InfoComment')->where('id='.$reply_id)->getField('comment_user');
/*   				if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
  					$content = $ulink . '回复了您对'. $plink . '项目的评论';
  					D('Message')->send(0,$rep,'', $content, 3);
  				} */
  			}
  
  			$comment['id'] = $id;
  			$comment['comment_user'] = $user_id;
  			$comment['user_face'] = get_memberface($user_id);
  			$comment['date'] = change_date($comment['create_time']);
  			$comment['status'] = 1;
  			$comment['user_name'] = get_membername($user_id);
  			$comment['old_user'] = $_POST['old_user'];
  			$comment['old_content'] = $_POST['old_content'];
  			$comment['status'] = 1;
  
  			$this->ajaxReturn($comment);
  		}
  	}else{
  		$project_id = $_POST['project_id'];
  		$user_id = is_login();
  		$reply_id = $_POST['reply_id'];
  		$comment = array('project_id' => $project_id,
  				'comment_user' => $user_id,
  				'content' => $_POST['content'],
  				'reply_id' =>$reply_id,
  				'create_time' => NOW_TIME,
  				'create_id' => $user_id,
  				'update_time' => NOW_TIME,
  				'update_id' => $user_id,
  				'dynamicid'=>I('dynamicid'),);
  		$id = M('InfoComment')->add($comment);
  
/*   		$proj=M('Product')->where('id ='.$project_id)->field('name, uid')->find();
  
  		$ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
  				get_membername($user_id).'</a>';
  		$plink = '<a href="'.U('Product/viewdetail?pid='.$project_id).'">《'.
  				$proj['name'].'》</a>';
  		if ($user_id != $proj['uid']) {
  			$content = $ulink . '评论了您的'. $plink . '项目';
  			D('Message')->send(0,$proj['uid'],'', $content, 3);
  		} */
  
  		if ($reply_id) {
  			$rep = M('InfoComment')->where('id='.$reply_id)->getField('comment_user');
  			/* if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
  				$content = $ulink . '回复了您对'. $plink . '项目的评论';
  				D('Message')->send(0,$rep,'', $content, 3);
  			} */
  		}
  		$comment['id'] = $id;
  		$comment['comment_user'] = $user_id;
  		$comment['user_face'] = get_memberface($user_id);
  		$comment['date'] = change_date($comment['create_time']);
  		$comment['status'] = 1;
  		$comment['user_name'] = get_membername($user_id);
  		$comment['old_user'] = $_POST['old_user'];
  		$comment['old_content'] = $_POST['old_content'];
  
  		$this->ajaxReturn($comment);
  
  	}
  
  }
  
  function makereply(){
  	$this->assign('reply_id',I('reply_id'));
  	$this->assign('project_id',I('project_id'));
  	$this->display();
  }
  
  //手机端查看更多评论
  function morecomment(){
  	$pid =I('pid');
  	//$comments = M('CommentReply')->order('create_time desc')->where(array('project_id'=>I('pid')))->select();
  	$cmt = M('InfoComment')->order('create_time desc')->where(array('project_id'=>$pid))->select();
  	$comments = get_format_comment($cmt, count($cmt)); //$model->getComments($id,5);
  	
  	//返回跳转
  	$this->assign("backurl",U('Info/infomation?id='.$pid));
  	$this->assign('pageTitle','更多回复');
  	$this->assign('comments',$comments);
  	$this->display();
  }
  
  //手机上的评论
  function postcomment() {
  	$this->display('postcomment');
  }
  
}
?>