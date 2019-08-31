<?php

/**
 * This file is part of the DocPHT project.
 * 
 * @author Valentino Pesce
 * @copyright (c) Valentino Pesce <valentino@iltuobrand.it>
 * @copyright (c) Craig Crosby <creecros@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DocPHT\Form;

use DocPHT\Core\Translator\T;
use Nette\Forms\Form;
use Nette\Utils\Html;

class RenamePageForm extends MakeupForm
{
    public function create()
    {
        $id = $_SESSION['page_id'];
        $form = new Form;
        $form->onRender[] = [$this, 'bootstrap4'];

        $form->addText('filename', T::trans('Title'))
            ->setDefaultValue($this->pageModel->getPageTitle($id))
        	->setHtmlAttribute('placeholder', T::trans('Edit title'))
            ->setRequired(T::trans('Enter title'));

        $form->addProtection(T::trans('Security token has expired, please submit the form again'));
		
        $form->addSubmit('submit',T::trans('Rename title'));
            
        if ($form->isSuccess()) {
            $values = $form->getValues();
            
            if(isset($id) && isset($values['filename'])) {
                $this->pageModel->renamePageTitle($id, $values['filename']);
                header('Location:'.$this->pageModel->getTopic($id).'/'.$this->pageModel->getFilename($id));
                exit;
            } else {
                $this->msg->error(T::trans('Sorry something didn\'t work!'),BASE_URL.'page/add-section');
            }
        }

        return $form;
    }
}
