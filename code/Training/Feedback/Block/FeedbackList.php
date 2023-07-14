<?php
declare(strict_types=1);

namespace Training\Feedback\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Training\Feedback\Model\ResourceModel\Feedback\CollectionFactory;
use Training\Feedback\Model\ResourceModel\Feedback\Collection;
use Training\Feedback\Model\ResourceModel\Feedback;
use Magento\Framework\Stdlib\DateTime\Timezone;


use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Training\Feedback\Api\FeedbackRepositoryInterface;


class FeedbackList extends Template
{
    const PAGE_SIZE = 5;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var Timezone
     */
    private $timezone;

    /**
     * @var Feedback
     */
    private $feedbackResource;

    /**
     * @var FeedbackRepositoryInterface
     */
    private $repository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderbulder;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Timezone $timezone
     * @param array $data
     */
    public function __construct(
        Context                     $context,
        CollectionFactory           $collectionFactory,
        Timezone                    $timezone,
        Feedback                    $feedbackResource,
        FeedbackRepositoryInterface $repository,
        SearchCriteriaBuilder       $searchCriteriaBuilder,
        SortOrderBuilder            $sortOrderBuilder,
        array                       $data = array()
    )
    {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->timezone = $timezone;
        $this->feedbackResource = $feedbackResource;

        $this->repository = $repository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderbulder = $sortOrderBuilder;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        $currentPage = $this->getRequest()->getParam('p');
        if (!$this->collection) {
            $this->collection = $this->collectionFactory->create();
            $this->collection->addFieldToFilter('is_active', 1);
            $this->collection->setPageSize($this->getLimit());
            $this->collection->setOrder('creation_time', 'DESC');
            if (!empty($currentPage)) {
                $this->collection->setCurPage($currentPage);
            }
        }
        return $this->collection;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        $pagerBlock = $this->getChildBlock('feedback_list_pager');
        if ($pagerBlock instanceof \Magento\Framework\DataObject) {
            /* @var $pagerBlock \Magento\Theme\Block\Html\Pager */
            $pagerBlock
                ->setUseContainer(false)
                ->setShowPerPage(false)
                ->setShowAmounts(false)
                ->setLimit($this->getLimit())
                ->setCollection($this->getCollection());
            return $pagerBlock->toHtml();
        }
        return '';
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return static::PAGE_SIZE;
    }

    /**
     * @return string
     */
    public function getAddFeedbackUrl()
    {
        return $this->getUrl('training_feedback/form/save');
    }

    /**
     * @return string
     */
    public function getAllFeedbackNumber()
    {
        return $this->feedbackResource->getAllFeedbackNumber();
    }

    /**
     * @return string
     */
    public function getActiveFeedbackNumber()
    {
        return $this->feedbackResource->getActiveFeedbackNumber();
    }

    public function test($id)
    {
        $feedback = $this->repository->getById($id);
        $feedback->getExtensionAttributes();

    }

    public function getCollectionFromRepo()
    {
        $currentPage = $this->getRequest()->getParam('p');
        $this->searchCriteriaBuilder->addFilter('is_active', 1);
        $this->searchCriteriaBuilder->setPageSize($this->getLimit());
        if (!empty($currentPage)) {
            $this->searchCriteriaBuilder->setCurrentPage($currentPage);
        }
        $sortOrder = $this->sortOrderbulder
            ->setField('creation_time')
            ->setDescendingDirection()
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $serchResult = $this->repository->getList($searchCriteria);
        return $serchResult->getItems();
    }
}

