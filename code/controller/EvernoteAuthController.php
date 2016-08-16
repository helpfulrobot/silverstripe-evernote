<?php

class EvernoteAuthController extends Controller {

    /**
     * @var array
     */
    private static $allowed_actions = array(
        'login',
    );

    public function login() {

        $Evernote = new Evernote();
        $token = $Evernote->Authorize();
    }

}