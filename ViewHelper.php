<?php

class ViewHelper {

	public static function render($file, $variables = array()) {
		extract($variables);

		ob_start();
		include ($file);
		return ob_get_clean();
	}

	public static function renderJSON($data, $httpResponseCode = 200) {
		header('Content-Type: application/json');
		http_response_code($httpResponseCode);
		return json_encode($data);
	}

	public static function redirect($url) {
		header("Location: " . $url);
	}

	public static function error404() {
		header("This is not here...", true, 404);
		$html404 = sprintf("<!doctype html>\n<title>Error 404: Page does not exist</title>\n"
			. "<h1>Error 404: Page does not exist</h1>\n<p>The page <i>%s</i> does not exist.</p>", $_SERVER["REQUEST_URI"]);

		echo $html404;
	}

	public static function displayError($exception, $debug = false) {
		header("An error occurred", true, 400);

		if ($debug) {
			$html = sprintf("<!doctype html>\n<title>Error: An application error</title>\n<h1>Error: An application "	
				. "error</h1>\n<p>The page <i>%s</i> returned an error: <blockquote><pre>%s</pre></blockquote></p>",
				$_SERVER["REQUEST_URI"], $exception);
		} else {
			$html = sprintf("<!doctype html>\n<title>Error: An application error</title>\n<h1>Error: An application "	
				. "error</h1>\n<p>The page <i>%s</i> returned an error.</p>", $_SERVER["REQUEST_URI"], $exception);
		}

		echo $html;
	}
}

class ResponseType {
	const HTML = 0;
	const JSON = 1;
}