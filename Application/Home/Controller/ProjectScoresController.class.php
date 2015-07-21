<?php
namespace Home\Controller;
class ProjectScoresController extends HomeController {
    public function index(){

    	$id =$_GET['id'];
        if (!is_login()) {
            $this->assign('status', 0);
            $this->assign('info', '您还没有登录，登录后可对项目进行评分。');
        };
        //返回跳转
        $this->assign("backurl",U('Project/detail?id='.$id));
        $project = D('Project')->getProjectInfo($id);
        $this->assign('projectID',$id);
        $this->assign('project',$project);
        $this->assign('scores', $this->getScores($id));
        $this->assign('user_score', $this->getUserScore($id));
        $this->display();
    }

    public function getOwnScores(){

        M('ProjectTemp')->add($temp);
    }

    public function saveScores(){
        $userID = is_login();

        if(!$this->isScored($_POST['project_id'])){
            $data = array(
                'user_id'=> $userID,
                'project_id'=> $_POST['project_id'],
                'create_time'=> time(),
                'group'=> $_POST['group'],
                'market'=> $_POST['market'],
                'creative'=> $_POST['creative'],
                'profitablity'=> $_POST['profitablity'],
                'evaluation'=> $_POST['evaluation'],
                'comments'=> $_POST['comments']
            );
            M('Projects_score')->add($data);
            if($_POST['comments']!= null){
                $comment = array(
                    'project_id' => $_POST['project_id'],
                    'comment_user' => $userID,
                    'content' => $_POST['comments'],

                    'create_time' => NOW_TIME,
                    'create_id' => $userID,
                    'update_time' => NOW_TIME,
                    'update_id' => $userID,);
                M('ProjectComment')->add($comment);
            }
            $this->success('打分成功');

        } else {
            $this->error('你已打分, 请勿重复提交.');
        }


    }
    public function getUserScore($id){
        return M('projects_score')->where(array('project_id' => $id,'user_id'=>is_login()))->find();
    }
    public function getScores($id){
        $scores = M('projects_score')->where(array('project_id' => $id))->select();
        $averageScore = array();

        foreach($scores as $score){
            $averageScore['group'] = $averageScore['group']+ $score['group'];
            $averageScore['market'] = $averageScore['market']+ $score['market'];
            $averageScore['creative'] = $averageScore['creative']+ $score['creative'];
            $averageScore['profitablity'] = $averageScore['profitablity']+ $score['profitablity'];
            $averageScore['evaluation'] = $averageScore['evaluation']+ $score['evaluation'];
        }
        $averageScore['group']= round($averageScore['group']/count($scores));
        $averageScore['market']= round($averageScore['market']/count($scores));
        $averageScore['creative']= round($averageScore['creative']/count($scores));
        $averageScore['profitablity']= round($averageScore['profitablity']/count($scores));
        $averageScore['evaluation']= round($averageScore['evaluation']/count($scores));

        return $averageScore;
    }

    //判断用户是否已经打过分
    public function isScored($pid){
        $userID = is_login();
        $count = M(Projects_score)->where(array('user_id' => $userID,'project_id' => $pid))->count();
        if($count>0){
            return true;
        }
        return false;

    }
}
?>