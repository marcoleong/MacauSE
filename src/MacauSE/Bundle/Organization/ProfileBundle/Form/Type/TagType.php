<?php 
namespace MacauSE\Bundle\Organization\ProfileBundle\Form\Type;

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
            'data_class' => 'MacauSE\Bundle\Organization\ProfileBundle\Document\Tag',
        );
    }

    public function getName()
    {
        return 'tag';
    }
}