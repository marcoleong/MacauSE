<?php 
namespace MacauSE\DirectoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Type pick out the tag field in Profile, to make Tagedit work.
 */
class TagType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name','text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MacauSE\DirectoryBundle\Document\Tag',
        );
    }

    public function getName()
    {
        return 'tag';
    }
}