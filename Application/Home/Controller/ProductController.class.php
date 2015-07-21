<?php 
namespace Home\Controller;

use Common\data\dataTab;

class ProductController extends HomeController {
	
	public function index(){
		$parSort = I('parSort');
		$page = I('p');
		$categoryId = I('categoryId');

		if (empty($page)) {
			$page = 1;
		}
		switch ($parSort) {
			case 'all':
				$order = 'start_time desc';
				break;
			case 'new_line':
				$order = 'start_time desc';
				break;
			case 'more_amount':
				$order = 'amount desc';
				break;
			case 'more_like':
				$order = 'like_record desc';
				break;
			default:
				$order = 'start_time desc';
				break;
		}
		if (!empty($categoryId)) {
			$where['tags'] = $this->getcateIdsByHomepageid($categoryId);
		}elseif ($categoryId == 0) {
			unset($where['tags']);
		}
		
		$product = M('Product'); // 实例化product对象
		// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
		$order = 'is_over desc,stage,' . $order;
		$list = $product->where(array('status' => 9,'stage >1'))->order($order)->page($page.',8')->select();
		
		//热门
		$projects = M('Project')->where(array('status'=>9,'stage'=>array(array('gt', 0),array('lt', 8),'and')))->
			order('stage desc, is_top desc, create_time desc')->limit(4)->select();
		
		int_to_string($list,
		array('stage'=>array(0=>'筹备中',1=>'预热中',2=>'众筹中',8=>'众筹失败',9=>'众筹成功')));
		$this->assign('list',$list);// 赋值数据集
		$count      = $product->where(array('status' => 9,'stage >1'))->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('projects',$projects);// 赋值数据集
		$this->display(); // 输出模板

	}

	//创建首页
	public function create()
	{
		$this->login();

		$this->display();
	}

	//TODO 实物众筹创建第一步
	public function addstep1(){
		$this->login();
		$pid = $_GET['pid'];
		$uid = is_login();
		$modelProduct = M('product');
		$modelProductInfo = M('ProductInfo');
			
		if (IS_POST) {
			$product = $_POST;
			//更新修改场合不修改start_time
			//$product['start_time'] = time();
			//项目分类
			//$product['types'] = $product['hidtype'];
			//项目标签
			$hidtags = $_POST['tags'];
			if (isset($hidtags)) {
				foreach ($hidtags as $key => $value) {
					if($key==0){
						$tags = $value;
					}else{
						$tags = $tags.','.$value;
					}
				}
			}
			$product['tags'] = $tags;
			$product['describe'] = $product['projectSummary'];
			$product['update_time'] = $product['create_time']= time();
			$product['create_id'] = $product['update_id'] = $product['uid'] = $uid;

			if($pid > 0){
				$isProduct = $modelProduct->where(array('id'=>$pid))->find();
				if (empty($isProduct)) {
					$this->error('此众筹项目不存在');
				}
				//数据已存在，则更新
				$id = $modelProduct->where(array('id'=>$pid))->save($product);
			}else{
				$product['start_time'] = time();
				//添加操作
				$id = $modelProduct->add($product);
			}

			if ($id === false) {
				//保存失败
				$this->error('部分信息保存失败');
			}else{
				$productInfo['pro_img'] = $product['pro_img'];
				$productInfo['video_path'] = $product['videoAddr'];
				$productInfo['content'] = $product['datail'];
				$productInfo['create_id'] = $productInfo['update_id'] = $uid;;
				$productInfo['update_time'] = $productInfo['create_time']= time();
				//修改数据
				if ($pid >0) {
					$productInfo['pid'] = $pid;
					$id=$pid;
					$resultProductInfo = $modelProductInfo->where(array('pid'=>$pid))->save($productInfo);
				}else{
					$productInfo['pid'] = $id;
					$resultProductInfo = $modelProductInfo->add($productInfo);;
				}
				
				if ($resultProductInfo === false) {
					$this->error('部分信息保存失败');
				}
			}
	
			//$this->ajaxReturn($data)(U('addstep2', array('pid'=>$id)));
			
			$this->success('处理成功！', U('addstep2', array('pid'=>$id)));
		}else{
			//如果pid有值
			if ($pid > 0) {
				//获取信息
				$aProduct = $modelProduct->where(array('id'=>$pid))->find();
				$aProductInfo = $modelProductInfo->where(array('pid'=>$pid))->find();
			}
			//项目分类
			$pj_type = M('ProjectType')->where(array('status'=>0))->order('sort')->select();

			//
			$tags = $aProduct['tags'];
			if($tags){
				$valore=split(",",$tags);
				
				$aProduct[arry_tag]=$valore;
			
			}

			$this->assign('pj_type',$pj_type);
			$this->assign($aProduct);
			$this->assign('aProductInfo',$aProductInfo);
			$this->assign('navFlage','step1');
			$this->display();
		}

	}

