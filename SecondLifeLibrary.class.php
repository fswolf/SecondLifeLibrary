<?php 

class SecondLifeLibrary {

	public function __construct() { 
		
	} 

	//converts name to lower case and adds last name if blank
	public function uniform_name($name) { 
		$name_array = explode(" ", mb_strtolower($name));
		if(empty($name_array[1])) $name_array[1] = "resident";
		return implode(" ", $name_array);	
	}

	public function get_sl_meta_tags($uuid) {
		$tags = get_meta_tags("https://world.secondlife.com/resident/$uuid"); 								 
		return $tags;
	}

	public function get_profile_picture_url($uuid) {
		$image_key = $this->get_sl_meta_tags($uuid);
		$url = "/assets/images/user-1.jpg";
		if(isset($image_key['imageid'])) {
			$key = $image_key['imageid'];
			if($key != "00000000-0000-0000-0000-000000000000") $url = "https://secondlife.com/app/image/$key/1";
		}
		return $url;
	}

	public function get_lindex() {
		$lindex = FALSE;
		$raw = file_get_contents("https://secondlife.com/httprequest/lindex.php");
		if($raw !== FALSE) {
			$split = explode("\n", $raw);
			$count = count($split) - 1;
			for ($i = 0; $i < $count; $i += 2) 
				$lindex[$split[$i]] = $split[$i + 1];
		}		
		return $lindex;
	}

	public function get_key($name) {
		$name = urlencode($this->uniform_name($name));
		$uuid = file_get_contents("http://w-hat.com/name2key?name=$name&terse=1");
		return $uuid;
	}
}

?>