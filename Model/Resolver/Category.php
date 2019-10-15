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

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Class Category
 * @package Ecomteck\BlogGraphQl\Model\Resolver
 */
class Category implements ResolverInterface
{
    /**
     * @var DataProvider\Category
     */
    private $categoryDataProvider;

    /**
     * Category constructor.
     * @param DataProvider\Category $categoryDataProvider
     */
    public function __construct(
        DataProvider\Category $categoryDataProvider
    ) {
        $this->categoryDataProvider = $categoryDataProvider;
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
        $categoryId = $this->getCategoryId($args);
        $categoryData = $this->getCategoryData($categoryId);
        return  $categoryData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getCategoryId(array $args): int
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Category id should be specified'));
        }

        return (int)$args['id'];
    }

    /**
     * @param int $categoryId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getCategoryData(int $categoryId): array
    {
        try {
            $categoryData = $this->categoryDataProvider->getData($categoryId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $categoryData;
    }
}
