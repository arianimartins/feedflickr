<?php

	function getFeed($id,$tag,$qnt){

		$url = 'http://api.flickr.com/services/feeds/photos_public.gne';
		$uri = $url.'?id='.$id.'&tags='.$tag.'&format=rss2';
		$content = curl_get_contents($uri);
		$x = new SimpleXmlElement($content);
		
		//$entry->enclosure[0]->attributes()->url

		$count = 0;

		echo '<div class="flickr-wrapper flickr-size-thumbnail">';
			echo '<div class="flickr-images">';
			foreach ($x->channel->item as $entry) {
					echo '<a href="'.$entry->link.'">';
						echo '<img src="'.$entry->children('http://search.yahoo.com/mrss/')->thumbnail->attributes()['url'].'" alt="'.$entry->title.'" title="'.$entry->title.'" width="75" height="75">';
					echo '</a>';	
					$count++;
				if($count++ == $qnt) break;
			}
			echo '</div>';
		echo '</div>';
	}


	function curl_get_contents($url){
		$userAgent = $_SERVER['HTTP_USER_AGENT'];

	  	$ch = curl_init();
	  	curl_setopt($ch, CURLOPT_URL, $url);
	  	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	  	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	  	
	  	$data = curl_exec($ch);
	  	curl_close($ch);
	  
	  	return $data;
	}
?>