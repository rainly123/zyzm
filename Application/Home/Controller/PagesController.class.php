<?php 
namespace Home\Controller;

class PagesController extends HomeController {
	public function investor($pid) {
		$pid = $_GET['pid'];
		$onepage = 15;

		$model = M('ProjectInvestor');
		$map = array('project_id' => $pid, 'status'=>array('egt', 2));
		$pageCount = $model->where($map)->count();

		$page = new \Think\Page($pageCount, $onepage, array('pid'=>$pid));
		$lists = $model->where($map)->order('id desc')->limit($page->firstRow,$onepage)->select();
		$page = $page->show();
		$this->assign('lists',$lists);
		$this->assign('Pages',$page);

		$html = $this->fetch('investor');

		if ($pid == 2) {
			$pageCount = 3218;

		}

		$this->ajaxReturn(array('html'=>$html, 'count'=>$pageCount));
	}

	public function comments($id) {
		$id = I('id');
    $commentCount =M('ProjectComment')->where(array('project_id'=>$id))->count();
    $commentpage = new \Think\Page($commentCount,10,array('id'=>$id));
    $data = M('ProjectComment')->order('create_time desc')->where(array('project_id'=>$id))->
    	limit($commentpage->firstRow .','.$commentCount)->select();
		
		$lists = get_format_comment($data, 10);
		
		$commentpage = $commentpage->show();
    $this->assign('lists',$lists);
    $this->assign('Pages',$commentpage);

    $html = $this->fetch('comments');
    $this->ajaxReturn(array('html'=>$html,'count'=>$commentCount));
	}

    public function comment($id){
        $model = D('Project');
        $id = I('id');
        $commentCount =M('CommentReply')->where(array('project_id'=>$id))->count();
        $commentpage = new \Think\Page($commentCount,10,array('id'=>$id));


        $lists = $model->getDetailComments($id,$commentpage->firstRow,$commentpage->listRows);
        $commentpage = $commentpage->show();
        $this->assign('lists',$lists);
        $this->assign('Pages',$commentpage);

        $html = $this->fetch('comment');
        $this->ajaxReturn(array('html'=>$html,'count'=>$commentCount));
    }
	public function productInvestor($pid) {
		$pid = $_GET['pid'];
		$onepage = 10;

		$modelProductPrice = M('product_price');
		$modelCustom = M('Custom');

		$resultPrice = $modelProductPrice->where(array('pid'=>$pid))->select();
		if (!empty($resultPrice)) {
			$serializePrice = null;
			foreach ($resultPrice as $key => $value) {
				$serializePrice = $serializePrice . $value['id'].',';
			}
			
			$serializePrice = substr($serializePrice, 0, -1) ;
			$customMap['price_id'] = array('in',$serializePrice);
			$customMap['status'] = array('eq',1);

			$pageCount = $modelCustom->where($customMap)->count();

			$page = new \Think\Page($pageCount, $onepage);
			$lists = $modelCustom->where($customMap)->order('update_time desc, id')->limit($page->firstRow,$onepage)->select();

			$page = $page->show();
			$this->assign('lists',$lists);
			$this->assign('Pages',$page);

			$html = $this->fetch('productInvestor');

			$this->ajaxReturn(array('html'=>$html, 'count'=>$pageCount));

		}else{
			$this->ajaxReturn(array('html'=>'没有投资人', 'count'=>null));
		}
	}
	
	//实物评论
	public function productComments($id) {
		$id = I('id');
		$commentCount =M('ProductComment')->where(array('project_id'=>$id))->count();
		$commentpage = new \Think\Page($commentCount,10,array('id'=>$id));
		$data = M('ProductComment')->order('create_time desc')->where(array('project_id'=>$id))->
		limit($commentpage->firstRow .','.$commentCount)->select();
	
		$lists = get_format_comment($data, 10);
	
		$commentpage = $commentpage->show();
		$this->assign('lists',$lists);
		$this->assign('Pages',$commentpage);
	
		$html = $this->fetch('comments');
		$this->ajaxReturn(array('html'=>$html,'count'=>$commentCount));
	}
	
	public function productComment($id){
		$model = D('Project');
		$id = I('id');
		$commentCount =M('ProductComments')->where(array('project_id'=>$id))->count();
		$commentpage = new \Think\Page($commentCount,10,array('id'=>$id));
	
	
		$lists = $model->getDetailComments($id,$commentpage->firstRow,$commentpage->listRows);
		$commentpage = $commentpage->show();
		$this->assign('lists',$lists);
		$this->assign('Pages',$commentpage);
	
		$html = $this->fetch('comment');
		$this->ajaxReturn(array('html'=>$html,'count'=>$commentCount));
	}
	

	//文章评论
	public function infoComments($id) {
		$id = I('id');
		$commentCount =M('InfoComment')->where(array('project_id'=>$id,'status'=>0))->count();
		$commentpage = new \Think\Page($commentCount,10,array('id'=>$id));
		$data = M('InfoComment')->order('create_time desc')->where(array('project_id'=>$id,'status'=>0))->
		limit($commentpage->firstRow .','.$commentCount)->select();
	
		$lists = get_format_comment($data, 10);
	
		$commentpage = $commentpage->show();
		$this->assign('lists',$lists);
		$this->assign('Pages',$commentpage);
	
		$html = $this->fetch('comments');
		$this->ajaxReturn(array('html'=>$html,'count'=>$commentCount));
	}
}
?>