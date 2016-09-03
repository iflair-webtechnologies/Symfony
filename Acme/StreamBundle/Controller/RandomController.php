<?php
// src/Acme/DemoBundle/Controller/RandomController.php
namespace Acme\StreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RandomController extends Controller
{	
	private $json    = '',
	$key     = 'blur619sleeve',
	$pass    = 'X',
	$baseUrl = 'http://project.happyidiots.nl/',
	$url     = 'projects.json';
	
	public function indexAction($number=null)
	{
		//return new Response('<html><body>Number: '.rand(1, $limit).'</body></html>');
		$number = $number;//rand(1, $limit);
		
		return $this->render(
				'AcmeStreamBundle:Random:index.html.twig',
				array('number' => $number)
		);
		
		// render a PHP template instead
		// return $this->render(
		//     'AcmeDemoBundle:Random:index.html.php',
		//     array('number' => $number)
		// );
	}
	
	private function getJson($url = '')
	{
		if (!strlen($url)) {
			$url = $this->baseUrl . $this->url;
		}
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$this->key:$this->pass");
	
		$json = curl_exec($ch);
	
		curl_close($ch);
	
		return $json;
	}
	
	/* for all teams */
	public function getPeopleimageo($projectid ,$peopleids) {
		$user_image = '';
		if($peopleids !='' && $projectid != '') {
			$url  = $this->baseUrl .'/projects/'.$projectid.'/people/'.$peopleids.'.json';
			$json = $this->getJson($url);
			if (strlen($json)) {
				$peoples = json_decode($json, true);
	
				if (array_key_exists('people', $peoples) && count($peoples['people']))
				{
					foreach($peoples['people'] as $people)
					{
						if($people['avatar-url']) {
							$user_image = $people['avatar-url'];
							break;
						}
					}
				}
			}
		}
	
		if($user_image == '') {
			$user_image = $this
			->get('templating.helper.assets')
			->getUrl('bundles/stream/images/noPhoto2.png', $packageName = null);
		}
		return $user_image;
	}
	
