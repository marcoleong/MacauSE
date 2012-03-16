<?php

namespace MacauSE\Bundle\MainBundle\SearchRepository;
 
use FOQ\ElasticaBundle\Repository;
 
class MainRepository extends Repository
{
    public function findByPartialName($searchTerm)
    {
        $nameQuery = new \Elastica_Query_Text();
        $nameQuery->setFieldQuery('name', $searchTerm);
        $nameQuery->setFieldParam('name', 'type', 'phrase_prefix');
 
        return $this->find($nameQuery);
    }
}