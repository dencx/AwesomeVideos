<?php
namespace App\Utils;

use App\Utils\Interfaces\UploaderInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Core\Security;

class VimeoUploader implements UploaderInterface {

    public function __construct(Security $security)
    {
        $this->vimeoToken = $security->getUser()->getVimeoApiKey();
        
    }

    public function upload($file)
    {
        
    }

    public function delete($path)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.vimeo.com/videos/$path",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/vnd.vimeo.*+json;version=3.4",
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer {$this->vimeoToken}",
            "Cookie: __cf_bm=u4RAxuFJs5A.z4OUUSNRCXw1786so4cTnpzzcLEgf9c-1707821112-1-AZo9gb9oXoV0saVQjuM8VWV475O7Xe/4UNdYTjOupCIPS0gna8uxM6UpSwCeboS2JFlfAKTOiEfv/QmIzgSHXv4="
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if($err){
            throw new ServiceUnavailableHttpException('Error. Try again later. Message: '.$err);
        } else {
            return true;
        }
    }

}