<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	private $modelPOS;
	private $realTr;
	private $realEm;
	public function __construct(){
		parent::__construct();
		$this->modelPOS = array();

	}
	public function first(){
		ini_set('max_execution_time',0);
		$get = $this->Tools->praProcess(file_get_contents(FCPATH.'datasets/idn-tagged-corpus-master/Indonesian_Manually_Tagged_Corpus.tsv'));
		// var_dump($get);
		foreach($get as $insert){
			$this->ModelVocab->insert($insert);
		}
	}
	public function first2(){
		ini_set('max_execution_time',0);
		$get = $this->Tools->praProcess(file_get_contents(FCPATH.'datasets/idn-tagged-corpus-master/Indonesian_Manually_Tagged_Corpus.tsv'));
		// $i=1;
		// var_dump(count($get));	
		foreach($get as $insert){
			// $get[$key]['id'] = $i;
			// var_dump($get);
			$this->ModelVocab->insert($insert);
			// $i++;
		}		
	}

	public function second(){
		$data = $this->ModelVocab->selectAll()->result_array();
		$this->modelPOS = $this->Tools->posCount($data,$this->modelPOS);
		// $tP = $this->Tools->transitionProb($data,$this->modelPOS);
		// $eP = $this->Tools->emissionProb($data,$this->modelPOS);
		// $this->Tools->pre_print_r($eP);
	}
	public function debug(){
		ini_set('memory_limit',"256M");
		$this->second();
		// echo count($this->Tools->emissionProb($this->ModelVocab->selectAll()->result_array(),$this->modelPOS)); 
		$this->Tools->pre_print_r($this->modelPOS);
	}
	public function loadModel(){
		ini_set('memory_limit',"256M");
		$this->second();
		$data['numOfToken'] = $this->ModelVocab->selectAll()->num_rows();
		$data['numOfTag'] = count($this->modelPOS)-1;
		$data['tagset'] = $this->ModelTagset->selectAll()->result_array();
		$this->realTr = $this->Tools->transitionProb($this->ModelVocab->selectAll()->result_array(),$this->modelPOS);
		$data['topTransition'] = $this->realTr;
		usort($data['topTransition'], function ($a, $b) {
			return $a['count'] < $b['count'];
		});
		$this->realEm = $this->Tools->emissionProb($this->ModelVocab->selectAll()->result_array(),$this->modelPOS);
		$data['topEmission'] = $this->realEm;
		usort($data['topEmission'], function ($a, $b) {
			return $a['count'] < $b['count'];
		});
		return $data;
	}	
	public function index(){

		$data = $this->loadModel();
		$this->load->view('layout/header',$data);
		$this->load->view('home',$data);
		$this->load->view('layout/footer',$data);
	}

	public function ac(){
		$data = $this->loadModel();
		$post = $this->input->post();
		$data['ac'] = $this->Tools->ambiguChecker($post['word'],$data['topEmission']);
		// $this->Tools->pre_print_r($data['res']);
		$this->load->view('layout/header',$data);
		$this->load->view('ac',$data);
		$this->load->view('layout/footer',$data);
	}

	public function pt(){
		$data = $this->loadModel();
		$post = $this->input->post();
		$data['tagz'] = $this->Tools->viterbi($post['sentence'],$this->realTr,$this->realEm);
		$data['sentence'] = explode(" ",$post['sentence']);

		$this->load->view('layout/header',$data);
		$this->load->view('pt',$data);
		$this->load->view('layout/footer',$data);
	}

	public function parser(){
		$data = $this->loadModel();

		$post = $this->input->post();
		$data['tagz'] = $this->Tools->viterbi($post['sentence'],$this->realTr,$this->realEm);
		$grammar = $this->Tools->preGrammar('ruleobo.txt');
		echo "<b> Kalimat\t :\t".$post['sentence']."</b><br/>";
		echo "<b> POS Tag\t :\t".implode(" ",$data['tagz'])."</b><br/>";
		// $data['tagz']);
		// $this->load->view('layout/header',$data);
		$wtf = -1;
		$this->Tools->cky2($data['tagz'],$grammar,$wtf);	
		// $this->load->view('layout/footer',$data);

	}
	
}
