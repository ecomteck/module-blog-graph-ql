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
 * Class Tag
 * @package Ecomteck\BlogGraphQl\Model\Resolver
 */
class Tag implements ResolverInterface
{
    /**
     * @var DataProvider\Tag
     */
    private $tagDataProvider;

    /**
     * Tag constructor.
     * @param DataProvider\Tag $tagDataProvider
     */
    public function __construct(DataProvider\Tag $tagDataProvider)
    {
        $this->tagDataProvider = $tagDataProvider;
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
        $tagId = $this->getTagId($args);
        $tagData = $this->getTagData($tagId);
        return  $tagData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getTagId(array $args): int
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Tag id should be specified'));
        }

        return (int)$args['id'];
    }

    /**
     * @param int $tagId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getTagData(int $tagId): array
    {
        try {
            $tagData = $this->tagDataProvider->getData($tagId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $tagData;
    }
}
