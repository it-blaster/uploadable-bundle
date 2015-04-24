<?php

namespace Fenrizbes\UploadableBundle\Form\Type;

use Fenrizbes\UploadableBundle\Form\DataTransformer\UploadableDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadableType extends AbstractType
{
    protected $root_dir;
    protected $options;

    public function __construct($root_dir)
    {
        $this->root_dir = $root_dir;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'uploadable';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array(
                'removable',
                'remove_label'
            ))
            ->setOptional(array(
                'file_constraints'
            ))
            ->setDefaults(array(
                'removable'    => true,
                'remove_label' => 'remove',
                'required'     => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;

        unset($options['removable']);
        unset($options['remove_label']);

        if (isset($options['file_constraints'])) {
            $options['constraints'] = $options['file_constraints'];

            unset($options['file_constraints']);
        }

        $builder
            ->add('file', 'file', array_merge($options, array(
                'compound'   => false,
                'label'      => false,
                'data_class' => '\Symfony\Component\HttpFoundation\File\File'
            )))
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
            )
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                array($this, 'onPreSubmit')
            )
            ->addViewTransformer(
                new UploadableDataTransformer($this->root_dir)
            )
        ;
    }

    /**
     * Adds a remove-field if need
     *
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event)
    {
        if (!$event->getData() || !$event->getForm()->getConfig()->getOption('removable')) {
            return;
        }

        $event->getForm()->add('remove', 'checkbox', array(
            'label' => $this->options['remove_label']
        ));
    }

    /**
     * Forbids to erase a value
     *
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if ($data['file'] instanceof UploadedFile) {
            $event->getForm()->remove('remove');
        }

        if (empty($data['file']) && (!isset($data['remove']) || !$data['remove'])) {
            $event->setData($event->getForm()->getViewData());
        }
    }
}