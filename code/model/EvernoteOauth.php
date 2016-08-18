<?php

namespace Evernote\Auth;

class EvernoteOauth extends \Evernote\Auth\OauthHandler
{
    protected $params = array();

    public function authorize($consumer_key, $consumer_secret, $callback)
    {
        $this->params['oauth_callback']         = $callback;
        $this->params['oauth_consumer_key']     = $consumer_key;

        $this->consumer_secret = $consumer_secret;

        // first call
        if (!array_key_exists('oauth_verifier', $_GET) && !array_key_exists('oauth_token', $_GET)) {

            unset($this->params['oauth_token']);
            unset($this->params['oauth_verifier']);

            $temporaryCredentials = $this->getTemporaryCredentials();

            Session::set('oauth_token_secret', $temporaryCredentials['oauth_token_secret']);

            $authorizationUrl = 'Location: '
                . $this->getBaseUrl('OAuth.action?oauth_token=')
                . $temporaryCredentials['oauth_token'];

            if ($this->supportLinkedSandbox) {
                $authorizationUrl .= '&supportLinkedSandbox=true';
            }

            header($authorizationUrl);

            // the user declined the authorization
        } elseif (!array_key_exists('oauth_verifier', $_GET) && array_key_exists('oauth_token', $_GET)) {
            throw new AuthorizationDeniedException('Authorization declined.');
            //the user authorized the app
        } else {
            $this->token_secret = Session::get('oauth_token_secret');

            $this->params['oauth_token']    = $_GET['oauth_token'];
            $this->params['oauth_verifier'] = $_GET['oauth_verifier'];
            unset($this->params['oauth_callback']);

            return $this->getTemporaryCredentials();
        }

    }

}