<?php

class EvernoteMember extends DataExtension
{

    /**
     * @var array
     */
    private static $db = array(
        "EvernoteToken" => "Varchar(255)",
    );

    /**
     * @return mixed
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField("EvernoteToken", 'Evernote Token', $this->EvernoteToken));

        return $fields;
    }
}
