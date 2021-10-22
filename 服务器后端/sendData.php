<?php 

date_default_timezone_set("PRC");

$openId = $_GET['openId'];
$nickName = $_GET['nickName'];
$stepList = $_GET['stepList'];
$stepList = $stepList;

$stepList=json_decode($stepList);


//根据 openid 判断姓名

$realName = "";
if ($openId == "aaaaaaaaaaaaaaaaaaaaaaaaaa")
    $realName = "测试";


//先判断文件是否存在
//创建CSV

for ($x=0; $x<=29; $x++) {
	$today = date('Y-m-d', $stepList[$x]->timestamp);
	$pathFile = 'files/'.$today.'.csv';
	$csvInfo = [
['openid' => $openId, 'step' => $stepList[$x]->step,'nickname' => $nickName,'realname' => $realName]
];
	
	
	if(file_exists($pathFile)) //文件存在
	{
		
		$handle = fopen( $pathFile, 'r' );

		$str= file_get_contents($pathFile);
		if(strstr($str, $openId) == FALSE){ //不重复	

			fclose($handle);		
			$handle = fopen( $pathFile, 'a+' );
			/*
			$header = array(
			iconv( 'UTF-8', 'GBK//IGNORE', 'openid' ), //将utf-8转成GBK，ignore的意思是忽略转换时的错误
			iconv( 'UTF-8', 'GBK//IGNORE', '昵称' ),
			iconv( 'UTF-8', 'GBK//IGNORE', '步数' ),
			iconv( 'UTF-8', 'GBK//IGNORE', '真名' ),
			);
			*/
			
			//fputcsv( $handle, $header ); //如果文件存在，就不写表头
			foreach( $csvInfo as $value ) {
			$fields = [
				$value['openid'],
				iconv( 'UTF-8', 'GBK//IGNORE', $value['nickname'] ),
				iconv( 'UTF-8', 'GBK//IGNORE', $value['step'] ),
				iconv( 'UTF-8', 'GBK//IGNORE', $value['realname'] ),
				
				];
			print_r($fields);

				fputcsv( $handle, $fields );
			
			}
			fclose($handle);
		}
						
	}
					
	else{ //文件不存在
			$handle = fopen( $pathFile, 'a+' );
			$header = array(
			iconv( 'UTF-8', 'GBK//IGNORE', 'openid' ), //将utf-8转成GBK，ignore的意思是忽略转换时的错误
			iconv( 'UTF-8', 'GBK//IGNORE', '昵称' ),
			iconv( 'UTF-8', 'GBK//IGNORE', '步数' ),
			iconv( 'UTF-8', 'GBK//IGNORE', '真名' ),
			);
			
			fputcsv( $handle, $header ); //写入csv
			foreach( $csvInfo as $value ) {
				$fields = [
				$value['openid'],
				iconv( 'UTF-8', 'GBK//IGNORE', $value['nickname'] ),
				iconv( 'UTF-8', 'GBK//IGNORE', $value['step'] ),
				iconv( 'UTF-8', 'GBK//IGNORE', $value['realname'] ),
				];

				fputcsv( $handle, $fields );
				
			}
			fclose($handle);
		}
		
	}

?>