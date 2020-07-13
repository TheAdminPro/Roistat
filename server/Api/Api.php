<?php
class Api{
	// GET
	public function get($path, $callback){
		if($path == $_SERVER['PATH_INFO'] && $_SERVER['REQUEST_METHOD'] === "GET"){
			if(is_callable($callback)) {
				call_user_func($callback, $_GET, $this->GetContents($_POST));
			}
		}
	}
	// POST
	public function post($path, $callback){
		if($path == $_SERVER['PATH_INFO'] && $_SERVER['REQUEST_METHOD'] === "POST"){
			if(is_callable($callback)) {
				call_user_func($callback, $_GET, $this->GetContents($_POST));
			}
		}
  }
  
	protected function GetContents($payload){
		if ($payload == NULL) {
			$payload = json_decode(file_get_contents("php://input"), true);
		}
		return $payload;
	}
}