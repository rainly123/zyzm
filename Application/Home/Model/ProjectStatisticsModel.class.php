<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/13/15
 * Time: 5:22 PM
 */

namespace Home\Model;
use Think\Model;

Class ProjectStatisticsModel extends Model
{

    public function addPositive($pid)
    {
        $prostatis = M('project_statistics');
        $incLike = $prostatis->where('pid='.$pid)->setInc('ulike',1);
        if($incLike==null){
            $data['pid']=$pid;
            $data['ulike']=1;
            $incLike = $prostatis->add($data);
        }
        return $incLike;
    }

    public function addNegative($pid)
    {
        $prostatis = M('project_statistics');
        $incDisLike = $prostatis->where('pid='.$pid)->setInc('udislike',1);
        if($incDisLike==null){
            $data['pid']=$pid;
            $data['udislike']=1;
            $incDisLike = $prostatis->add($data);
        }
        return $incDisLike;
    }
}
?>