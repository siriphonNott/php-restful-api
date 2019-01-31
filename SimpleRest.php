<?php 
/*
  project: Simple Rest Class
  modify by: NottDev
  modify at: 30/01/19
*/

class SimpleRest
{
  public $httpVersion;
  public $contentType;

  public function __construct($contentType = "application/json")
  {
    $this->httpVersion = "HTTP/1.1";
    $this->contentType = $contentType;
  }

  public function setContentType($contentType)
  {
    $this->contentType = $contentType;
  }

  public function getContentType()
  {
    return $this->contentType;
  }

  public function setHttpStatus($statusCode)
  {
    $statusMessage = $this->getHttpStatusMessage($statusCode);
    header($this->httpVersion . " " . $statusCode . " " . $statusMessage);
    header("Content-Type:" . $this->contentType);
  }

  public function getHttpStatusMessage($statusCode)
  {
    $httpStatus = array(
      100 => 'Continue',
      101 => 'Switching Protocols',
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative Information',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      306 => '(Unused)',
      307 => 'Temporary Redirect',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Timeout',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Long',
      415 => 'Unsupported Media Type',
      416 => 'Requested Range Not Satisfiable',
      417 => 'Expectation Failed',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      505 => 'HTTP Version Not Supported');
      return (isset($httpStatus[$statusCode])) ? $httpStatus[$statusCode] : 'Internal Server Error';
  }

  public function encodeHTML($responseData) {
		$htmlResponse = "<table border='1'>";
		foreach($responseData as $key=>$value) {
    			$htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
		}
		$htmlResponse .= "</table>";
		return $htmlResponse;		
	}
	
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}
	
	public function encodeXML($responseData) {
		// creating object of SimpleXMLElement
		$xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
		foreach($responseData as $key=>$value) {
			$xml->addChild($key, $value);
		}
		return $xml->asXML();
  }

  public function response($data)
  {
    $encodedRespone;
    if(strpos($this->contentType, "text/plain") !== false) {
      $encodedRespone = $data;
    } elseif (strpos($this->contentType,"application/json") !== false) {
      $encodedRespone = $this->encodeJSON($data);
    } elseif (strpos($this->contentType,"application/javascript") !== false) {
      $encodedRespone = $this->encodeJSON($data);
    } elseif (strpos($this->contentType,"application/xml") !== false) {
      $encodedRespone = $this->encodeXML($data);
    } elseif (strpos($this->contentType,"text/xml") !== false) {
      $encodedRespone = $this->encodeXML($data);
    } elseif (strpos($this->contentType, "text/html") !== false) {
      $encodedRespone = $this->encodeHTML($data);
    }
    return $encodedRespone;
  }
  
}