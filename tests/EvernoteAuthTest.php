<?php

class EvernoteAuthTest extends FunctionalTest {

    /**
     * @test
     * Test login using Evernote
     */
    public function EvernoteAuthPage() {
        $page = $this->get('evernote-auth/login');

        $this->assertEquals(200, $page->getStatusCode());
        // We should get redirected to evernote authorization url
    }

    /**
     * @test
     * Test login using Evernote
     */
    public function EvernoteAuthCallBackPage() {
        $page = $this->get('evernote-auth/callback');

        $this->assertEquals(200, $page->getStatusCode());
    }
}