	//TODO 后端post数据校验。。
	public function addstep2($reviseStatus=false){
		$this->login();
		$uid = is_login();
		$pid=$_GET['pid'];
		if(empty($pid)){
			$this->error('关键参数未获得');
		}

		$modelProductPrice = M('ProductPrice');

		if (IS_POST) {
			$uid = is_login();
			$data = $_POST;

			$isProduct = M('product')->where(array('id'=>$pid))->find();
			if (empty($isProduct)) {
				$this->error('此众筹项目不存在');
			}
			
			//是否生成幸运号
			if($data['is_luck']==1){
				$data['is_luck']=1;
			}else{
				$data['is_luck']=0;
			}
			//是否需要验证码
			
			$data['pid'] = $pid;
			$data['create_id'] = $data['update_id'] = $uid;;
			$data['update_time'] = $data['create_time']= time();

			if ($data['order_number'] > 0) {
				$result = $modelProductPrice->where(array('id'=>$data['order_number']))->save($data); 
			}else{
				$result = $modelProductPrice->add($data); 
			}
			if($result===false){
				$this->error('处理失败，请联系管理员:service@dreammove.cn');
			}

			$this->success('处理成功！');
		}else{

			$resultPrice = $modelProductPrice->where(array('pid'=>$pid))->select();
			$this->assign('resultPrice',$resultPrice);
			$this->assign('navFlage','step2');
			$this->assign('pid',$pid);
			$this->display();
		}
	}
	
	/*修改配送地址*/
	public function modify_rule() {
		$uid = is_login();
		if (IS_GET) {
/* 			$id = $_GET['id'];
			if ($id) {
				$detail = M('CustomAddress')->where(array('id'=>$id, 'uid'=>$uid))->find();
	
				$this->assign('detail', $detail);
			} */
			$this->display('rulelist');
		}
	}

	//TODO 后端post数据校验。。
	public function addstep3($reviseStatus=false){
		$this->login();
		$uid = is_login();
		$pid=$_GET['pid'];
		$modelProductHolder = M('ProductHolder');

		if (IS_POST) {
			$data = $_POST;
			$isProduct = M('product')->where(array('id'=>$pid))->find();
			if (empty($isProduct)) {
				$this->error('此众筹项目不存在');
			}
			
			$data['pid'] = $pid;
			$data['uid'] = $uid;;
			$data['create_time']= time();
			if ($data['card_number'] != $data['confirm_card_number']) {
				$this->error('两次银行卡号输入不一致');
			}
			
			$info = $modelProductHolder->where(array('pid'=>$pid))->find();
			
			$id = $info['id'];
			if ($id>0) {
				$result = $modelProductHolder->where(array('id'=>$id))->save($data); 
			}else{
				$result = $modelProductHolder->add($data); 
			}
			if($result===false){
				$this->error('处理失败，请联系管理员:service@dreammove.cn');
			}

			//$this->redirect(U('addstep4', array('pid'=>$pid)));
			
			$this->success('处理成功！',U('addstep4', array('pid'=>$pid)));
		}else{
				
			$holderRecord = $modelProductHolder->where(array('pid'=>$pid))->find($data);
			//开户银行信息
			$bankinfo = M('BankInfo')->where(array('is_drawcash'=>1))->select();
			$this->assign($holderRecord);
			$this->assign('navFlage','step3');
			$this->assign('pid',$pid);
			$this->assign('bankinfo',$bankinfo);
			$this->display();
		}
	}

	public function addstep4(){

		$this->login();
		$pid=$_GET['pid'];

		if (IS_POST) {
				
		}else{
			$this->product = M('Product')->find($pid);
			$this->pid = $pid;
			$this->display();
		}
	}

	public function deleteProductPrice($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		$modelProductPrice = M('ProductPrice');
		$result = $modelProductPrice->where('id='.$id)->delete();
		if ($result !=false) {
			$this->success('处理成功');
		}else{
			$this->error('处理失败');
		}
	}

