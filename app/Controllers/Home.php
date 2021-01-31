<?php namespace App\Controllers;
use App\Models\User;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}
	

	public function register(){
		if($this->request->getMethod()=="get"){
			return view('register');
		}elseif($this->request->getMethod()=="post"){
			$data = $this->request->getVar();
			$userObj = new User();
			
			$res = $userObj->save($data);
			if($res){
				echo "registered successfully";
				$this->sendNotification('New Registration','Account created with email'.$data['email']);
				//return redirect()->to('login');
			}else{
				echo "failed to register";
			}
		}
		
	}

	public function login(){

		if($this->request->getMethod()=="get"){
			return view('login');
		}
		elseif($this->request->getMethod()=="post"){
			$data = $this->request->getVar();
			
			$userObj = new User();
			$result = $userObj->Where(['email'=> $data['email'], 'password'=> $data['password']])->first();
			if($result){
				$userObj->update($result['id'],array('token'=>$data['token']));
				$response['success']="login successfully";
				$response['status']= 200;
				$session = session();
				$session->set('login',$result);


			}else{
				$response['error']="login failed";
				$response['status']= 404;
			}
			return json_encode($response);
		}
		
		
	}
	public function forgotPassword(){
		return view('forgot-password');
	}
	public function adminDashboard(){
		$session = session();
		if($session->login !== Null){
			return view('dashboard');
		}else{
			return redirect()->to('login');
		}
		
	}

	public function logout(){
		$session = session();
		if($session->login !== Null){
			$session->remove('login');
			return redirect()->to('login');

		}

	}

	//--------------------------------------------------------------------

}
