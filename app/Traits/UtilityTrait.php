<?php
/**
 * Utility trait
 *
 * @category UtilityTrait
 * @author   Adsum Originator <developer@adsumoriginator.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://local.adsumoriginator.com/
 */

namespace App\Traits;

use App\Library\CustomORM\AppCollection;
use Illuminate\Support\Facades\Storage;
use \ZipArchive;
use File;
use App\Models\User;
use Mail;
use Carbon\Carbon;
use Auth;

/**
 * Utility trait
 *
 * @category UtilityTrait
 * @author   Adsum Originator <developer@adsumoriginator.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     
 */
trait UtilityTrait
{
    /**
     * Method get value by given key from array.
     *
     * @param string     $value     value
     * @param mixed|null $default default flag
     *
     * @return mixed
     */
    public function definedMap(string $value,$default = null)
    {
        return (!isset($value) || is_null($value)) ? $default : $value;
    }

    /**
     * Method get value by given key from array.
     *
     * @param string     $key     key name
     * @param array      $arr     array
     * @param mixed|null $default default flag
     *
     * @return mixed
     */
    public function arrayGet(string $key, array $arr, $default = null)
    {
        if (is_array($arr) && array_key_exists($key, $arr) && !empty($arr[$key])) {
            return $arr[$key];
        }
        return $default;
    }
    /**
     * This will send mail
     *
     * @param string $toEmail  ToEmail
     * @param string $mailFrom MailFrom
     * @param string $mailName MailName
     * @param string $body     Body
     * @param string $subject  Subject
     *
     * @return void
     */
    public function sendMail(
        string $toEmail,
        string $mailFrom,
        string $mailName,
        string $body,
        string $subject,
        string $fileName
    ) {
        Mail::send(
            $fileName,
            ['body' => $body],
            function ($message) use ($toEmail, $body, $mailFrom, $mailName, $subject) {
                $message->to($toEmail)->subject($subject);
                $message->from($mailFrom, $mailName);
            }
        );
    }
    /**
     * getPaymentStatus
     * @param object $user 
     * 
     * @return boolean
     */
    public function getPaymentStatus($user)
    {
        if($user){
            $payment= \App\Models\Payment::where(['user_id'=>$user->id,'pool_id' => 0,'transaction_status'=>'succeeded'])->first();
            if($payment){
                return true;
            }
        }
        return false;
    }

    /**
     * getPaymentCheck
     * @param object $user 
     * 
     * @return boolean
     */
    public function getJoinPoolPayment($user)
    {
        if($user){
            $joinPayment= \App\Models\JoinPoolPayment::where(['user_id'=>$user->id,'pool_id' => 0,'transaction_status'=>'succeeded'])->first();
            if($joinPayment){
                return true;
            }
        }
        return false;
    }

    /**
     * This will retrive table name
     *
     * @return string Table Name
     */
    public function getTableName() :string
    {
        return $this->table;
    }

