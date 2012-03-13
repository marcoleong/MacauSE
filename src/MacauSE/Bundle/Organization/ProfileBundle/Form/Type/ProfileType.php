<?php 
namespace MacauSE\Bundle\Organization\ProfileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * a form for profile.
 */
class ProfileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('tags','collection', array(
		        'type' => new TagType(),
		        'allow_add' => true,
		        'by_reference' => false,
		    ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MacauSE\Bundle\Organization\ProfileBundle\Document\Profile',
        );
    }

    public function getName()
    {
        return 'profile';
    }
}