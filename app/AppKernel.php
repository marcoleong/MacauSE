<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        date_default_timezone_set('Asia/Chongqing');

        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
           	new Symfony\Bundle\SecurityBundle\SecurityBundle(),
	           new Symfony\Bundle\TwigBundle\TwigBundle(),
	           new Symfony\Bundle\MonologBundle\MonologBundle(),
	           new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
	           new Symfony\Bundle\AsseticBundle\AsseticBundle(),
	           new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
	           new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
	           new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
	           new JMS\AopBundle\JMSAopBundle(),

			    new JMS\DiExtraBundle\JMSDiExtraBundle($this),
			    new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),

            new FOQ\ElasticaBundle\FOQElasticaBundle(),

            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
			new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
			new FOS\UserBundle\FOSUserBundle(),
	        // new Mopa\BootstrapBundle\MopaBootstrapBundle(),
	
			new MarcoLeong\Bundle\MercuryEditorBundle\MarcoLeongMercuryEditorBundle(),
            new MacauSE\Bundle\Organization\ProfileBundle\MacauSEOrganizationProfileBundle(),
            new MacauSE\Bundle\MainBundle\MacauSEMainBundle(),
            new MacauSE\UserBundle\MacauSEUserBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            // $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
