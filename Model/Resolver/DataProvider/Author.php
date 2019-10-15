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

namespace Ecomteck\BlogGraphQl\Model\Resolver\DataProvider;

use Magefan\Blog\Api\AuthorRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Template\FilterEmulate;

/**
 * Class Author
 * @package Ecomteck\BlogGraphQl\Model\Resolver\DataProvider
 */
class Author
{
    /**
     * @var FilterEmulate
     */
    private $widgetFilter;

    /**
     * @var AuthorRepositoryInterface
     */
    private $authorRepository;

    /**
     * Author constructor.
     * @param AuthorRepositoryInterface $authorRepository
     * @param FilterEmulate $widgetFilter
     */
    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        FilterEmulate $widgetFilter
    ) {
        $this->authorRepository = $authorRepository;
        $this->widgetFilter = $widgetFilter;
    }

    /**
     * @param int $authorId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(int $authorId): array
    {
        $author = $this->authorRepository->getById($authorId);

        if (false === $author->getData('is_active')) {
            throw new NoSuchEntityException();
        }

        $authorData = [
            'url_key' => $author->getIdentifier(),
            'title' => $author->getTitle(),
            'name' => $author->getName(),
            'url' => $author->getUrl(),
            'author_url' => $author->getAuthorUrl(),
            'creation_time' => $author->getData('creation_time'),
            'is_active' => $author->getData('is_active'),
        ];
        return $authorData;
    }
}
