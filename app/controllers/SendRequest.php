<?php

use HTTPHelper\HTTPStatus;

class SendRequest extends Controller {
	
	public function send() {
	
		$input = Input::all();
		
		$validator = Validator::make($input,
			array('url' => 'required|url', 'method' => 'required')
		);
		
		$data = array();
		for ($i = 0; $i < count($input['param']); $i++) {
			$name = trim($input['param'][$i]);
			$value = trim($input['value'][$i]);
			if ($name !== '') {
				
				$data[$name] = $value;
				
				// Can't use Input::flash() with input arrays (param[], value[]) because of 
				// this issue https://github.com/laravel/framework/issues/2243
				Session::flash('param_'. $i, $name);
				Session::flash('value_'. $i, $value);
			}
		}
		Input::flashOnly('url', 'method');
		
		if ($validator->fails()) {
			$messages = $validator->messages();
			Session::flash('errors', $messages);
			return Redirect::to('/');
		}
		
		$this->curl = new Curl;
		$response = $this->curl->_simple_call(strtolower($input['method']), $input['url'], $data);
		if ( ! $response ) {
			$http = new HTTPHelper\HTTPStatus;
			$response = $http->getStatus($this->curl->info['http_code']);
		}
		Session::flash('response', json_encode($response));
		return Redirect::to('/');
	}
}