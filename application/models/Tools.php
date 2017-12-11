<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Model {

	public function index(){
		parent::__construct();
	}
	public function pre_print_r($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	public function praProcess($data){
		$data = preg_split('/[\n,]+/',$data);
		foreach($data as $i){
			$temp = explode("\t",$i);
			// var_dump($temp);
			if(isset($temp[1])){
				$pos['word'] = strtolower($temp[0]);
				$pos['pos'] = $temp[1];
				$fix[] = $pos;
			}
			
		}
		// $this->pre_print_r($fix);
		return $fix;
	}

	public function transitionProb($sentences,$poscount){
		$indexes = array();
		for($i=0;$i<count($sentences)-1;$i++){
			$key=$sentences[$i+1]['pos']."|".$sentences[$i]['pos'];
			if(array_key_exists($key,$indexes)){
				$indexes[$key]["count"] ++;
			}else{
				$indexes[$key] = array(
					'count' => 1,
					'key' => $key,
					'prob'=> 0,
					);
			}
		}
		foreach($indexes as $key => $row){
			$indexes[$key]['prob'] = $row['count']/$poscount[explode("|",$row['key'])[1]]['count'];
		}
		return $indexes;
	}

	public function emissionProb($sentences,$poscount){
		$indexes = array();
		for($i=0;$i<count($sentences);$i++){
			$key=$sentences[$i]['word']."|".$sentences[$i]['pos'];
			if(array_key_exists($key,$indexes)){
				$indexes[$key]["count"] ++;
			}else{
				$indexes[$key] = array(
					'count' => 1,
					'key' => $key,
					'prob' => 0,
					);
			}
		}
		foreach($indexes as $key => $row){
			$indexes[$key]['prob'] = $row['count']/$poscount[explode("|",$row['key'])[1]]['count'];
		}
		return $indexes;
	}

	public function posCount($data,$indexes){
		for($i=0;$i<count($data);$i++){
			$key = $data[$i]['pos'];
			if(array_key_exists($data[$i]['pos'],$indexes)){
				$indexes[$key]["count"]++;
			}else{
				$indexes[$key] = array(
				  'count' => 1,
				  'words' => $key,
				);
			}
		}
		// $this->pre_print_r($indexes);
		return $indexes;
	}

	public function viterbi($string,$tr,$em){
		$POS = array();
		$indexes = array();
		$string = explode(" ",$string);
		/*Looping string*/
		for($i=0;$i<count($string);$i++){
			if($i==0){
				$b4[] = "q0";
				$vb4[] = 1;
			}else{
				$b4 = $temp;
				$vb4 = $tempvb4;
				unset($temp);
				unset($tempvb4);
			}
			/*Looping macam2 tag pada setiap string*/
			foreach($em as $key => $j){
				/*Cari string ada tag apa aja*/
				if(strtolower($string[$i]) == strtolower(explode("|",$em[$key]['key'])[0])){
					/*Looping sebanyak nilai sebelumnya*/
					unset($res);
					for($k=0;$k<count($b4);$k++){
						// echo "B-".$vb4[$k]; 
						// echo $string[$i]." | ".$em[$key]['key']." | ".$b4[$k]." | ".$tr[explode("|",$key)[1]."|".$b4[$k]]['key'];
						if(!isset($tr[explode("|",$key)[1]."|".$b4[$k]])){
							$res[] = $em[$key]['prob'] * 0 * $vb4[$k];
						}else{
							$res[] = $em[$key]['prob'] * $tr[explode("|",$key)[1]."|".$b4[$k]]['prob'] * $vb4[$k];
						}
						// var_dump($tr[explode("|",$em[$key]['key'])[1]."|".$b4[$k]]);
					}
					$temp[] = explode("|",$em[$key]['key'])[1];
					$tempvb4[] = max($res);
					// echo "<br/>";
				}
			}
			// var_dump($temp);
			if(!isset($tempvb4) && !isset($temp)){
				$POS[] = "X";
				$temp[] = "q0";
				$tempvb4[] = 1;
			}else{
				$POS[] = $temp[array_keys($tempvb4, max($tempvb4))[0]];
			}
		}
		return $POS;
	}

	public function ambiguChecker($word, $data){
		foreach($data as $row){
			if(strtolower($word) == strtolower(explode("|",$row['key'])[0])){
				$res[] = $row;
			}		
		}
		return $res;
	}
	public function partOf($combination,$grammar){
		
		foreach($combination as $i){
			foreach($grammar as $j)
			if($i == $j[1]){
				$ret[] = $j[0];
			}
		}
		// if(isset($ret)){}
		return implode(",",$ret);
		// var_dump($res);
	}
	public function CYKParse($posSentence,$grammar){
		$length = count($posSentence);
		$this->pre_print_r($posSentence);
		$matriks = array();
		for ($i=0; $i < $length; $i++) {
			var_dump("AWAL");
			$matriks[0][$i] = $this->partOf([$posSentence[$i]],$grammar);
		}
		for($i=1; $i <= $length; $i++){
			for($j=0;$j<$length-$i;$j++){
				$p1 = $i-1;
				$p2 = $j+1;
				unset($c);
				for($k=0;$k<$i;$k++){
					$cell1 = explode(",",$matriks[$j][$k]);
					$cell2 = explode(",",$matriks[$p1][$p2]);
					for($l=0;$l<count($cell1);$l++){
						for($m=0;$m<count($cell2);$m++){
							$c[] = implode(" ",[$cell1[$l],$cell2[$m]]);
						}
					}
					$p1--;
					$p2++;
				}
				var_dump($c);
				$matriks[$i][$j] = $this->partOf($c,$grammar);
			}
		}

		/*Print*/
			print("</br>");
		for ($i=0; $i < $length; $i++) { 
			for ($j=0; $j < $length; $j++) {
				if(!isset($matriks[$i][$j])){
					print("-");
				}else{
					print($matriks[$i][$j]);
				}
			}
			print("</br>");
		}
	}

	public function cky2($posSentence,$grammar,$count){
		// var_dump(count($posSentence));
		$count++;
		for($i=0;$i<count($posSentence);$i++){
			foreach($grammar as $j){
				$x = explode(" ",$j[1]);
				if($posSentence[$i] == $x[0] && ($i+count($x)-1) < count($posSentence)){
					$stats = 0;
					$counter = $i;
					for($k=0;$k<count($x); $k++) { 
						if($counter < count($posSentence)){
							if($posSentence[$counter] != $x[$k]){
								$stats = 1;
							}
						}
						$counter++;
					}
					if($stats == 1){
					}else{
						// echo "<br/>";
						// echo "replace => <b style='color:red'>".$posSentence[$i]."</b> to => <b style='color:#5cb85c;'>".$j[0]."</b>&nbsp;&nbsp;&nbsp;grammar =>".$j[1]."<br/>";
						// $good[] = Array('asli' => $posSentence[$i],'left' => $j[0], 'right' => $j[1]);
						unset($newpos);
						$topstats = 0;
						for($iterasi = 0; $iterasi < count($posSentence);$iterasi++){
							$ex = explode(" ",$j[1]);
							if($topstats == 0){
								if($posSentence[$iterasi] == $ex[0]){
									$c2 = $iterasi;
									$yes = 0;
									for($p=0; $p < count($ex); $p++) { 
										if($c2 < count($posSentence)){
											if($posSentence[$c2] == $ex[$p]){
												$yes++;
											}
											$c2++;
										}
									}
									if($yes == count($ex)){
										$newpos[] = $j[0];
										$iterasi += count($ex)-1;
										$topstats = 1;
									}
								}else{
									$newpos[] = $posSentence[$iterasi];
								}
							}else{
								$newpos[] = $posSentence[$iterasi];
							}
						}

						// str_repeat('&nbsp;', $count*10);
						if(implode(" ",$newpos) == "S"){
							echo "<b style='color:blue'>".$count.str_repeat('-', $count*6)."-".implode(" ",['S','(CORRECT)']).str_repeat('&nbsp;', 5)."</b><b style='color:red'>".$j[1]."</b> => <b style='color:#5cb85c;'>".$j[0]."</b><br/>";
							$this->cky2($newpos,$grammar,$count);
						}else{
							echo $count.str_repeat('-', $count*6)."-".implode(" ",$newpos).str_repeat('&nbsp;', 5)."<b style='color:red'>".$j[1]."</b> => <b style='color:#5cb85c;'>".$j[0]."</b><br/>";
							$this->cky2($newpos,$grammar,$count);
						}

					}
				}
			}
		}

	}
	/**
	 * [preGrammar description]
	 * @param  string $filename filename where the rule given in .txt
	 * @return string           Array of grammar, index 0 = LHS, index 1 = RHS
	 */
	public function preGrammar($filename){
		$text = file_get_contents(FCPATH.$filename);
		$text = explode("+",$text);
		for ($i=0; $i < count($text); $i++) { 
			$text[$i] = explode(">",$text[$i]);
		}
		return $text;
	}
}