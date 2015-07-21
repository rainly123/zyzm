<?php 
namespace Home\Model;
use Think\Model;
Class AccountLogModel extends Model{
	public function record($head, $xml, $mac = '', $type = 1) {
		$head['bussflowno'] = $head['tranFlow'];
		$head['trancode'] = $head['tranCode'];
		$head['respcode'] = $head['respCode'];
		$head['respmsg'] = $head['respMsg'];
		$head['trandate'] = substr($head['clientDate'], 0,8);
		$head['trantime'] = substr($head['clientDate'], 8);
		$head['content'] = $xml;
		$head['type'] = $type;
		$head['mac'] = $mac;
		$head['create_time'] = NOW_TIME;
		$this->add($head);
	}

	public function checkresult($head, $xml) {
		$where = array('bussflowno'=> $head['bussflowno']);
		$head['back_content'] = $xml;
		$this->where($where)->save($head);
	}
}
?>