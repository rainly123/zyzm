<?php 
namespace Home\Model;
use Think\Model;

class ProjectFundModel extends Model {
	protected $_validate = array(
			array('project_valuation', 'number', '项目估值必须是数值', self::VALUE_VALIDATE),
			array('need_fund', 'require', '请填写预融资金额', self::MUST_VALIDATE),
			array('need_fund', 'number', '预融资金额必须是数值', self::MUST_VALIDATE),
			array('follow_fund', 'require', '请填写最低跟投金额', self::MUST_VALIDATE),
			array('follow_fund', 'number', '最低跟投金额必须是数值', self::MUST_VALIDATE),
			array('to_way', 'require', '请选择到账方式', self::MUST_VALIDATE),
		);

	public function checkFund($fund, $type = 0) {
		if ($type == 0 && $fund['project_valuation'] <= 0) {
			$this->error = "项目估值必须大于 0 ";
			return false;
		} else if ($fund['need_fund'] <= 0) {
			$this->error = "预融资金额必须大于 0 ";
			return false;
		}else if ($fund['follow_fund'] <= 0) {
			$this->error = "最低跟投金额必须大于 0 ";
			return false;
		}else if ($type == 0 && ($fund['project_valuation'] / 2 < $fund['need_fund'])) {
			$this->error = "项目估值必须大于等于目标融资金额的 2 倍";
			return false;
		}else if($fund['need_fund'] < $fund['follow_fund']) {
			$this->error = "最低跟投金额必须小于预融资金额";
			return false;
		}

		return true;
	}
	public function addHasFund($id, $fund) {
		return $this->where(array('project_id' => $id))->setInc('has_fund', $fund);
	}
}
?>