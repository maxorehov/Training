<?php
declare(strict_types=1);

namespace Training\Feedback\Controller\List;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Training\Feedback\Api\Data\FeedbackInterfaceFactory;
use Training\Feedback\Api\FeedbackRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;

class Test implements ActionInterface
{
    /**
     * @var FeedbackInterfaceFactory
     */
    private $feedbackFactory;

    /**
     * @var FeedbackRepositoryInterface
     */
    private $feedbackRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @param FeedbackInterfaceFactory $feedbackFactory
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        FeedbackInterfaceFactory $feedbackFactory,
        FeedbackRepositoryInterface   $feedbackRepository,
        SearchCriteriaBuilder         $searchCriteriaBuilder,
        SortOrderBuilder              $sortOrderBuilder
    )
    {
        $this->feedbackFactory = $feedbackFactory;
        $this->feedbackRepository = $feedbackRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    public function execute()
    {
// create new item
        $newFeedback = $this->feedbackFactory->create();
        $newFeedback->setAuthorName('some name');
        $newFeedback->setAuthorEmail('test@test.com');
        $newFeedback->setMessage('ghj dsghjfghs sghkfgsdhfkj sdhjfsdf gsfkj');
        $newFeedback->setIsActive(1);
        $this->feedbackRepository->save($newFeedback);
// load item by id
        $feedback = $this->feedbackRepository->getById(1);
        $this->printFeedback($feedback);
// update item
        $feedbackToUpdate = $this->feedbackRepository->getById(1);
        $feedbackToUpdate->setMessage('CUSTOM ' . $feedbackToUpdate->getMessage());
        $this->feedbackRepository->save($feedbackToUpdate);
// delete feedback
        $this->feedbackRepository->deleteById(7);
// load multiple items
        $this->searchCriteriaBuilder
            ->addFilter('is_active', 1);


        $sortOrder = $this->sortOrderBuilder
            ->setField('message')
            ->setAscendingDirection()
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->feedbackRepository->getList($searchCriteria);
        foreach ($searchResult->getItems() as $item) {
            $this->printFeedback($item);
        }
        exit();
    }

    private function printFeedback($feedback)
    {
        echo $feedback->getId() . ' : '
            . $feedback->getAuthorName()
            . ' (' . $feedback->getAuthorEmail() . ')';
        echo "<br/>\n";
    }
}
