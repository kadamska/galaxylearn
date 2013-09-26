<?php
/**
 * Sending email through Mandrill
 */
class Email 
{
    const URI = 'https://mandrillapp.com/api/1.0/messages/send.json?key=TfwBVbcI1N54lNqfsAEL6A';
    const KEY = 'TfwBVbcI1N54lNqfsAEL6A';
    const FROM_EMAIL = 'info@galaxylearn.com';
    const FROM_NAME = 'Time Machine';
    
    private $_htmlBody;
    private $_textBody;
    private $_subject;
    private $_recipients = array();
    
    /**
     * Set html body
     * @param string $body body
     */
    public function setHtmlBody($body)
    {
        $this->_htmlBody = $body;
    }
    
    /**
     * Set text body
     * @param string $body body
     */
    public function setTextBody($body)
    {
        $this->_textBody = $body;
    }
    
    /**
     * Set subject
     * @param string $subject subject
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }
    
    /**
     * Add "To" recipient
     * @param string $email email
     */
    public function addToRecipient($email)
    {
        $this->_recipients[] = array('email' => $email);
    }
    
    /**
     * Send email
     * @return boolean true if email sent, false otherwise
     */
    public function send() 
    {
        $data = array(
            'key' => self::KEY,
            'message' => array (
                'html' => $this->_htmlBody,
                'text' => $this->_textBody,
                'subject' => $this->_subject,
                'from_email' => self::FROM_EMAIL,
                'from_name' => self::FROM_NAME,
                'to' => $this->_recipients,
                'headers' => array()
            ),
            'async' => 'false'
        );
        
        $postfields = json_encode($data);
        
        $ch = curl_init(self::URI);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postfields))
        );
        
        /*
         * TODO The following defeats the purpose of SSL
        * Need to get certificates for new curl: http://curl.haxx.se/docs/sslcerts.html
        */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        error_log('message sent through Mandrill: '. $postfields);
        $result = curl_exec($ch);
        
        error_log('result from Mandrill: '. $result);
        curl_close($ch);
        
        $resultDecoded = json_decode($result, true);
        
        if (!$result) {
            return false;
        }
        
        $res = $resultDecoded[0];
        return (is_array($res) && array_key_exists('status', $res) && $res['status'] === 'sent');
    }
    
}
