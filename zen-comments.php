<?php

const ZEN_MEDIA = 'https://zen.yandex.ru/media/';
const DATA_DIR = 'data';



class ZenExcert {

	public $id;
	public $zenPostUrl;
	public $html;

	private $title;
	private $description;


	function __construct($ref) {
		$this->zenPostUrl  = $ref;
		$this->id          = $this->get_comment_id($ref);
		$this->title       = '';
		$this->description = '';
	}


	private function get_comment_id ($ref_url) {
		if (substr($ref_url, 0, strlen(ZEN_MEDIA)) === ZEN_MEDIA) {
			return substr($ref_url, -24);
		}
		return DEFAULT_ID;
	}




	private function get_html() {
		$html = '<h2>' . $this->title . '</h2>' . PHP_EOL;
		if (!empty($this->description)) {
			$html  .= '<p>' .$this->description. '</p>' . PHP_EOL;
		}
		return $html;
	}

	public function get_excerpt () {
		if (! empty($this->title)) {
			return $this->get_html();
		}
		$this->loadJson();

		if (! empty($this->title)) {
			return $this->get_html();
		}
		$this->get_og_properties ();
		$this->saveJson();
		return $this->get_html();
	}

	private function loadJson() {
		$filename = getDataFile ($this->id . '.json');
		if (!file_exists($filename)) {
			return;
		}
		$json_file = file_get_contents($filename);

		if (empty($json_file)) {
			return;
		}
		$json = json_decode($json_file);
		if (empty ($json)) {
			return;
		}
		if (isset($json->url)) {
			$this->zenPostUrl = $json->url;
		}
		if (isset($json->title)) {
			$this->title = $json->title;
		}

		if (isset($json->description)) {
			$this->description = $json->description;
		}
	}

	private function saveJson() {
		$filename = getDataFile ($this->id . '.json');
		$json_array = array ('url' => $this->zenPostUrl,
		                     'title' => $this->title,
		                     'description' => $this->description);
		$fp = fopen($filename, 'w');
		fwrite($fp, json_encode($json_array,JSON_PRETTY_PRINT));
		fclose($fp);
	}


	function get_og_properties () {
		libxml_use_internal_errors(true);
		$content = file_get_contents($this->zenPostUrl);
		$document = new DomDocument();
		$document->loadHTML($content);
		$xp = new domxpath($document);
		foreach ($xp->query("//meta[@property='og:title']") as $el) {
			$this->title = $el->getAttribute("content");
		}
		foreach ($xp->query("//meta[@property='og:description']") as $el) {
			$this->description =  $el->getAttribute("content");
		}
	}



}

function getDataFile ($file) {
	$dir = __DIR__ . '/' . DATA_DIR . '/';
	if (!file_exists($dir)) {
		mkdir($dir, 0777, true);
	}
	return $dir . $file;
}

