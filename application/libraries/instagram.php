<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
v0.1
Author: Fedmich
*/

class instagram {
	public function media_hashtag( $hashtag , $after_id ) {
		$this->ci = & get_instance();
		$this->ci->load->config( 'instagram' );
		$instagram_clientid = $this->ci->config->item('instagram_clientid');
		
		if(empty($instagram_clientid)){
			return array();
		}
		
		$search2 = urlencode( ltrim( $hashtag, '# ')  );
	    $url = "https://api.instagram.com/v1/tags/$search2/media/recent?client_id=$instagram_clientid";

		if ($after_id) {
			$url .= "&max_tag_id=$after_id";
	    }

		$medias = $this->call_api($url);
		return $medias;
	}
	public function call_api($url) {
		$contents = $this->curl_call($url);
		if (empty($contents)) {
			return array();
		}
		return json_decode($contents);
    }

    public function curl_call($url) {
		$curl_session = curl_init();

		curl_setopt($curl_session, CURLOPT_URL, $url);

		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, FALSE);

		$contents = curl_exec($curl_session);
		curl_close($curl_session);

		return $contents;
    }
}
