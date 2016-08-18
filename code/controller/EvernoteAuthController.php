<?php

class EvernoteAuthController extends Controller {

    /**
     * @var array
     */
    private static $allowed_actions = array(
        'login','callback',
    );

    /**
     * authenticate with Evernote
     */
    public function login() {

        if( $member = Member::currentUser() ) {
            $Evernote = new Evernote();
            $Evernote->Authorize();

        } else {

            $this->redirect('Security/login/?back=evernote-auth/login');
        }
    }

    /**
     * store token from Evernote and redirect to given url or redirect to home page
     */
    public function callback() {

        if( $member = Member::currentUser() ) {
            $Evernote = new Evernote();
            $Token = $Evernote->Authorize();

            $member->EvernoteToken = $Token;
            $member->write();

            $EvernoteSettings = EvernoteSettings::current_Evernote_settings();

            $url = (!empty($EvernoteSettings->CallbackURL)) ?: '/';

            $this->redirect($url);

        } else {

            $this->redirect('Security/login/?back=evernote-auth/login');
        }
    }

}