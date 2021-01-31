<?php
namespace App\Controllers;
use App\Models\User;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url','form'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

	public function sendNotification($title,$body){

		$userObj= new User();
		$adminData = $userObj->find(1);
		
		$header=[
			'Authorization: key=AAAAapnugJY:APA91bF0HqQ6TutURtKXaTiStP42LsT5E5CptVtRCzznlUyxiDl503EzXySLBhHDJ0AAR8ROE0UcqQYJ0FUBXkuWqNROvGuYrkUotdAwwBK1D2k6OQRoGs-SkOfMoXxZZ9m-r01OmdkE',
			'Content-Type : application/json'
		];
		$notification = [
			'title'		=>	$title,
			'body'		=>	$body,
		];
		$requestData= [
			'data' => $notification,
			'registration_ids' => $adminData['token'],
		];

		//print_r(json_encode($requestData));
		//mjhe is me msla lgrha ha 
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://fcm.googleapis.com/fcm/send");
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($requestData));
		$res = curl_exec($ch);
		
		curl_close($ch);
		echo $res;
		// return "1";

	}

}
