<?php

/**
 * EvernoteSettings
 *
 * @property string APIKey Api key from Evernote.
 * @property string APISecret Api Secret from Evernote.
 * @property string CallbackURL Callback URL.
 * @property Boolean Sandbox Enable of disable Sandbox.
 * @property Boolean China Type Enable country china.
 *
 * @package EvernoteSettings
 */
class EvernoteSettings extends DataObject {

    private static $db = array(
        "APIKey" => "Varchar",
        "APISecret" => "Varchar",
        "CallbackURL" => "Varchar(512)",
        "Sandbox" => "Boolean",
        "China" => "Boolean"
    );

    /**
  	 * Default permission to check for 'LoggedInUsers' to create or edit pages
  	 *
  	 * @var array
  	 * @config
  	 */
  	private static $required_permission = array('CMS_ACCESS_CMSMain', 'CMS_ACCESS_LeftAndMain');


    /**
     * @return FieldList
     */
    public function getCMSFields() {

      $fields = new FieldList(
        new TabSet("Root",
          $tabMain = new Tab('Evernote',
            $apiKey = new TextField('APIKey', 'API key', $this->APIKey),
            $apiSecret = new TextField('APISecret', 'API secret', $this->APISecret),
            $callbackURL = new TextField('CallbackURL',
                    'CallbackURL - where user will be returned after authenticated from evernote',
                    $this->CallbackURL
            ),
            $sanbox = new CheckBoxField('Sandbox', 'Enable Sandbox', $this->Sandbox),
            $china = new CheckBoxField('China', 'Are you in China?', $this->China)
          )
          ),
          new HiddenField('ID')
        );

        $this->extend('updateCMSFields', $fields);

    		return $fields;
    }

    /**
     * Get the current Evernote Settings, and creates a new one through
     * {@link make_evernote_settings()} if none is found.
     *
     * @return EvernoteSettings
     */
    public static function current_Evernote_settings() {
      if ($evernoteSettings = DataObject::get_one('EvernoteSettings')) return $evernoteSettings;

      return self::make_evernote_settings();
    }

    /**
  	 * Create EvernoteSettings with defaults from language file.
  	 *
  	 * @return EvernoteSettings
  	 */
  	public static function make_evernote_settings() {
  		$config = EvernoteSettings::create();
  		$config->write();

  		return $config;
  	}

    /**
     * Get the actions that are sent to the CMS.
     *
     * In your extensions: updateEditFormActions($actions)
     *
     * @return FieldList
     */
    public function getCMSActions() {
      if (Permission::check('ADMIN')) {
        $actions = new FieldList(
          FormAction::create('save_evernotesettings', _t('CMSMain.SAVE','Save'))
            ->addExtraClass('ss-ui-action-constructive')->setAttribute('data-icon', 'accept')
        );
      } else {
        $actions = new FieldList();
      }

      $this->extend('updateCMSActions', $actions);

      return $actions;
    }
}
