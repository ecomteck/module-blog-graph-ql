<?php
/**
 * Ecomteck
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Ecomteck.com license that is
 * available through the world-wide-web at this URL:
 * https://www.ecomteck.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ecomteck
 * @package     Ecomteck_BlogGraphQl
 * @copyright   Copyright (c) Ecomteck (https://www.ecomteck.com/)
 * @license     https://www.ecomteck.com/LICENSE.txt
 */
declare(strict_types=1);

namespace Ecomteck\BlogGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magefan\Blog\Api\CommentRepositoryInterface;

/**
 * Class Comments
 * @package Ecomteck\BlogGraphQl\Model\Resolver
 */
class Comments implements ResolverInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    /**
     * Comments constructor.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->commentRepository = $commentRepository;
    }
    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $searchCriteria = $this->searchCriteriaBuilder->build('ecomteck_blog_comments', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);
        $searchResult = $this->commentRepository->getList($searchCriteria);
        return [
            'total_count' => $searchResult->getTotalCount(),
            'items' => $searchResult->getItems()
        ];
    }
}
