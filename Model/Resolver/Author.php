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
 * Class Author
 * @package Ecomteck\BlogGraphQl\Model\Resolver
 */
class Author implements ResolverInterface
{
    /**
     * @var DataProvider\Author
     */
    private $authorDataProvider;

    /**
     * Author constructor.
     * @param DataProvider\Author $authorDataProvider
     */
    public function __construct(DataProvider\Author $authorDataProvider)
    {
        $this->authorDataProvider = $authorDataProvider;
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
        $authorId = $this->getAuthorId($args);
        $authorData = $this->getAuthorData($authorId);
        return  $authorData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getAuthorId(array $args): int
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Author id should be specified'));
        }

        return (int)$args['id'];
    }

    /**
     * @param int $authorId
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getAuthorData(int $authorId): array
    {
        try {
            $authorData = $this->authorDataProvider->getData($authorId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $authorData;
    }
}
