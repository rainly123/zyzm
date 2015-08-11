<?php
namespace Home\Controller;
use zhifubao\logic\PayApply;

class ListController extends HomeController {


    // 项目列表
    public function index() {

        // 审核已经通过的项目
        //$type: 全部: 0，股权众筹: 1,实物众筹: 2,股票基金: 3
        //$status:全部: 0，筹资中: 1,筹资成功: 2,预热中：3
        $type = I('type',0);
        $status = I('status', 0);
        $productIndex = 0;
        $projectsList = null;
        $productsList = null;
        if($type ==0 | $type ==1){
            if($status ==0){
                $projectsList = D('Project')->getAllProvedProjectsInfo();
            }elseif($status ==1){
                $projectsList = D('Project')->getAllFundingProjectsInfo();
            }elseif($status ==2){
                $projectsList = D('Project')->getAllSuccessedProjectsInfo();
            }else{
            	$projectsList = D('Project')->getAllWarmupProjectsInfo();
            }

        }
        $countProjects= count($projectsList);

        if($type ==0 | $type ==2){
            if($status ==0){
                $productsList = D('Product')->getAllProvedProducts();
            }elseif($status ==1){
                $productsList = D('Product')->getAllFundingProducts();
            }elseif($status ==2){
                $productsList = D('Product')->getAllSuccessedProducts();
            }

        }
        $countProducts= count($productsList);//
        // if($type ==0 | $type ==3){
        //     $stocksList = D('Stock')->getAllProvedStocksInfo();

        // }
        // $countStocks= count($stocksList);//
        $countStocks = 0;



        $totalCounter =  $countProjects +  $countProducts + $countStocks;
        $Page = new \Think\Page($totalCounter,12);
        $show= $Page->show();
        //$list = D('List')->getAllProvedProjectInfo(array('between',array('1','9')),'create_time desc',$Page->firstRow.','.$Page->listRows);
        $listOfProjects = null;
        $listOfProducts = null;
        $listOfStocks = null;
        if(($Page->firstRow+$Page->listRows) <= $countProjects){
            $listOfProjects = array_slice($projectsList, $Page->firstRow,$Page->listRows);
        }elseif($Page->firstRow <  $countProjects){
            $listOfProjects = array_slice($projectsList, $Page->firstRow,$Page->listRows);
            $listOfProducts = array_slice($productsList,0,($Page->listRows-$countProjects%$Page->listRows));
        }elseif(($Page->firstRow+$Page->listRows) <= ($countProjects+$countProducts)){
            $productsIndex = $Page->firstRow-$countProjects;
            $listOfProducts = array_slice($productsList, $productIndex,$Page->listRows);
        }elseif($Page->firstRow < ($countProjects+$countProducts)){
            $listOfProducts = array_slice($productsList, ($Page->firstRow-$countProjects),$Page->listRows);
            $listOfStocks = array_slice($stocksList,0,($Page->listRows-($countProjects+$countProducts)%$Page->listRows));
        }else{
            $stocksIndex = $Page->firstRow-$countProjects-$countProducts;
            $listOfStocks = array_slice($stocksList, $stocksIndex,$Page->listRows);
        }
        $this->assign('firstRow',$Page->firstRow);
        $this->assign('listRows',$Page->listRows);
        $this->assign('listOfProjects',$listOfProjects);
        $this->assign('listOfProducts',$listOfProducts);
        // $this->assign('listOfStocks',$listOfStocks);//$listOfStocks
        $this->assign('page',$show);
//        print_r($listOfProducts);
//        die();
        $this->type = $type;
        $this->status = $status;
        if(!is_login())
        {
            $this->redirect('User/login');
        }
        else
        {
            $this->display();
        }
    }

    function mobileproject(){
        $status = $_GET['status'];

        if($status ==0){
            $projectsList = D('Project')->getAllProvedProjectsInfo();
        }elseif($status ==1){
            $projectsList = D('Project')->getAllFundingProjectsInfo();
        }elseif($status ==2){
            $projectsList = D('Project')->getAllWarmupProjectsInfo();
        }else{
            $projectsList = D('Project')->getAllSuccessedProjectsInfo();
        }
      //  D('Project')->addProjectsFundInfo($projectsList);
        //返回跳转
        $this->assign("backurl",U('Index/index'));
        
        $this->assign('pageTitle',"股权众筹列表");
        $this->assign('projectsList',$projectsList);
        $this->display();
    }
    function mobileproduct(){
        $status = $_GET['status'];

        if($status ==0){
            $productsList = D('product')->getAllProvedProducts();
        }elseif($status ==1){
            $productsList = D('product')->getAllProvedProducts(array('between',array('1','9')),'amount desc',null);
        }else{
            $productsList = D('product')->getAllProvedProducts(array('between',array('1','9')),'like_record desc',null);
        }
        D('product')->addProductsFundInfo($productsList);
        //返回跳转
        $this->assign("backurl",U('Index/index'));
        $this->assign('pageTitle',"实物众筹列表");
        $this->assign('productsList',$productsList);
        $this->display();
    }
    public function getAllProvedProducts($stage=array('between',array('1','9')),$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        return $this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());
    }




}
?>