	public function viewDetail($pid){
		$modelProduct = M('Product');
		$modelProductInfo = M('ProductInfo');
		$modelProductPrice = M('product_price');
		$modelCustom= M('custom');

		//
		$isshow = I('isshow');
		
		//分享的订单ID
		$customid = I('customid');

		$where = array('id'=>$pid);
		$resultProduct = $modelProduct->where($where)->find();
		
		
		if (empty($resultProduct)) {
			$this->error('此众筹项目不存在');
		} else if (!$isshow && ($resultProduct['uid'] != is_login() && $resultProduct['status'] != 9)) {
			$this->error('此众筹项目不存在');
		}else if (!$isshow && ($resultProduct['uid'] != is_login() && $resultProduct['stage'] < 1)) {
			$this->error('此众筹项目不存在');
		}
		$resultInfo = $modelProductInfo->where(array('pid'=>$pid))->find();
		$resultPrice = $modelProductPrice->where(array('pid'=>$pid))->order('id')->select();
		
		$resultSupport = $modelProductPrice->where(array('pid'=>$pid))->sum('sell_count');

		//获取支持人列表
		$supportlist = M('Custom')->where(array('pid'=>$pid,'status'=>1))->order('create_time desc')->limit(3)->select();
		
		$data['read_record'] = $resultProduct['read_record'] +1;
		$resultLA = $modelProduct->where(array('id'=>$pid))->save($data);

		$this->pageTitle = $resultProduct['name'];
		//热门
		$projects = M('Project')->where(array('status'=>9,'stage'=>array(array('gt', 0),array('lt', 8),'and')))->
			order('stage desc, is_top desc, create_time desc')->limit(3)->select();

		//进度条
		$finishProgressNum = round($resultProduct['finish_amount']/$resultProduct['amount'],2)*100;

		// $finishProgressNum = 120;
		if ($finishProgressNum > 100) {
			$finishProgressBar = 100;
		}else{
			$finishProgressBar = $finishProgressNum;
		}
		$resultProduct['finish_progress_num'] = $finishProgressNum;
		$resultProduct['finish_progress_bar'] = $finishProgressBar;

		if (isMobile()) {
			$cmt = M('ProductComments')->order('create_time desc')->where(array('project_id'=>$pid))->select();
			$resultProduct['comments'] = get_format_comment($cmt, 5); //$model->getComments($id,5);
			$recomendList = recommendMBDetailFundings();
		}else{
			//获取评论信息
			$commentCount =M('ProductComments')->where(array('project_id'=>$pid))->count();
			$commentpage = new \Think\Page($commentCount,10);
			$commentshow = $commentpage->show();
				
			$resultProduct['comment'] = D('Product')->getDetailComments($pid,$commentpage->firstRow,$commentpage->listRows);
			$resultProduct['product']['com_count'] = $commentCount;
				
			$recomendList = recommendFoundings();
		}
		

		$this->assign($resultProduct);
		$this->assign('commentshow',$commentshow);
		$this->assign('projects',$projects);// 赋值数据集
		$this->assign('resultSupport',$resultSupport);
		$this->assign('resultPrice',$resultPrice);
		$this->assign('resultInfo',$resultInfo);
		$this->assign('supportlist',$supportlist);
		$this->assign('customid',$customid);
		$this->assign('pid',$pid);

		//返回跳转
		$this->assign("backurl",U('Index/index'));
		
		$this->assign('recomendList',$recomendList);
		$this->display('viewdetail');
		

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
				$id = M('ProductComment')->add($comment);
	
				$proj=M('Product')->where('id ='.$project_id)->field('name, uid')->find();
	
				$ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
						get_membername($user_id).'</a>';
				$plink = '<a href="'.U('Product/viewdetail?pid='.$project_id).'">《'.
						$proj['name'].'》</a>';
				if ($user_id != $proj['uid']) {
					$content = $ulink . '评论了您的'. $plink . '项目';
					D('Message')->send(0,$proj['uid'],'', $content, 3);
				}
	
				if ($reply_id) {
					$rep = M('ProductComment')->where('id='.$reply_id)->getField('comment_user');
					if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
						$content = $ulink . '回复了您对'. $plink . '项目的评论';
						D('Message')->send(0,$rep,'', $content, 3);
					}
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
			$id = M('ProductComment')->add($comment);
	
			$proj=M('Product')->where('id ='.$project_id)->field('name, uid')->find();
	
			$ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
					get_membername($user_id).'</a>';
			$plink = '<a href="'.U('Product/viewdetail?pid='.$project_id).'">《'.
					$proj['name'].'》</a>';
			if ($user_id != $proj['uid']) {
				$content = $ulink . '评论了您的'. $plink . '项目';
				D('Message')->send(0,$proj['uid'],'', $content, 3);
			}
	
			if ($reply_id) {
				$rep = M('ProductComment')->where('id='.$reply_id)->getField('comment_user');
				if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
					$content = $ulink . '回复了您对'. $plink . '项目的评论';
					D('Message')->send(0,$rep,'', $content, 3);
				}
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
	
	// 关注
	public function focus($pid){
		$uid = is_login();
		$this->login();
		$requestData = $_POST;

		if ($requestData['focus']) {
			$modelProduct = M('product');
			$modelAttach = M('ProductAttach');

			$likeAmount = $modelProduct->where(array('id'=>$pid))->field('like_record')->find();
			$data['like_record'] = $likeAmount['like_record'] +1;

			//往Attach  存数据
			$isAttach = $modelAttach->where(array('product_id'=>$pid,'investor_id'=>$uid))->find();

			$dataAttach['product_id'] = $pid;
			$dataAttach['investor_id'] = $dataAttach['create_id']  = $dataAttach['update_id']  = $uid;
			$dataAttach['attach_time'] = $dataAttach['create_time'] = $dataAttach['update_time'] = time();
			$dataAttach['product_id'] = $pid;

			if (empty($isAttach)) {
				$resultAttach = $modelAttach->add($dataAttach);
			}else{
				$this->error('您已关注本项目');
			}

			$resultLA = $modelProduct->where(array('id'=>$pid))->save($data);
			if ($resultLA ==false) {
				$this->error('处理失败，请联系管理员:service@dreammove.cn');
			}else{
				$this->success($data['like_record']);
			}
		}
	}

	public function getPriceUsedRevise($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		$modelProductPrice = M('ProductPrice');
		$resultRecord = $modelProductPrice->where(array('id'=>$id))->find();
	
		if (empty($resultRecord)) {
			$this->error('获取信息失败');
		}else{
			$resultRecord['image_url'] = get_cover($resultRecord['image'],'path');
			if (empty($resultRecord['image_url'])) {
				$resultRecord['image_url'] = null;
			}
			$this->success($resultRecord);
		}
	}

	// 提交审核
	public function review() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}
			if (!isset($status) || ($status != 1)) {
				$this->error('未指定审核结果');
			}
			$product = M('Product')->find($id);
			if (!$product) {$this->error('指定项目不存在。');}
			$resultProduct = M('Product')->save(array('status'=>$status, 'id'=> $id));
			if ($resultProduct) {
				$this->success('项目(' . $product['name'] . ')已经申请。', U('MCenter/pr_create'));
			}else{
				$this->error('项目提交失败');
			}
		}
	}

	//显示图片 用于mobile web
	public function detailImg($pid){

		$modelProduct = M('product');
		$modelProductInfo = M('ProductInfo');
		$resultProduct = $modelProduct->where(array('id'=>$pid))->find();
		$resultInfo = $modelProductInfo->where(array('pid'=>$pid))->find();
		
		$this->pageTitle = $resultProduct['name'];
		//返回跳转
		$this->assign("backurl",U('Product/viewdetail?pid='.$pid));
		
		$this->assign($resultProduct);
		$this->assign('resultInfo',$resultInfo);
		$this->assign('pid',$pid);
		$this->display('detailImg');
	}

	//点下一步 前查看是否有回报
	public function isPrice($pid){
		if (empty($pid)) {
			throw new Exception("关键参数未获得");
		}
		$modelProductPrice = M('ProductPrice');
		$resultRecord = $modelProductPrice->where(array('pid'=>$pid))->select();

		if (empty($resultRecord)) {
			$this->error('noneeeee');
		}else{
			$this->success('successss');
		}
	}
	
	//查看更多投资人
	public function invester_list($pid){
		$modelProduct = M('product');
		
		$where = array('id'=>$pid);
		$resultProduct = $modelProduct->where($where)->find();
		
		if (empty($resultProduct)) {
			$this->error('此众筹项目不存在');
		} else if (!$isshow && ($resultProduct['uid'] != is_login() && $resultProduct['status'] != 9)) {
			$this->error('此众筹项目不存在');
		}else if (!$isshow && ($resultProduct['uid'] != is_login() && $resultProduct['stage'] < 1)) {
			$this->error('此众筹项目不存在');
		}
	
		//获取支持人列表
		$supportlist = M('Custom')->where(array('pid'=>$pid,'status'=>1))->order('create_time desc')->select();
		
		$this->pageTitle = '支持人列表';
		$this->assign('supportlist',$supportlist);
		$this->assign('pid',$pid);
		
		$this->display();
		
	}
	
	function makereply(){
		$this->assign('reply_id',I('reply_id'));
		$this->assign('project_id',I('project_id'));
		$this->display();
	}
	
	//手机端查看更多评论
	function morecomment(){
		//$comments = M('CommentReply')->order('create_time desc')->where(array('project_id'=>I('pid')))->select();
		$cmt = M('ProductComment')->order('create_time desc')->where(array('project_id'=>I('pid')))->select();
		$comments = get_format_comment($cmt, count($cmt)); //$model->getComments($id,5);
		$this->assign('pageTitle','更多回复');
		$this->assign('comments',$comments);
		$this->display();
	}
	
	//手机上的评论
	function postcomment() {
		$this->display('postcomment');
	}
	
	
}