	public function getCompletedo() {
		$mySmileImage = $this
		->get('templating.helper.assets')
		->getUrl('bundles/stream/images/smily.jpg', $packageName = null);
	
		$myrightImage = $this
		->get('templating.helper.assets')
		->getUrl('bundles/stream/images/right.jpg', $packageName = null);
	
		$rp='';
		//$url  = $this->baseUrl . 'milestones.json?find=completed&pageSize=2';
		$url  = $this->baseUrl . 'milestones.json?find=completed';
		$json = $this->getJson($url);
	
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
			//$rp .= '<ul>';
			if($milestones['milestones']) {
				$milestones = array_reverse($milestones['milestones']);
	
				foreach($milestones as $milestone) {
					$i++;
					if($i>2) { break; }
					else {
						$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
						$other_images = '';
						if(count($responsible_party_ids) > 1) {
								
							foreach ($responsible_party_ids as $id) {
								$other_image = $this->getPeopleimageo($milestone['project-id'], $id);
								$other_images .= '<img src="'.$other_image.'" class="user" />';
							}
						}
	
						$myuserImage =  $this->getPeopleimageo($milestone['project-id'], $milestone['responsible-party-id']);
						$rp .= '<li>';
						$rp .= '<div class="left-image"><img src="'.$myrightImage.'" /></div>';
						$rp .= '<div class="main_wrapper_right">';
						$rp .= '<div class="disc"><h1 style="text-decoration: line-through;">'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
						$rp .= '<div class="right-image"><img src="'.$mySmileImage.'" class="smile" />';
						if($other_images != '') {
							$rp .=	'<div class="user_images">'.$other_images.'</div>';
						}
						else
							$rp .= '<img src="'.$myuserImage.'" class="user" />';
	
						$rp .= '</div>';
						$rp .= '</div>';
						$rp .= '</li>';
					}
						
				}
			}
		}
		return $rp;
	}
	
	public function getLateo() {
		$rp='';
		$url  = $this->baseUrl . 'milestones.json?find=late&pageSize=2';
		$json = $this->getJson($url);
	
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
			//$rp .= '<ul>';
			foreach($milestones['milestones'] as $milestone) {
				$i++;
				if($i>2) { break; }
				else {
						
					$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
					$other_images = '';
					if(count($responsible_party_ids) > 1) {
	
						foreach ($responsible_party_ids as $id) {
							$other_image = $this->getPeopleimageo($milestone['project-id'], $id);
							$other_images .= '<img src="'.$other_image.'" class="user" />';
						}
					}
						
					$myuserImage =  $this->getPeopleimageo($milestone['project-id'], $milestone['responsible-party-id']);
						
					$deadline = $milestone['deadline'];
					$m = date("F", strtotime($deadline));
					$d = date("d", strtotime($deadline));
					$w = date("l", strtotime($deadline));
						
					$rp .= '<li class="dark-red">';
					$rp .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
					$rp .= '<div class="main_wrapper_right">';
					$rp .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
					$rp .= '<div class="right-image">';
					if($other_images != '') {
						$rp .=	'<div class="user_images">'.$other_images.'</div>';
					}
					else
						$rp .= '<img src="'.$myuserImage.'" class="user" />';
	
					$rp .= '</div>';
					$rp .= '</div>';
					$rp .= '</li>';
				}
	
			}
		}
		return $rp;
	}
	
	public function getTodayo() {
		$todaydate =  date("Ymd");
	
		$rp='';
		$rpw='';
		$rpn='';
		$url  = $this->baseUrl . 'milestones.json?find=incomplete';
		$json = $this->getJson($url);
	
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
	
			foreach($milestones['milestones'] as $milestone) {
				$i++;
				$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
				$other_images = '';
				if(count($responsible_party_ids) > 1) {
	
					foreach ($responsible_party_ids as $id) {
						$other_image = $this->getPeopleimageo($milestone['project-id'], $id);
						$other_images .= '<img src="'.$other_image.'" class="user" />';
					}
				}
				$myuserImage =  $this->getPeopleimageo($milestone['project-id'], $milestone['responsible-party-id']);
				$deadline = $milestone['deadline'];
				$m = date("F", strtotime($deadline));
				$d = date("d", strtotime($deadline));
				$w = date("l", strtotime($deadline));
	
				if($todaydate == $deadline) {
					$rp .= '<li class="yello-c">';
					$rp .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
					$rp .= '<div class="main_wrapper_right">';
					$rp .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
					$rp .= '<div class="right-image">';
					if($other_images != '') {
						$rp .=	'<div class="user_images">'.$other_images.'</div>';
					}
					else
						$rp .= '<img src="'.$myuserImage.'" class="user" />';
	
					$rp .= '</div>';
					$rp .= '</div>';
					$rp .= '</li>';
				} else {
					$date = strtotime($deadline);
					if(strtotime('-7 days') < $date && $date < strtotime('+7 days')) {
						$rpw .= '<li class="blue-c">';
						$rpw .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
						$rpw .= '<div class="main_wrapper_right">';
						$rpw .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
						$rpw .= '<div class="right-image">';
						if($other_images != '') {
							$rpw .=	'<div class="user_images">'.$other_images.'</div>';
						}
						else
							$rpw .= '<img src="'.$myuserImage.'" class="user" />';
							
						$rpw .= '</div>';
						$rpw .= '</div>';
						$rpw .= '</li>';
					} else {
						$rpn .= '<li class="maroon-c">';
						$rpn .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
						$rpn .= '<div class="main_wrapper_right">';
						$rpn .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
						$rpn .= '<div class="right-image">';
						if($other_images != '') {
							$rpn .=	'<div class="user_images">'.$other_images.'</div>';
						}
						else
							$rpn .= '<img src="'.$myuserImage.'" class="user" />';
	
						$rpn .= '</div>';
						$rpn .= '</div>';
						$rpn .= '</li>';
					}
				}
			}
		}
		return $rp.$rpw.$rpn;
	}
	
	/* for all teams */
	
	/* for specify teams */

	public function getPeopleimage($projectid ,$peopleids) {
		$user_image = '';
		if($peopleids !='' && $projectid != '') { 
			$url  = $this->baseUrl .'/projects/'.$projectid.'/people/'.$peopleids.'.json';
			$json = $this->getJson($url);
			if (strlen($json)) {
				$peoples = json_decode($json, true);
				
				if (array_key_exists('people', $peoples) && count($peoples['people']))
				{
					foreach($peoples['people'] as $people)
					{
						//if($people['phone-number-fax'] == $teamid) {
						if($people['avatar-url']) {
							$user_image = $people['avatar-url'].'|'.$people['phone-number-fax'];
							break;
						}
					}
				}
			}
		}
		
		if($user_image == '') {
			$user_image = $this
			->get('templating.helper.assets')
			->getUrl('bundles/stream/images/noPhoto2.png', $packageName = null);
		}
		return $user_image;
	}
	
	public function getCompleted($teamid) {
		$mySmileImage = $this
		->get('templating.helper.assets')
		->getUrl('bundles/stream/images/smily.jpg', $packageName = null);
		
		$myrightImage = $this
		->get('templating.helper.assets')
		->getUrl('bundles/stream/images/right.jpg', $packageName = null);
	
		$rp='';
		//$url  = $this->baseUrl . 'milestones.json?find=completed&pageSize=2';
		$url  = $this->baseUrl . 'milestones.json?find=completed';
		$json = $this->getJson($url);
		
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
			//$rp .= '<ul>';
			if($milestones['milestones']) {
				$milestones = array_reverse($milestones['milestones']);

				foreach($milestones as $milestone) {
					
					if($i>=2) { break; }
					else {
					$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
						$other_images = '';
						$is_in_team = '';
						if(count($responsible_party_ids) > 1) {
							foreach ($responsible_party_ids as $id) {
								$other_image = explode('|',$this->getPeopleimage($milestone['project-id'], $id));
								$other_images .= '<img src="'.$other_image[0].'" class="user" />';
								
								if($other_image[1] == $teamid)
									$is_in_team = 'yes';
							}
						}
						$myuserImagez =  explode('|',$this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']));
						$myuserImage =  $myuserImagez[0]; //$this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']);
						if($other_images != '') {
							if($is_in_team != 'yes')
								continue;
						} else {
							if($myuserImagez[1] != $teamid)
								continue;
						}
						$i++;
						
						$rp .= '<li>';
						$rp .= '<div class="left-image"><img src="'.$myrightImage.'" /></div>';
						$rp .= '<div class="main_wrapper_right">';
							$rp .= '<div class="disc"><h1 style="text-decoration: line-through;">'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
							$rp .= '<div class="right-image"><img src="'.$mySmileImage.'" class="smile" />';
							if($other_images != '') {
								$rp .=	'<div class="user_images">'.$other_images.'</div>';
							}
							else
								$rp .= '<img src="'.$myuserImage.'" class="user" />';
								
							$rp .= '</div>';
						$rp .= '</div>';
						$rp .= '</li>';
					}
			
				}
			}
		}	
		return $rp;
	}
	
	public function getLate($teamid) {
		$rp='';
		$url  = $this->baseUrl . 'milestones.json?find=late&pageSize=2';
		$json = $this->getJson($url);
	
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
			//$rp .= '<ul>';
			if($milestones['milestones']) {
				foreach($milestones['milestones'] as $milestone) {
					if($i>2) { break; }
					else {
						$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
						$other_images = '';
						$is_in_team = '';
						
						if(count($responsible_party_ids) > 1) {
							foreach ($responsible_party_ids as $id) {
								$other_image = explode('|',$this->getPeopleimage($milestone['project-id'], $id));
								$other_images .= '<img src="'.$other_image[0].'" class="user" />';
						
								if($other_image[1] == $teamid)
									$is_in_team = 'yes';
							}
						}
						$myuserImagez =  explode('|',$this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']));
						$myuserImage =  $myuserImagez[0]; //$this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']);
						if($other_images != '') {
							if($is_in_team != 'yes')
								continue;
						} else {
							if($myuserImagez[1] != $teamid)
								continue;
						}
						$i++;
						
						$deadline = $milestone['deadline'];
						$m = date("F", strtotime($deadline));
						$d = date("d", strtotime($deadline));
						$w = date("l", strtotime($deadline));
						
						$rp .= '<li class="dark-red">';
						$rp .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
						$rp .= '<div class="main_wrapper_right">';
							$rp .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
							$rp .= '<div class="right-image">';
							if($other_images != '') {
								$rp .=	'<div class="user_images">'.$other_images.'</div>';
							}
							else
								$rp .= '<img src="'.$myuserImage.'" class="user" />';
							
							$rp .= '</div>';
							$rp .= '</div>';
						$rp .= '</li>';
					}
		
				}
			}
		}
		return $rp;
	}
	
	public function getToday($teamid) {
		$todaydate =  date("Ymd");
		
		$rp='';
		$rpw='';
		$rpn='';
		$url  = $this->baseUrl . 'milestones.json?find=incomplete';
		$json = $this->getJson($url);
	
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
			if($milestones['milestones']) {
				foreach($milestones['milestones'] as $milestone) {
					
					$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
					$other_images = '';
					$is_in_team = '';
					$myuserImagez='';
					
					if(count($responsible_party_ids) > 1) {
						foreach ($responsible_party_ids as $id) {
							$other_image = explode('|',$this->getPeopleimage($milestone['project-id'], $id));
							$other_images .= '<img src="'.$other_image[0].'" class="user" />';
					
							if($other_image[1] == $teamid)
								$is_in_team = 'yes';
						}
					} else {
						$myuserImagez =  explode('|',$this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']));
						$myuserImage =  $myuserImagez[0]; //$this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']);
					}
					
					if($other_images != '') {
						if($is_in_team != 'yes')
							continue;
					} else {
						if($myuserImagez[1] != $teamid)
							continue;
					}
					$i++;
						
					$deadline = $milestone['deadline'];
					$m = date("F", strtotime($deadline));
					$d = date("d", strtotime($deadline));
					$w = date("l", strtotime($deadline));
					
					if($todaydate == $deadline) {
						$rp .= '<li class="yello-c">';
						$rp .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
						$rp .= '<div class="main_wrapper_right">';
							$rp .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
							$rp .= '<div class="right-image">';
							if($other_images != '') {
								$rp .=	'<div class="user_images">'.$other_images.'</div>';
							}
							else
								$rp .= '<img src="'.$myuserImage.'" class="user" />';
							
							$rp .= '</div>';
							$rp .= '</div>';
						$rp .= '</li>';
					} else {
						$date = strtotime($deadline);
						if(strtotime('-7 days') < $date && $date < strtotime('+7 days')) {
							$rpw .= '<li class="blue-c">';
							$rpw .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
							$rpw .= '<div class="main_wrapper_right">';
								$rpw .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
								$rpw .= '<div class="right-image">';
								if($other_images != '') {
									$rpw .=	'<div class="user_images">'.$other_images.'</div>';
								}
								else
									$rpw .= '<img src="'.$myuserImage.'" class="user" />';
								
								$rpw .= '</div>';
							$rpw .= '</div>';
							$rpw .= '</li>';
						} else { 
							$rpn .= '<li class="maroon-c">';
							$rpn .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
							$rpn .= '<div class="main_wrapper_right">';
								$rpn .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
								$rpn .= '<div class="right-image">';
								if($other_images != '') {
									$rpn .=	'<div class="user_images">'.$other_images.'</div>';
								}
								else
									$rpn .= '<img src="'.$myuserImage.'" class="user" />';
									
								$rpn .= '</div>';
							$rpn .= '</div>';
							$rpn .= '</li>';
						}
					}
				}
			}
		}
		return $rp.$rpw.$rpn;
	}
	
	public function getIncomplete() {
	
		$rp='';
		$url  = $this->baseUrl . 'mileechostones.json?find=incomplete&pageSize=3&deadline=20141020';
		$json = $this->getJson($url);
	
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
				
			foreach($milestones['milestones'] as $milestone) {
				$i++;
				$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
				$other_images = '';
				if(count($responsible_party_ids) > 2) {
					foreach ($responsible_party_ids as $id) {
						$other_image = $this->getPeopleimage($milestone['project-id'], $id);
						$other_images .= '<img src="'.$other_image.'" class="user" />';
					}
				}
				$myuserImage =  $this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']);
				
				$deadline = $milestone['deadline'];
				$m = date("F", strtotime($deadline));
				$d = date("d", strtotime($deadline));
				$w = date("l", strtotime($deadline));
				
				$rp .= '<li class="yello-c">';
				$rp .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
				$rp .= '<div class="main_wrapper_right">';
					$rp .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
					$rp .= '<div class="right-image">';
					if($other_images != '') {
						$rp .=	'<div class="user_images">'.$other_images.'</div>';
					}
					else
						$rp .= '<img src="'.$myuserImage.'" class="user" />';
						
					$rp .= '</div>';
					$rp .= '</div>';
				$rp .= '</li>';
			}
		}
		return $rp;
	}
	
	public function getUpcoming() {
		$mySmileImage = $this
		->get('templating.helper.assets')
		->getUrl('bundles/acmedemo/images/smily.jpg', $packageName = null);
	
		$myrightImage = $this
		->get('templating.helper.assets')
		->getUrl('bundles/acmedemo/images/right.jpg', $packageName = null);
	
		$rp='';
		$url  = $this->baseUrl . 'milestones.json?find=upcoming&pageSize=3';
		$json = $this->getJson($url);
		
		if (strlen($json)) {
			$milestones = json_decode($json, true);
			$i=0;
			
			foreach($milestones['milestones'] as $milestone) {
				$i++;
				//if($i>2) { break; }
				//else {
					$responsible_party_ids = explode(',',$milestone['responsible-party-ids']);
					$other_images = '';
					if(count($responsible_party_ids) > 2) {
					
						foreach ($responsible_party_ids as $id) {
							$other_image = $this->getPeopleimage($milestone['project-id'], $id);
							$other_images .= '<img src="'.$other_image.'" class="user" />';
						}
					}
					$myuserImage =  $this->getPeopleimage($milestone['project-id'], $milestone['responsible-party-id']);
					$deadline = $milestone['deadline'];
					$m = date("F", strtotime($deadline));
					$d = date("d", strtotime($deadline));
					$w = date("l", strtotime($deadline));
					$rp .= '<li class="maroon-c">';
					$rp .= '<div class="left-image left-disc"><div class="month">'.$m.'</div><span>'.$d.'</span><p> '.$w.'</p></div>';
					$rp .= '<div class="main_wrapper_right">';
						$rp .= '<div class="disc"><h1>'.$milestone['title'].'</h1><p>Klant: '.$milestone['company-name'].'<br />Discipline: '.$milestone['project-name'].' <br>Verantwoordelijk: '.$milestone['responsible-party-names'].'</p></div>';
						$rp .= '<div class="right-image">';
						if($other_images != '') {
							$rp .=	'<div class="user_images">'.$other_images.'</div>';
						}
						else
							$rp .= '<img src="'.$myuserImage.'" class="user" />';
						
						$rp .= '</div>';
						$rp .= '</div>';
					$rp .= '</li>';
				//}
			}
		}
		return $rp;
	}
	/* for specify teams */
	
	public function ajaxAction()
	{	
		
		$id = $_POST['id'];
		
		$rp = '<ul>';
		if($id == 0) {
			$rp .= $this->getCompletedo();
			$rp .= $this->getLateo();
			$rp .= $this->getTodayo();
		} else {
			$rp .= $this->getCompleted($id);
			$rp .= $this->getLate($id);
			$rp .= $this->getToday($id);
		}
		
		//$rp	.= $this->getIncomplete(); 
		//$rp .= $this->getUpcoming();
		
		$rp .= '</ul>';
		
		if(true) {
			$msg = array('success'=>'true', 'data'=>$rp);
		} else {
			$msg = array('success'=>'false');
		}
		//$milestones = $this->getCompleted();
		
		
		return new Response(json_encode($msg));
	}
	public function clientsAction(){
		$url  = $this->baseUrl . 'people.json';
		$json = $this->getJson($url);
		return new Response(json_encode($json));
	}
	public function projectsAction(){
		$url  = $this->baseUrl . 'projects.json';
		$json = $this->getJson($url);
		return new Response(json_encode($json));
	}
}
