<?php

class Evernote
{
    /** @var  string */
    protected $token;

    /** @var  boolean */
    protected $sandbox;

    /** @var  boolean */
    protected $china;

    /** @var  string */
    protected $key;

    /** @var  string */
    protected $secret;


    /**
     * @param string|null $token
     */
    public function __construct($token = null)
    {
        $EvernoteSettings = EvernoteSettings::current_Evernote_settings();
        if(empty($EvernoteSettings)) {
            user_error(
                _t(
                    'NO_EVERNOTE_ACTIVE',
                    'No Evernote Settings Available. Please setup the Evernote configuration.'
                ),
                E_USER_ERROR
            );
        }
        $this->token = $token;
        $this->sandbox = boolval(($EvernoteSettings->Sandbox) ?: true);
        $this->china = boolval(($EvernoteSettings->China) ?: false);
        $this->key = ($EvernoteSettings->APIKey) ?: '';
        $this->secret = ($EvernoteSettings->APISecret) ?: '';
    }

    /**
     * @return null|string
     */
    public function Authorize()
    {
        $oauth_handler = new \Evernote\Auth\OauthHandler($this->sandbox, false, $this->china);
        try {
            $oauth_data = $oauth_handler->authorize($this->key, $this->secret, $this->getCallbackUrl());
            $this->token = $oauth_data['oauth_token'];
            $ret = $this->token;

        } catch (\Evernote\Exception\AuthorizationDeniedException $e) {
            //If the user decline the authorization, an exception is thrown.
            $ret = null;
        }

        return $ret;
    }

    /**
     * @return string
     */
    private function getCallbackUrl()
    {
        $thisUrl = Director::absoluteBaseURL().'evernote-auth/callback';

        return $thisUrl;
    }

    /**
     * @param $token
     * @return array
     */
    public function notebookList($token)
    {
        $client = new \Evernote\Client($token, $this->sandbox, null, null, $this->china);

        $notebooks = array();

        $notebooks = $client->listNotebooks();
        return $notebooks;
    }

}