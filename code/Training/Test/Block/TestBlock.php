<?php

namespace Training\Test\Block;

class TestBlock extends \Magento\Framework\View\Element\AbstractBlock
{
    public function _toHtml()
    {
        return "<b>Hello world from block!</b>";
    }
}