    /**
     * Converts an object to an array
     *
     * @param object $d object to be converted
     *
     * @return array Array convertido
     */
    public function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        return is_array($d) ? array_map(array($this, 'objectToArray'), $d) : $d;
    }

    /**
     * Passing model name for the pagination and sorting.
     *
     */
    public function newCollection(array $models = [])
    {
        return new AppCollection($models);
    }


    /**
     *  This get customer detail
     * 
     *  @param string $id customer_id
     * 
     * @return object
     */
    public function getcustomerdetail($id){

        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret')
          );
        $customer= $stripe->customers->retrieve($id);
        return $customer;
    }
     /**
     *  This create payment on stripe
     * 
     *  @param object $data data
     * 
     * @return object
     */
    public function paymentcreate($data)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $intent = \Stripe\PaymentIntent::create([
                'customer' => $data['customer_id'],
                'amount' => ($data['amount']*100),
                'currency' => $data['currency'],
                'payment_method_types' => ['card'],
                'description' => $data['description'],
                'confirm' => true,
                'payment_method' => $data['payment_method'],]);
        return $intent;
    }
    /**
     * This check card Type
     *
     * @param string $cardNumber cardNumber
     *
     * @return string  $cardType
     */
    public function cardType($cardNumber)
    {
        $prefix= substr($cardNumber, 0, 1);
        if ($prefix == "4" || $prefix == "1") {
            $cardType="visa";
        } elseif ($prefix =="5") {
            $cardType="master";
        } elseif ($prefix == "6") {
            $cardType="discover";
        } else {
            $cardType = "";
        }
        return $cardType;
    }

    /**
     * Verify if exit subarray
     *
     * @param array   $arr      -> array to verify if exits subarray
     * @param boolean $checkAll -> To check whether all the elements are array or not
     *
     * @return boolean     true if exist and false if not
     */
    public function existSubArray($arr, bool $checkAll = false): bool
    {
        $noOfArray =  0;
        foreach ($arr as $value) {
            if (is_array($value)) {
                if (false === $checkAll) {
                    return true;
                } else {
                    $noOfArray++;
                }
            }
        }

        if ($noOfArray === count($arr)) {
            return true;
        }

        return false;
    }

   
    /**
     * This will prepare Data for send email
     *
     * @param array $input input
     * @param string $password password
     * @param string $url url
     *
     * @return boolean
     */
    public function prepareSendMailData(array $input, string $password, string $url)
    {
        $body = array(
            'username' => $input['username'],
            'password' => $password,
            'firstName' => $input['first_name'],
            'lastName' => $input['last_name'],
            'email' => $input['email'],
            'login_url' => $url
        );
        $fromEmail = env('MAIL_FROM', 'care@seng.com');
        $fromName = env('MAIL_NAME', 'SENG');
        $subject = config('constants.subjects.newAccount');
        $this->sendMail($input['email'], $fromEmail, $fromName, $body, $subject, 'verifyAccount');
    }

 
    /**
     * This will get current site protocol as per url defined in env
     *
     * @param int $companyId CompanyId
     *
     * @return void
     */
    public function getProtocol()
    {
        $url = explode("://", env('APP_URL'));

        return $url[0];
    }

    /**
     * This will encrypt data
     *
     * @param int $data data
     *
     * @return void
     */
    public function encrypt($data)
    {
        $id = (int)$data * 253525;
        return base64_encode($id);
    }

    /**
     * This will decrypt data
     *
     * @param string $data data
     *
     * @return void
     */
    public function decrypt($data)
    {
        $urlId = base64_decode($data);
        $id = (int)$urlId / 253525;
        return $id;
    }


    /**
     * This will get Time Zone
     *
     * @param string $time time
     * @param int $flag flag 1 means date format "Y-m-d H:i:s"
     * @param string $timezone timezone
     * @param string $isCron flag is called from cron
     *
     * @return void
     */
    public function getTimeZone($time, $flag, $timezone = null, $isCron = 0)
    {
        date_default_timezone_set($timezone);
        $returnTime = Carbon::parse($time)->format("Y-m-d");
        if ($flag == 1) {
            $returnTime =Carbon::parse($time)->format("Y-m-d H:i:s");
        }
        if (!$isCron) {
            date_default_timezone_set('UTC');
        }

        return $returnTime;
    }

    /**
     * This will get Time(mostly used in main sale recurring/attempt time)
     *
     * @param string $startDate date
     * @param string $endDate date
     * @param string $startTime date
     * @param string $endTime date
     *
     * @return string
     */
    public function getMainTime($startDate, $endDate, $startTime, $endTime)
    {
        if ($startDate != $endDate) {
            $randomDate = Carbon::parse(
                rand(strtotime($startDate), strtotime($endDate))
            )->format("Y-m-d");
            $randomTime = Carbon::parse(
                rand(strtotime($startTime), strtotime($endTime))
            )->format("H:i:s");
            return $randomDate.' '.$randomTime;
        }
        $startDateTime = strtotime($startDate .' '. $startTime);
        $endDateTime   = strtotime($endDate .' '. $endTime);
        $newRecurringDate = Carbon::parse(
            rand($startDateTime, $endDateTime)
        )->format("Y-m-d H:i:s");
        return $newRecurringDate;
    }

   

    public function getRoundedNumber($number, $afterDigit = 2)
    {
        return number_format(
            (float)$number,
            $afterDigit,
            '.',
            ''
        );
    }

    public function sendSingle($registration_ids, $message)
    {
        $fields = array(
            'to' => $registration_ids,
            'notification' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    public function sendMultiple($registration_ids, $message)
    {
        $fields = array(
            'registration_ids' => $registration_ids,
            'notification' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    public function sendPushNotification($fields)
    {
        $headers = [
            'Authorization: key=AAAAGhTPmzY:APA91bGLNPNMPvGSjfei1d7eMI58QoAz2yty0R5vQIMq6Z47U2Z9u8ZkmaUjn11foZ36My9U9F_j6R30xTtp9zQhAiHR_ay1ezLXySNYZ0aipRg2EhEuzLYWrVgkpV2a2hyzw-vSNqxO',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        
        \Log::info("Cron is working 🤩".$result);

        curl_close($ch);
        return $result;
    }
}
