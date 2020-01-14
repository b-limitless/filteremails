<?php

namespace App\Http\Controllers;


use App\Emailaddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\CustomController\verifyEmail;
use Exception;
use Illuminate\Support\Facades\DB;

class EmailaddressController extends Controller
{	
	// Pagination perpage 
    public $Perpage = 20;

    // Initial first page 
    public $Pageno  = 1;


    public function index(Request $request, JsonResponse $response, Emailaddress $ticket, verifyEmail $vmail) {

    	// Get all email address 
    	$skip = $this->Pageno - 1 * $this->Perpage;

        // Set timeout for verifiy email 
        $vmail->setStreamTimeoutWait(50);

        // Set sender email 
        $vmail->setEmailFrom('viska@viska.is');

        // Get _id and email address 
    	$emailAddressRows = Emailaddress::skip($skip)->take($this->Perpage)
                ->where('is_valid', '!=', true)
                ->where('is_valid', '!=', false)
                ->get(['email', 'is_valid']);

        // Get wrong phrase 
        $wpsArr=WrongphraseController::getValidationArray();

        // New array 
        $newResponse = [];

        // Loop each value emails 
        foreach($emailAddressRows as $eachRecord) {
            // Email
            $email = $eachRecord["email"];

            // // two steps exploding and verifing the wrong phrases
            $emArr=[];
            $emEx1=explode('@', $email );
            
            
            $emEx2=explode('.', $emEx1[1]);
            $emArr=array_merge([$emEx1[0]], $emEx2);

           

            // ['ahmad','gmail','com']
            $isInvalidDetected=false;
            foreach($emArr as $emPart){
                if(in_array($emEx1[0], $wpsArr)){
                    $eachRecord->is_valid=false;
                    $eachRecord->save();
                    $isInvalidDetected=true;
                    break;
                }
            }

            if($isInvalidDetected) continue;

            if($vmail->check($email)) {
                $eachRecord->is_valid = true;
                $eachRecord->save();
            } else {
                $eachRecord->is_valid = false;
                $eachRecord->save();
            }

            $newResponse[] = $eachRecord;
        }        

        return $emailAddressRows;
    }
    
}
