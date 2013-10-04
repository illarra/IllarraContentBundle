<?php

namespace Illarra\ContentBundle\Form\Filter;

use Illarra\CoreBundle\Form\Filter\FilterType;
use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class ContentType extends FilterType
{
    public function __construct (array $customOptions)
    {
        $this->customOptions = $customOptions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tag', 'filter_text', ['condition_pattern' => FilterOperands::STRING_BOTH]);
        
        $builder->add('tagGroup', 'choice', [
            'required' => false,
            'choices'  => $this->customOptions['tagGroupChoices'],
            'apply_filter'  => function (QueryInterface $filterQuery, $field, $values) {
                if (!empty($values['value'])) {
                    $queryBuilder = $filterQuery->getQueryBuilder()
                        ->andWhere('e.tag LIKE :tag')->setParameter('tag', $values['value']. '.%')
                        ->orderBy('e.tag', 'ASC')
                    ;
                }
            }
        ]);
    }
}
