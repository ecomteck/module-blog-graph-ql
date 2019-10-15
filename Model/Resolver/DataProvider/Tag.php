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

use Magefan\Blog\Api\TagRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Template\FilterEmulate;

/**
 * Class Tag
 * @package Ecomteck\BlogGraphQl\Model\Resolver\DataProvider
 */
class Tag
{
    /**
     * @var FilterEmulate
     */
    private $widgetFilter;

    /**
     * @var TagRepositoryInterface
     */
    private $tagRepository;

    /**
     * Tag constructor.
     * @param TagRepositoryInterface $tagRepository
     * @param FilterEmulate $widgetFilter
     */
    public function __construct(
        TagRepositoryInterface $tagRepository,
        FilterEmulate $widgetFilter
    ) {
        $this->tagRepository = $tagRepository;
        $this->widgetFilter = $widgetFilter;
    }

    /**
     * @param int $tagId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(int $tagId): array
    {
        $tag = $this->tagRepository->getById($tagId);

        if (false === $tag->isActive()) {
            throw new NoSuchEntityException();
        }

        $renderedContent = $this->widgetFilter->filter($tag->getData('content'));

        $tagData = [
            'url_key' => $tag->getIdentifier(),
            'title' => $tag->getTitle(),
            'meta_robots' => $tag->getData('meta_robots'),
            'meta_description' => $tag->getMetaDescription(),
            'meta_keywords' => $tag->getData('meta_keywords'),
            'meta_title' => $tag->getMetaTitle(),
            'page_layout' => $tag->getData('page_layout'),
            'is_active' => $tag-> isActive(),
            'content' => $renderedContent,
            'layout_update_xml' => $tag->getData('layout_update_xml'),
            'custom_theme' => $tag->getData('custom_theme'),
            'custom_layout' => $tag->getData('custom_layout'),
            'custom_layout_update_xml' => $tag->getData('custom_layout_update_xml'),
            'custom_theme_from' => $tag->getData('custom_theme_from'),
            'custom_theme_to' => $tag->getData('custom_theme_to'),
        ];
        return $tagData;
    }
}
