<?php

/**
 * @package EvernoteSettings
 */
class EvernoteAdminController extends LeftAndMain
{

    /**
     * @var string
     */
    private static $url_segment = 'evernote-settings';
    /**
     * @var string
     */
    private static $url_rule = '/$Action/$ID/$OtherID';

    /**
     * @var string
     */
    private static $menu_title = 'Evernote';
    /**
     * @var string
     */
    private static $menu_icon = '/silverstripe-evernote/images/evernote.png';


    /**
     * @param null $id Not used.
     * @param null $fields Not used.
     *
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {

        $evernoteSettings = EvernoteSettings::current_Evernote_settings();
        $fields = $evernoteSettings->getCMSFields();

        // Retrieve validator, if one has been setup
        if ($evernoteSettings->hasMethod("getCMSValidator")) {
            $validator = $evernoteSettings->getCMSValidator();
        } else {
            $validator = null;
        }

        $actions = $evernoteSettings->getCMSActions();

        $form = CMSForm::create(
            $this, 'EditForm', $fields, $actions, $validator
        )->setHTMLID('Form_EditForm');

        $form->setResponseNegotiator($this->getResponseNegotiator());
        $form->addExtraClass('cms-content center cms-edit-form');
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));

        if ($form->Fields()->hasTabset()) $form->Fields()->findOrMakeTab('Root')->setTemplate('CMSTabSet');

        $form->addExtraClass('center ss-tabset cms-tabset ' . $this->BaseCSSClasses());
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

        $this->extend('updateEditForm', $form);

        return $form;

    }

    /**
     * Save the current sites {@link SiteConfig} into the database.
     *
     * @param array $data
     * @param Form $form
     * @return String
     */
    public function save_evernotesettings($data, $form)
    {
        $evernoteSettings = EvernoteSettings::current_Evernote_settings();
        $form->saveInto($evernoteSettings);

        try {
            $evernoteSettings->write();
        } catch (ValidationException $ex) {
            $form->sessionMessage($ex->getResult()->message(), 'bad');
            return $this->getResponseNegotiator()->respond($this->request);
        }

        $this->response->addHeader('X-Status', rawurlencode(_t('LeftAndMain.SAVEDUP', 'Saved.')));

        return $form->forTemplate();
    }

}
